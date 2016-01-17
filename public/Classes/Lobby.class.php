<?php

class Lobby {
  private function __construct(){}
  private function __clone(){}

  static function viewLobby(){
    $database = DB::getInstance();

    // get currentUsers  lobby 
    $qWhatIsMyLobby = '
      SELECT lobby_id FROM lobby
      WHERE lobby.steam_id = '.$_SESSION['currentUser']->steamId.'
      LIMIT 1
    ';

    $result = $database->query($qWhatIsMyLobby) ;
    if ($result->num_rows > 0)
      $lobbyId = $result->fetch_assoc()['lobby_id'];
    else {
      // if someone got here without beeinng in a lobby, something went 
      // wrong or they are hacking, send them home
      return ['loadview' => 'landingpage'];
    }

    $qGetLobbyMates = '
      SELECT *
      FROM lobby 
      WHERE lobby_id  = "'.$lobbyId.'"
    ';

    $lobbyMates = array();
    $result = $database->query($qGetLobbyMates);
    if( $result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        if($row['is_leader'] == 1 ){
          $leader = new User($row['steam_id']);
          $lobbyQuality = $row['quality'];
          $lobbyCreated = $row['created'];
        }        
        $lobbyMates[] = new User($row['steam_id']);
      }
    } elseif ($error = $database->error){
        echo "Failed to get users from Lobby $lobbyId : $error";
    }
    return ['loadview' => 'lobby', 'lobbyMates' => $lobbyMates, 'lobbyId' => $lobbyId, 
      'lobbyQuality' => $lobbyQuality, 'lobbyCreated' => $lobbyCreated ,'leader' => $leader];
  }

  static function leaveLobby(){
    $database = DB::getInstance();

    $qRemoveFromLobby = ' DELETE from lobby where steam_id = '.$_SESSION['currentUser']->steamId.' limit 1 ';
    $database->query($qRemoveFromLobby);
    $_SESSION['currentUser']->setInALobby(FALSE);

    if ($error = $database->error){
      echo "Something went wrong when trying to exit a lobby: $error";
      $_SESSION['currentUser']->setInALobby(TRUE);
    }
    return ['loadview' => 'landingpage'];
  }
}
