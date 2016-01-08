<?php
class User{
  private static $steamApiKey = "EC3378BE4E67D544BEA9E6D9B32B5B57";
  private $steamId;
  private $existed;
  private $inLobby =  'nolobby';

  public
    // user specified
    $rank,
    $age,
    $born,
    $bio,
    $country,
    $priLang,
    $secLang;

  private
    // calculated
    $kdRatio,
    $registerDate,

    // rank image
    $rankImg,

    // from steamAPI
    $nickname,
    $isPrivateAcc,
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

  function setLobby($lobbyID){
    $this->inLobby = $lobbyID ;
  }

  // function __set($prop, $val){
  //   if($prop == 'rank' || $prop == 'bio' || $prop == 'age')
  //     $this->$prop = $val;
  // }

  function __construct( $steamId ){
    $database = DB::getInstance();

    $qGetUserFromId = '
      SELECT user.* , rank_img.img
      FROM user LEFT JOIN rank_img
        ON user.rank = rank_img.rank
      WHERE steam_id = '.$steamId.' LIMIT 1
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
      $this->born          = $row['born'];
      $this->country       = $row['country'];
      $this->bio           = $row['bio'];
      $this->kills         = $row['kills'];
      $this->deaths        = $row['deaths'];
      $this->hoursPlayed   = $row['hours_played'];
      $this->registerDate  = $row['register_date'];
      $this->nickname      = $row['nickname'];
      $this->imageL        = $row['image_l'];
      $this->imageM        = $row['image_m'];
      $this->imageS        = $row['image_s'];
      $this->isPrivateAcc  = $row['is_private_acc'];
      $this->rankImg       = $row['img'];
      $this->priLang       = $row['primary_language'];
      $this->secLang       = $row['secondary_language'];

      // calculate kd_ratio, fails if divided by 0, sooo
      if ($this->kills > 0 && $this->deaths > 0)
        $this->kdRatio = round($this->kills / $this->deaths, 2);
      else
        $this->kdRatio = 0;

      // remeber that this is an old user.
      $this->existed = TRUE;

    } else {
      // if we didnt find a user in the db with this steam id, we create one

      // query to insert a empty user into the db
      $qInsertUser = '
        INSERT INTO user (steam_id, rank, nickname, hours_played, kills, deaths, image_l, image_m, image_s, is_private_acc)
        VALUES (\''.$steamId.'\', "unknown" , 0, 0, 0, 0, 0, 0, 0, 0) ';

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

  function updateSteamStats($nickname, $kills, $deaths, $hoursPlayed, $image_l, $image_m, $image_s, $isPrivateAcc){
    $database = DB::getInstance();

    // get the changes localy and clean them
    $this->nickname     = $database->real_escape_string(stripslashes($nickname)) ;
    $this->kills        = $database->real_escape_string(stripslashes($kills)) ;
    $this->deaths       = $database->real_escape_string(stripslashes($deaths)) ;
    $this->imageL       = $database->real_escape_string(stripslashes($image_l)) ;
    $this->imageM       = $database->real_escape_string(stripslashes($image_m)) ;
    $this->imageS       = $database->real_escape_string(stripslashes($image_s)) ;
    $this->hoursPlayed  = $database->real_escape_string(stripslashes($hoursPlayed)) ;
    $this->isPrivateAcc = $database->real_escape_string(stripslashes($isPrivateAcc)) ; #do we need strip/res?

    if($isPrivateAcc) $isPrivateAcc = 1;
    else $isPrivateAcc = 0;

    // then update fresh info into DB
    $qUpdateDB = '
    UPDATE user
    SET nickname       = "'.$this->nickname.'",
        kills          = "'.$this->kills.'",
        deaths         = "'.$this->deaths.'",
        image_l        = "'.$this->imageL.'",
        image_m        = "'.$this->imageM.'",
        image_s        = "'.$this->imageS.'",
        hours_played   = "'.$this->hoursPlayed.'",
        is_private_acc = "'.$this->isPrivateAcc.'"
    WHERE steam_id     = "'.$this->steamId.'";
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
    if($api_2_json = @file_get_contents($url2)) #any error messages that might be generated by that expression will be ignored with the @ operator / in this case that the user has a private profile on steam
      $api_2_decoded = json_decode(file_get_contents($url2), TRUE);
    else
      $this->isPrivateAcc = TRUE;

    $nickname    = $api_1_decoded->response->players[0]->personaname;
    $image_s     = $api_1_decoded->response->players[0]->avatar;
    $image_m     = $api_1_decoded->response->players[0]->avatarmedium;
    $image_l     = $api_1_decoded->response->players[0]->avatarfull;
    if(!$this->isPrivateAcc){
      // make a clearer assoc array from the api 2 responce
      $api_2_array = array();
      foreach ($api_2_decoded['playerstats']['stats'] as $stat) {
          $api_2_array[$stat["name"]] = $stat["value"];
      }
      $kills       = $api_2_array['total_kills'];
      $deaths      = $api_2_array['total_deaths'];
      $hoursPlayed = round(((float) $api_2_array['total_time_played'] / 60 / 60 )); #might need some mathematical fix
    }else{
      $kills       = "";
      $deaths      = "";
      $hoursPlayed = "";
    }

    $this->updateSteamStats($nickname, $kills, $deaths, $hoursPlayed, $image_l, $image_m, $image_s, $this->isPrivateAcc);
  }

  function updateUserSuppliedInfo(){
    $database = DB::getInstance();

    $qUpdateUserSuppliedInfo = '
      UPDATE user
      SET bio                = "'.$this->bio.'",
          age                = "'.date('Y') - $this->born.'",
          born               = "'.$this->born.'",
          country            = "'.$this->country.'",
          rank               = "'.$this->rank.'",
          primary_language   = "'.$this->priLang.'",
          secondary_language = "'.$this->secLang.'",
          age_group          = "'.$this->getAgeGroup().'"
      WHERE steam_id         = "'.$this->steamId.'";
    ';

    $database->query($qUpdateUserSuppliedInfo);
      if ($database->error){
        echo "something went wrong when updating Update User Supplied Info".$database->error;
      }
  }
  // this method returns which age group the user should be inserted to
  function getAgeGroup(){
    switch($this->age){
      case ($this->age >= 0 && $this->age <= 9):
        return 'cry_babies';
        break;

      case ($this->age >= 10 && $this->age <= 15):
        return 'squeekers';
        break;

      case ($this->age >= 16 && $this->age <= 19):
        return 'teenage_dirtbags';
        break;
      
      case ($this->age >= 20 && $this->age <= 30):
        return 'young_adults';
        break;

      case ($this->age >= 31 && $this->age <= 50):
        return 'old_farts';
        break;

      default:
        return 'trollz';
        break;      
    } 
  }
}
