<?php

class Profile{
	private function __construct(){}
	private function __clone(){}

	static function displayUser($id){
		$user = new User($id[0]);
		$user->fetchSteamStats();
		$database = DB::getInstance();

		$qGetTeamFromId = '
		SELECT team.id
		FROM team
				WHERE team.id = '.$user->inTeam.'
				LIMIT 1
		';

		$result = $database->query($qGetTeamFromId);

		if( $result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$team = new Team($row['id']); }

		return ['loadview' => 'playerprofile', 'user' => $user, 'team' => $team ];
	}
}
