<?php
class User{
  private 
    $steamId,
    $rank,
    $age,
    $bio,
    $kdRatio,
    $registerDate,
    $imageL,
    $imageM,
    $imageS,

    $nickname,
    $kills,
    $deaths,
    $hoursPlayed;

  private $roles = array();
  private $languages = array();

  private $exists ;

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

    if( $result = $database->query($qGetUserFromId) ){
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

      $this->kdRatio = $this->kills / $this->deaths ;
      $this->exists = TRUE;
    } else {
      $this->exists = FALSE;
    }
    $this->steamId = $steamId;
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
}
