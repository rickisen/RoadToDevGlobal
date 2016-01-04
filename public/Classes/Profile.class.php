<?php

class Profile{
	private function __construct(){}
	private function __clone(){}

	static function displayUser($id){
		$user = new User($id[0]);
		$user->fetchSteamStats();
		return ['loadview' => 'playerprofile', 'user' => $user ];
	}
}
