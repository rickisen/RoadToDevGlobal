<?php

class Profile{
	private function __construct(){}
	private function __clone(){}

	static function displayUser($id){
		return ['loadview' => 'playerprofile', 'user' => new User($id[0]) ];
	}
}
