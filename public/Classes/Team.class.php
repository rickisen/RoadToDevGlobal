<?php

class Team {

  // From db
  private
  $id,
  $creator,
  $name,
  $descr,
  $img,

  //team members
  $members = array();

  function __isset($val){
    return isset($this->$val);
  }

  function __get($val){
    return $this->$val;
  }

  function __construct($teamId){
    $database = DB::getInstance();

    $qGetTeamFromId = '
    SELECT team.*
    FROM team
        WHERE team.id = '.$teamId.'
        LIMIT 1
    ';

    // should hold one row if succesfull,
    // and if there was no such Team
    // it should hold no rows
    $result = $database->query($qGetTeamFromId);
    if( $result->num_rows > 0 ){
      $row = $result->fetch_assoc();
      $this->id          = $row['id'];
      $this->creator     = $row['creator'];
      $this->name        = $row['name'];
      $this->descr       = $row['descr'];
      $this->img         = $row['img'];

      $database->query($qGetTeamFromId);
    }
}

  function getMembers() {
    $database = DB::getInstance();

    $qGetTeamMembers = '
    SELECT user.steam_id
    FROM user
        WHERE user.in_team = '.$this->id.'
        LIMIT 5
    ';

    $result = $database->query($qGetTeamMembers);
    if($result->num_rows == 5) {
      while($row = $result->fetch_assoc()) {
        $this->members[] = new User($row['steam_id']);
      }
    }
  }
}
