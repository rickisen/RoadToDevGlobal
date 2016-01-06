<?php

class Teams{
	private function __construct(){}
	private function __clone(){}

	static function viewTeams(){
		return ['loadview' => 'teams' ];
	}
}
