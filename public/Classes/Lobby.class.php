<?php

class Lobby {
	private function __construct(){}
	private function __clone(){}

	static function viewLobby(){
      $database = DB::getInstance();

      // if someone tries to hackinto another 
      // lobby send them back to the landingpage
      if (empty($_SESSION['currentUser']->inLobby)) {
		return ['loadview' => 'landingpage' ];
      }

      $lobbyID    = $_SESSION['currentUser']->inLobby;
      $mySteamID  = $_SESSION['currentUser']->steamId;
      $lobbyMates = array();

      $qGetLobbyMates = '
        SELECT steam_id
        FROM lobby 
        WHERE lobby_id  = "'.$lobbyID.'"
          AND steam_id != "'.$mySteamID.'"
      ';

      if( $result = $database->query($qGetLobbyMates)){
          while ($row = $result->fetch_assoc()) {
              $lobbyMates[] = new User($row['steam_id']);
          }
      } else {
          echo "Failed to get users from Lobby: $lobbyID : ".$database->error;
      }

      return ['loadview' => 'lobby', 'lobbyMates' => $lobbyMates];
	}
}
