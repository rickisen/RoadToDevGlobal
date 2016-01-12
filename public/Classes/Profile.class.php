<?php

class Profile{
	private function __construct(){}
	private function __clone(){}

	static function displayUser($id){
		$database = DB::getInstance();

		$user = new User($id[0]);
		if ($user->inTeam > 0 ){  
			$team = new Team($user->inTeam);
		}

		return ['loadview' => 'playerprofile', 'user' => $user, 'team' => $team ];
	}
}
