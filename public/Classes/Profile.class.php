<?php

class Profile{
	private function __construct(){}
	private function __clone(){}

	static function displayUser($id){
		return ['loadview' => 'profile', 'user' => new User($id) ];
	}
}
