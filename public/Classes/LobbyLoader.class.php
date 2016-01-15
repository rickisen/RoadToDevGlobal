<?php
require_once 'Lobby.class.php';

class LobbyLoader {
  private function __construct(){}
  private function __clone(){}

  static function addUserToPlfl(){
    $database = DB::getInstance();

    if (self::isUserInLobby())
      return Lobby::viewLobby();
    elseif(self::isUserInPLFL())
      return ['loadview' => 'loadingpage', 'randomTip' => self::getRandomTip() ];

    $qInserCurrentPlayerIntoPlfl = '
      INSERT INTO player_looking_for_lobby (steam_id)
      VALUES ('.$_SESSION['currentUser']->steamId.')
    ';

    // send the query and print an error if it fails
    if ( !$result = $database->query($qInserCurrentPlayerIntoPlfl)){
      if ($error = $database->error)
        echo "something went wrong when trying to add currentUser into PLFL: $error";
    }

    return ['loadview' => 'loadingpage', 'randomTip' => self::getRandomTip() ];
  }

  static function isUserInPLFL(){
    $database = DB::getInstance();

    $qAmIInPLFL = '
      SELECT * FROM player_looking_for_lobby
      WHERE steam_id = '.$_SESSION['currentUser']->steamId.'
      LIMIT 1
    ';

    $result = $database->query($qAmIInPLFL);
    if ($result->num_rows > 0){
      return TRUE;
    }else {
      return FALSE;
    }
  }

  static function isUserInLobby(){
    $database = DB::getInstance();

    $qAmIInALobby = '
      SELECT lobby_id FROM lobby
      WHERE lobby.steam_id = '.$_SESSION['currentUser']->steamId.'
      LIMIT 1
    ';

    $result = $database->query($qAmIInALobby) ;
    if ( $result->num_rows == 1){
      return TRUE;
    } else {
      if ($error = $database->error)
        echo "something went wrong when trying to see if a user is in a lobby: $error";
      return FALSE;
    }
  }

  static function stopLookingForLobby(){
    $database = DB::getInstance();

    $qRemoveUserFromPLFL = '
      DELETE FROM player_looking_for_lobby WHERE steam_id = '.$_SESSION['currentUser']->steamId.'
    ';

    $database->query($qRemoveUserFromPLFL);
    if ($error = $database->error)
      echo "something went wrong when trying to remove a user from player_looking_for_lobby: $error";

    return ['loadview' => 'landingpage'];
  }

  static function lookForLobby(){
    $database = DB::getInstance();

    if (self::isUserInLobby())
      return Lobby::viewLobby();
    else 
      return ['loadview' => 'loadingpage','randomTip' => self::getRandomTip()];
  }

  static function getRandomTip(){
    $tips = array(
      'If you have any questions about the functionalities on the site you might find your answers in the "FAQ" -tab.',
      'If someone is griefing or acting rude you can report always them.',
      'It\'s always better to be nice to other players in the long run.',
      'In the "teams" -tab you can search and apply to teams that meet your criterias',
      'As a premium member you will have access to even more features on the site.',
      'Good luck and have fun!',
      'One player in the lobby will get the leader role and it\'s up to the leader to make sure that you start up a game together.',
      'As soon as you land in a lobby you can join a team chat together with your lobby members',
      'You will know who the lobby leader is by looking at the profile portraits in the lobby.',
      'Feel free to visit our forum at any time'
      );
    $random = mt_rand(0, count($tips)-1);

    return $tips[$random];
  }
}
