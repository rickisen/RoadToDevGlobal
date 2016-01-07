<?php
require_once 'Lobby.class.php';

class LobbyLoader {
	private function __construct(){}
	private function __clone(){}

    static function addUserToPlfl(){
      $database = DB::getInstance();

      $qInserCurrentPlayerIntoPlfl = '
        INSERT INTO player_looking_for_lobby (steam_id)
        VALUES ('.$_SESSION['currentUser']->steamId.')
      ';

      // send the query and print an error if it fails
      if ( !$result = $database->query($qInserCurrentPlayerIntoPlfl)){
        echo "something went wrong when trying to add user to the plfl table: ".$database->error;
      }

      return ['loadview' => 'loadingpage' ];
    }

    static function lookForLobby(){
      $database = DB::getInstance();

      $qAmIInALobby = '
        SELECT * FROM lobby
        WHERE lobby.steam_id = '.$_SESSION['currentUser']->steamId.'
        LIMIT 1
      ';

      $result = $database->query($qAmIInALobby);
      if ($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $lobbyId = $row['lobby_id'];
        $foundLobby = TRUE;
      } else {
        $foundLobby = FALSE;
      }

      if($foundLobby) {
          return Lobby::viewLobby();
      } else {
          return ['loadview' => 'loadingpage' ];
      }
    }
}
