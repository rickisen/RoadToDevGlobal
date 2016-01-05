<?php

class Lobby{
	private function __construct(){}
	private function __clone(){}

	static function viewLobby(){
		return ['loadview' => 'lobby' ];
	}
}
