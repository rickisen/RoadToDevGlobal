<?php
class User{
  private static $steamApiKey = "EC3378BE4E67D544BEA9E6D9B32B5B57";
  private $steamId;
  private $existed;

  private 
    // user specified
    $rank,
    $age,
    $bio,

    //calculated
    $kdRatio,
    $registerDate,

    // from steamAPI
    $nickname,
    $kills,
    $deaths,
    $imageL,
    $imageM,
    $imageS,
    $hoursPlayed;

  // support multiple values
  private $roles = array();
  private $languages = array();

  function __isset($val){
    return isset($this->$val);
  }

  function __get($val){
    return $this->$val;
  }

  function __construct( $steamId ){
    $database = DB::getInstance();

    $qGetUserFromId = '
      SELECT * FROM user WHERE steam_id = '.$steamId.' LIMIT 1
    ';

    // svae the steam Id first since som memberfunctions 
    // depend on it when fetching other info
    $this->steamId = $steamId;

    // should hold one row if succesfull,
    // and if there was no such User
    // it should hold no rows
    $result = $database->query($qGetUserFromId);
    if( $result->num_rows > 0 ){
      $row = $result->fetch_assoc();
      $this->rank          = $row['rank'];
      $this->age           = $row['age'];
      $this->bio           = $row['bio'];
      $this->kills         = $row['kills'];
      $this->deaths        = $row['deaths'];
      $this->hoursPlayed   = $row['hours_played'];
      $this->registerDate  = $row['register_date'];
      $this->nickname      = $row['nickname'];
      $this->imageL        = $row['image_l'];
      $this->imageM        = $row['image_m'];
      $this->imageS        = $row['image_s'];

      // calculate kd_ratio, fails if divided by 0, sooo
      if ($this->kills > 0 && $this->deaths > 0) 
        $this->kdRatio = $this->kills / $this->deaths ;
      else
        $this->kdRatio = 0;

      // remeber that this is an old user.
      $this->existed = TRUE;

    } else {
      // if we didnt find a user in the db with this steam id, we create one

      // query to insert a empty user into the db
      $qInsertUser = '
        INSERT INTO user (steam_id, rank, nickname, hours_played, kills, deaths, image_l, image_m, image_s) 
        VALUES (\''.$steamId.'\', "Unknown" , 0, 0, 0, 0, 0, 0, 0) ';

      // send the query and report any errors
      $database->query($qInsertUser);
      if ($database->error){
        echo "something went wrong when inserting a new User".$database->error;
      }

      // The qInsertUser-query only inserts empty steam-values into the db (0),
      // so we need to fetch data from steam-API after the user is created 
      // (at the end of fetchSteamStats, updateSteamStats is run to sync with the db)
      $this->fetchSteamStats();
      $this->existed = FALSE; // mark this user as a new user
    }
  }
  
  function updateSteamStats($nickname, $kills, $deaths, $hoursPlayed, $image_l, $image_m, $image_s){
    $database = DB::getInstance();

    // get the changes localy and clean them
    $this->nickname    = $database->real_escape_string(stripslashes($nickname)) ;
    $this->kills       = $database->real_escape_string(stripslashes($kills)) ;
    $this->deaths      = $database->real_escape_string(stripslashes($deaths)) ;
    $this->imageL      = $database->real_escape_string(stripslashes($image_l)) ;
    $this->imageM      = $database->real_escape_string(stripslashes($image_m)) ;
    $this->imageS      = $database->real_escape_string(stripslashes($image_s)) ;
    $this->hoursPlayed = $database->real_escape_string(stripslashes($hoursPlayed)) ;

    // then update fresh info into DB
    $qUpdateDB = ' 
    UPDATE user 
    SET nickname     = "'.$this->nickname.'",
        kills        = "'.$this->kills.'",
        deaths       = "'.$this->deaths.'",
        image_l      = "'.$this->imageL.'",
        image_m      = "'.$this->imageM.'",
        image_s      = "'.$this->imageS.'",
        hours_played = "'.$this->hoursPlayed.'"
    WHERE steam_id = "'.$this->steamId.'";
                    ';

    // send the query
    $result = $database->query($qUpdateDB);
    
    // print the error if we got one 
    if ($database->error) {
      echo "something went wrong when updating the user data".$database->error;
    }
  }

  function fetchSteamStats(){
    // get what we need from steam api version 1
    $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".self::$steamApiKey."&steamids=".$this->steamId;
    $api_1_decoded = json_decode(file_get_contents($url));

    // get what we need from steam api version 2
    $url2 = "http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=730&key=".self::$steamApiKey."&steamid=".$this->steamId;
    $api_2_decoded = json_decode(file_get_contents($url2), true);

    // make a clearer assoc array from the api 2 responce
    $api_2_array = array();
    foreach ($api_2_decoded['playerstats']['stats'] as $stat) {
        $api_2_array[$stat["name"]] = $stat["value"];
    }

    $nickname    = $api_1_decoded->response->players[0]->personaname;
    $image_s     = $api_1_decoded->response->players[0]->avatar;
    $image_m     = $api_1_decoded->response->players[0]->avatarmedium;
    $image_l     = $api_1_decoded->response->players[0]->avatarfull;
    $kills       = $api_2_array['total_kills'];
    $deaths      = $api_2_array['total_deaths'];
    $hoursPlayed = round(((float) $api_2_array['total_time_played'] / 60 / 60 )); #might need some mathematical fix

    $this->updateSteamStats($nickname, $kills, $deaths, $hoursPlayed, $image_l, $image_m, $image_s);
  }
}
