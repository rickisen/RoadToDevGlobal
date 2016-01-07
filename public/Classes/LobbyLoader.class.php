<?php
require_once 'Lobby.class.php';

class LobbyLoader {
	private function __construct(){}
	private function __clone(){}

	static function searchLobby(){
		if($findingLobby = true) {
			return ['loadview' => 'loadingpage' ];
		} else {
			return ['loadview' => 'lobby' ];
		}

	}
}
