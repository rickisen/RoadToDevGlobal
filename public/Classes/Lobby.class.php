<?php

class Lobby {
	private function __construct(){}
	private function __clone(){}

	static function viewLobby(){
    $database = DB::getInstance();

    // if someone tries to hackinto another
    // lobby send them back to the landingpage
    if ($_SESSION['currentUser']->inLobby == 'nolobby') {
	   return ['loadview' => 'landingpage' ];
    }

    $lobbyId    = $_SESSION['currentUser']->inLobby;
    $mySteamID  = $_SESSION['currentUser']->steamId;
    $lobbyMates = array();

    $qGetLobbyMates = '
      SELECT *
      FROM lobby 
      WHERE lobby_id  = "'.$lobbyId.'"
    ';

    $result = $database->query($qGetLobbyMates);
    if( $result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        if($row['is_leader'] == 1 ){
          $leader = new User($row['steam_id']);
        }        
        $lobbyMates[] = new User($row['steam_id']);
      }
    } else {
        echo "Failed to get users from Lobby: $lobbyId : ".$database->error;
    }
    return ['loadview' => 'lobby', 'lobbyMates' => $lobbyMates, 'lobbyId' => $lobbyId, 'leader' => $leader];
  }
}
