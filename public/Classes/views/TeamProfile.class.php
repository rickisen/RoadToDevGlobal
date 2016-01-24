<?php

class TeamProfile{
	private function __construct(){}
	private function __clone(){}

	static function myTeam() {
		$database = DB::getInstance();

		if($_SESSION['currentUser']->inTeam == 0){
			header('Location: ' . '?/Teams/viewTeams');
		}

		$qGetTeamFromId = '
      SELECT team.id
      FROM team
      WHERE team.id = '.$_SESSION['currentUser']->inTeam.'
      LIMIT 1
		';

		$result = $database->query($qGetTeamFromId);

		if( $result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$team = new Team($row['id']);

			return ['loadview' => 'teamprofile', 'team' => $team];
		} else {
			echo 'Did not find team associated to '.$_SESSION['currentUser']->inTeam. $database->error;
		}

	}

	static function editTeam() {
		$database = DB::getInstance();

		$qGetTeamFromId = '
      SELECT team.id
      FROM team
      WHERE team.id = '.$_SESSION['currentUser']->inTeam.'
      LIMIT 1
		';

		$result = $database->query($qGetTeamFromId);

		if( $result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$team = new Team($row['id']);

			return ['loadview' => 'editteam', 'team' => $team];

		} else {
			echo 'Did not find team associated to '.$_SESSION['currentUser']->inTeam. $database->error;
		}
	}

	static function Team($teamIdArr){
		$database = DB::getInstance();
    $teamId = $teamIdArr[0];
		$teamId = $database->real_escape_string(stripslashes($teamId));
    $team = new Team($teamId);
		return ['loadview' => 'teamprofile', 'team' => $team];
	}
}
