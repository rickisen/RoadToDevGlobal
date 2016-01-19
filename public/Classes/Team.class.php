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
  $comments,

  //team members
  $members    = array(),
  $applicants = array();

  function __isset($val){
    if($val != 'members' && $val != 'applicants'){
      return isset($this->$val);
    } elseif($val == 'members'){
      $this->getMembers();
      return isset($this->members);
    }elseif($val == 'applicants'){
      $this->getApplicants();
      return isset($this->applicants);
    }
  }

  function __get($val){
    if($val != 'members' && $val != 'applicants'){
      return $this->$val;
    } elseif($val == 'members'){
      $this->getMembers();
      return $this->members;
    } elseif($val == 'applicants'){
      return $this->getApplicants();
    }
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
    if( $result && $result->num_rows > 0 ){
      $row = $result->fetch_assoc();
      $this->id                = $row['id'];
      $this->creator           = $row['creator'];
      $this->name              = $row['name'];
      $this->descr             = $row['descr'];
      $this->img               = $row['img'];
      $this->lookingForPlayers = $row['looking_for_players']; /*not set in DB*/
    }

    $this->downloadComments();
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
    ';
    if(count($this->members) < 1){
      $result = $database->query($qGetTeamMembers);
      if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $this->members[] = new User($row['steam_id']);
        }
      }
    }
    return $this->members;
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

  function downloadComments() {
    $database = DB::getInstance();

    $qFetchComments = '
    SELECT team_comment.*
    FROM team_comment
    WHERE team_comment.team_id = '. $this->id .'
    ORDER BY team_comment.date DESC
    ';

    $result = $database->query($qFetchComments);
    if($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // $this->comments[] = ['text' => 'hejsan'];
        $this->comments[] = TeamComment::withId($row['id']);
      }
    }elseif($error = $database->error) {
      echo "Failed to get comments from DB ".$error;
    }
  }

  function removePlayerFromTeam($steamId) {
    $database = DB::getInstance();
    //only allows execution if we are the creator OR if we're an member who is removing himself
    if ( $this->creator != $_SESSION['currentUser']->steamId || $_SESSION['currentUser']->steamId != $steamId ) return FALSE;
    //double check that this user was in this team
    $this->getMembers();
    $isInMembers = FALSE;
    foreach ($this->getMembers() as $member){
      if($member->steamId == $steamId) 
        $isInMembers = TRUE;
    }

    if ($isInMembers == TRUE){
      $qUpdateUserInTeam = '
        UPDATE user
        SET in_team       = NULL
        WHERE steam_id    = "'.$steamId.'";
      ';

      $database->query($qUpdateUserInTeam);

      if($error = $database->error){
        echo "Something went wrong when trying to update user: $error";
        return FALSE;
      }
    }else{
      return FALSE;
    }
  }

  function getApplicants(){
    $database = DB::getInstance();

    if(count($this->applicants) == 0){
      $qFetchApplicants = '
        SELECT *
        FROM player_applying_team
        WHERE team_id = '.$this->id.'
      ';
      $result = $database->query($qFetchApplicants);

      if($result->num_rows > 0){    
        while ($row = $result->fetch_assoc()){
          $this->applicants[] = new User($row['steam_id']);
        }
      }elseif($error = $database->error){
        echo "Something went wrong when trying to find applicants: $error"; 
      }
    }
    return $this->applicants;   
  }

  function removeApplicant($steamId){
    $database = DB::getInstance();
    //only allows execution if we are the creator OR if we're an applicant who is removing himself
    if ( $this->creator == $_SESSION['currentUser']->steamId || $_SESSION['currentUser']->steamId == $steamId ){

      $qRemoveApplicant = '
        DELETE 
        FROM player_applying_team
        WHERE team_id = '.$this->id.'
        AND steam_id = '.$steamId.'
      ';

      $database->query($qRemoveApplicant);

      if($error = $database->error){
          echo "Something went wrong when trying to deny a user: $error";
          return FALSE;
      }
    }else{
      echo "You're not allowed to execute this function!";
    }
  }

  function acceptApplicant($steamId){
    $database = DB::getInstance();
    //makes sure only the creator is allowed to proceed
    if($this->creator != $_SESSION['currentUser']->steamId) return FALSE;

    $this->getMembers();
    $appliesToTeam = FALSE;

    foreach($this->getMembers() as $applicant){
      if($applicant->steamId == $steamId){
        $appliesToTeam = TRUE;
      }
    }

    if($appliesToTeam == TRUE){
      $qAcceptApplicant = '
        UPDATE user
        SET in_team       = '.$this->id.'
        WHERE steam_id    = "'.$steamId.'"
        AND in_team IS NULL;
      ';

      $database->query($qAcceptApplicant);

      if($error = $database->error){
          echo "Something went wrong when trying to accept a user: $error";
          return FALSE;
      }
    }else{
      return FALSE;
    }
  }
}
