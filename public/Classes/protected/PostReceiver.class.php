<?php

class postReceiver{
	private function __construct(){}
	private function __clone(){}

	static function profileUpdate(){
		$database = DB::getInstance();

		if( isset($_POST['rank']) && !empty($_POST['rank']) ){
			$_SESSION['currentUser']->rank = $database->real_escape_string(stripslashes($_POST['rank']));
		}

		if( isset($_POST['dob_day']) && !empty($_POST['dob_day']) ){
			$_SESSION['currentUser']->dobDay = $database->real_escape_string(stripslashes($_POST['dob_day']));
		}

    if( isset($_POST['dob_month']) && !empty($_POST['dob_month']) ){
      $_SESSION['currentUser']->dobMonth = $database->real_escape_string(stripslashes($_POST['dob_month']));
    }

    if( isset($_POST['dob_year']) && !empty($_POST['dob_year']) ){
      $_SESSION['currentUser']->dobYear = $database->real_escape_string(stripslashes($_POST['dob_year']));
    }

		if( isset($_POST['country']) && !empty($_POST['country']) ){
			$_SESSION['currentUser']->country = $database->real_escape_string(stripslashes($_POST['country']));
		}

		if( isset($_POST['bio']) && !empty($_POST['bio']) ){
			$_SESSION['currentUser']->bio = $database->real_escape_string(stripslashes($_POST['bio']));
		}

		if( isset($_POST['primary_language']) && !empty($_POST['primary_language']) ){
			$_SESSION['currentUser']->priLang = $database->real_escape_string(stripslashes($_POST['primary_language']));
		}

		if( isset($_POST['secondary_language']) && !empty($_POST['secondary_language']) ){
			$_SESSION['currentUser']->secLang = $database->real_escape_string(stripslashes($_POST['secondary_language']));
		}

		if( isset($_POST['region']) && !empty($_POST['region']) ){
			$_SESSION['currentUser']->region = $database->real_escape_string(stripslashes($_POST['region']));
		}

		$_SESSION['currentUser']->updateUserSuppliedInfo();
		header('Location: ' . '?/Profile/displayUser/'.$_SESSION['currentUser']->steamId);
	}

	static function createTeam(){

		$database = DB::getInstance();

		if (isset($_POST['team_name']) && !empty($_POST['team_name']) &&
			isset($_POST['team_descr']) && !empty($_POST['team_descr']) &&
			isset($_POST['team_img']) && !empty($_POST['team_img']) &&
			isset($_POST['looking_for_players']) && !empty($_POST['looking_for_players']) &&
			isset($_POST['team_language']) && !empty($_POST['team_language']));
		{
			$team_name     = $database->real_escape_string(stripslashes($_POST['team_name']));
			$team_descr    = $database->real_escape_string(stripslashes($_POST['team_descr']));
			$team_img      = $database->real_escape_string(stripslashes($_POST['team_img']));
			$team_lfp	   	 = $database->real_escape_string(stripslashes($_POST['looking_for_players']));
			$team_lang     = $database->real_escape_string(stripslashes($_POST['team_language']));

			$team = new Team('emptyObject');
			$team->setInitProperties($_SESSION['currentUser']->steamId, $team_name, $team_descr, $team_img, $team_lfp, $team_lang);
			$team->insertTeam();
		}
		header('Location: ' . '?/TeamProfile/myTeam/');
	}

