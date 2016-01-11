<?php

class TeamProfile{
	private function __construct(){}
	private function __clone(){}

	static function myTeam() {
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

			return ['loadview' => 'teamprofile', 'team' => $team];
		} else {
			return ['loadview' => 'createteam'];
		}



		}

	static function Team($teamId){
		$teamId = $database->real_escape_string(stripslashes($teamId));
		return ['loadview' => 'teamprofile', 'team' => new Team($teamId)];
	}
}
