<?php

class Profile{
	private static $instance;
	private function __construct(){}
	private function __clone(){}

	function displayUser($id){
		return ['loadview' => 'profile', 'user' => new User($id) ];
	}
}