	static function editTeam() {

		$database = DB::getInstance();

		if ( isset($_POST['edit_team_name']) && !empty($_POST['edit_team_name']) ) {
			$edit_team_name     = $database->real_escape_string(stripslashes($_POST['edit_team_name']));
		}

	 	if ( isset($_POST['edit_team_descr']) && !empty($_POST['edit_team_descr']) ) {
		 $edit_team_descr     = $database->real_escape_string(stripslashes($_POST['edit_team_descr']));
	 	}

	 	if ( isset($_POST['edit_team_img']) && !empty($_POST['edit_team_img']) ) {
			$edit_team_img      = $database->real_escape_string(stripslashes($_POST['edit_team_img']));
		}

		if ( isset($_POST['looking_for_players']) && !empty($_POST['looking_for_players']) ) {
			$edit_lfp      			= $database->real_escape_string(stripslashes($_POST['looking_for_players']));
		}

    if ( isset($_POST['edit_team_lang']) && !empty($_POST['edit_team_lang'])){
			$edit_team_lang 		= $database->real_escape_string(stripslashes($_POST['edit_team_lang']));
		}

		if ( isset($_POST['teamId']) && !empty($_POST['teamId'])){
			$teamId 						= $database->real_escape_string(stripslashes($_POST['teamId']));
		}

		$team = new Team($teamId);
		if($_SESSION['currentUser']->steamId == $team->creator){
			$team->setProperties($_SESSION['currentUser']->inTeam, $_SESSION['currentUser']->steamId, $edit_team_name, $edit_team_descr, $edit_team_img, $edit_lfp, $edit_team_lang);
			$team->updateTeamInfo();
		}

		header('Location: ' . '?/TeamProfile/myTeam/');
	}

	static function receiveComments() {
    $database = DB::getInstance();

		if (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_POST['team_id']) && !empty($_POST['team_id'])) {
		  $text   = $database->real_escape_string(stripslashes($_POST['comment']));
		  $teamId = $database->real_escape_string(stripslashes($_POST['team_id']));
		  // creates a comment and stores it in the DB
		  $teamComment = TeamComment::fromText($text, $teamId);
		}

    header('Location: ' . '?/TeamProfile/Team/'. $teamId);
	}

	// receives the team id value from "Apply to team" button and cleans it
	static function receiveTeamRequest(){
		$database = DB::getInstance();

		if (isset($_POST['teamId']) && !empty($_POST['teamId'])){
			$teamId = $database->real_escape_string(stripslashes($_POST['teamId']));

			$_SESSION['currentUser']->insertTeamRequest($teamId);
		}

    header('Location: ' . '?/TeamProfile/Team/'. $teamId);
	}

  static function removeUserFromTeam(){
    $database = DB::getInstance();

    if(isset($_POST['remove_user']) && !empty($_POST['remove_user']) && isset($_POST['teamId']) && !empty($_POST['teamId'])){
      $removeUser = $database->real_escape_string(stripslashes($_POST['remove_user']));
      $teamId 	  = $database->real_escape_string(stripslashes($_POST['teamId']));

	  	$team = new Team($teamId);
	  	if($_SESSION['currentUser']->steamId == $team->creator || $_SESSION['currentUser']->inTeam == $team->id)
	  		$team->removePlayerFromTeam($removeUser);
	  	if($removeUser == $_SESSION['currentUser']->steamId)
	  		$_SESSION['currentUser']->changeTeam(0);
    }
  }

  static function acceptApplicant(){
  	$database = DB::getInstance();

 		if(isset($_POST['applicant']) && !empty($_POST['applicant']) && isset($_POST['teamId']) && !empty($_POST['teamId'])){
 			$steamId = $database->real_escape_string(stripslashes($_POST['applicant']));
 			$teamId  = $database->real_escape_string(stripslashes($_POST['teamId']));

			$team = new Team($teamId);
	  	if($_SESSION['currentUser']->steamId == $team->creator)
	  		$team->acceptApplicant($steamId);
 		}

    header('Location: ' . '?/TeamProfile/editTeam/');
  }

  static function denyApplicant(){
  	$database = DB::getInstance();

  	if(isset($_POST['applicant']) && !empty($_POST['applicant']) && isset($_POST['teamId']) && !empty($_POST['teamId'])){
 			$steamId = $database->real_escape_string(stripslashes($_POST['applicant']));
 			$teamId  = $database->real_escape_string(stripslashes($_POST['teamId']));

			$team = new Team($teamId);
	  	if($_SESSION['currentUser']->steamId == $team->creator)
	  		$team->removeApplicant($steamId);
 		}

    header('Location: ' . '?/TeamProfile/editTeam/');
  }

  static function logout(){
    unset($_SESSION['currentUser']);
    unset($_SESSION['steamId']);
  }

}
