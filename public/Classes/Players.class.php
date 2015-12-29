<?php

class Players{
	private function __construct(){}
	private function __clone(){}

	static function viewUserProfiles(){
		$database = DB::getInstance();

		$qGetAllUsers = '
			SELECT steam_id FROM user;
		';

		return ['loadview' => 'players' ];
	}
}
