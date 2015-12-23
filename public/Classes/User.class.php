<?php
class User{
  private 
    $steamId,
    $rank,
    $age,
    $bio,
    $kd_ratio,
    $registerDate,
    $image_l,
    $image_m,
    $image_s,

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
      $this->image_l       = $row['image_l'];
      $this->image_m       = $row['image_m'];
      $this->image_s       = $row['image_s'];

      $this->kd_ratio = $this->kills / $this->deaths ;
      $this->exists = TRUE;
    } else {
      $this->exists = FALSE;
    }
    $this->steamId = $steamId;
  }
  
  function updateSteamStats($nickname, $kills, $deaths, $hoursPlayed, $image_l, $image_m, $image_s){
    $this->nickname    = $nickname ;
    $this->kills       = $kills ;
    $this->deaths      = $deaths ;
    $this->image_l     = $image_l ;
    $this->image_m     = $image_m ;
    $this->image_s     = $image_s ;
    $this->hoursPlayed = $hoursPlayed ;
  }
}
