<?php

$database = DB::getInstance();

$qGetAllUsers = '
SELECT steam_id, born
FROM user
';

$thisYear = date('Y');

$users = array();
if( $result = $database->query($qGetAllUsers)){
  while ($row = $result->fetch_assoc()){
    $users[] = new User($row['steam_id'], $thisYear - $row['born']);
  }
} elseif ($error = $database->error){
  echo $error;
}

foreach($users as $user){
  $user->updateDb();
}


// CLASSES =====================================================================
class user{
  private $steam_id;
  private $ageGroup;

  function __get($val){
    return $this->$val;
  }
  function __construct($steam_id, $age){
   $this->steam_id = $steam_id ;
   $this->convertToAgeGroup($age) ;
  }
  
  function setAgeGroup($ageGroup){
    $this->ageGroup = $ageGroup;
  }

  function convertToAgeGroup($age){
    switch($age){
      case ($age >= 0 && $age <= 9):
        $this->ageGroup = 'cry_babies';
        break;

      case ($age >= 10 && $age <= 15):
        $this->ageGroup = 'squeekers';
        break;

      case ($age >= 16 && $age <= 19):
        $this->ageGroup =  'teenage_dirtbags';
        break;

      case ($age >= 20 && $age <= 30):
        $this->ageGroup =  'young_adults';
        break;

      case ($age >= 31 && $age <= 50):
        $this->ageGroup =  'old_farts';
        break;

      default:
        $this->ageGroup =  'trollz';
        break;
    }
  }

  function updateDb(){
    $database = DB::getInstance();
    $qUpdateDb = ' UPDATE user SET age_group = "'.$this->ageGroup.'" where steam_id = '.$this->steam_id.' ';
    $database->query($qUpdateDb);
    if ($error = $database->error)
      echo "something went wrong when trying to update user ageGroup ".$this->steam_id." : $error ";
  }
}

class DB{
  private static $instance;
  private function __construct(){}
  private function __clone(){}

  public static function getInstance(){
    if(!self::$instance){
        $config = parse_ini_file('mysqliConfig.ini');
      self::$instance = new mysqli($config['host'], $config['user'], $config['password'], $config['database']);
      return self::$instance;
    }else{
      return self::$instance;
    }
  }
}
