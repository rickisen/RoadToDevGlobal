<?php

class Team {

  // From db
  private
  $id,
  $creator,
  $name,
  $descr,
  $img,
  $lookingForPlayers,

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
    if($teamId == 'emptyObject') return;

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
      $this->id                = $row['id'];
      $this->creator           = $row['creator'];
      $this->name              = $row['name'];
      $this->descr             = $row['descr'];
      $this->img               = $row['img'];
      $this->lookingForPlayers = $row['looking_for_players']; /*not set in DB*/
    }
  }

  function setProperties($id, $creator, $name, $descr, $img, $lookingForPlayers){
    $this->id                  = $id;
    $this->creator             = $creator;
    $this->name                = $name;
    $this->descr               = $descr;
    $this->img                 = $img;
    $this->lookingForPlayers   = $lookingForPlayers;
  }

  function setInitProperties($creator, $name, $descr, $img, $lookingForPlayers){
    $this->creator             = $creator;
    $this->name                = $name;
    $this->descr               = $descr;
    $this->img                 = $img;
    $this->lookingForPlayers   = $lookingForPlayers;
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

  function insertTeam(){
    $database = DB::getInstance();

    $qInsertTeam = '
        INSERT INTO team (creator, name, descr, img, looking_for_players)
        VALUES (\''.$this->creator.'\' , \''.$this->name.'\',\''.$this->descr.'\', \''.$this->img.'\', \''.$this->lookingForPlayers.'\' )
    ';

    $database->query($qInsertTeam);
      if ($database->error) echo "something went wrong when creating a team: ".$database->error;

    $this->id = $database->insert_id;

    $_SESSION['currentUser']->setTeam($this->id);

    // Query to update the currentuser so that he is in this team
    $qUpdateUsersTeamStatus = '
      UPDATE user
      SET in_team = '.$this->id.'
      WHERE steam_id = '.$_SESSION['currentUser']->steamId.'
    ';

    $database->query($qUpdateUsersTeamStatus);
    if ($database->error) {
      echo "something went wrong when adding a user into a team: ".$database->error;
    }
  }

  function updateTeamInfo(){
    $database = DB::getInstance();

    $qUpdateTeamProfile = '
      UPDATE team
      SET name                = "'.$this->name.'",
          descr               = "'.$this->descr.'",
          img                 = "'.$this->img.'",
          looking_for_players = "'.$this->lookingForPlayers.'"
      WHERE id    = "'.$this->id.'"
      ';

    $database->query($qUpdateTeamProfile); 

    if($database->error) echo 'Something went wrong when updating team info: '.$database->error;
  }
}
