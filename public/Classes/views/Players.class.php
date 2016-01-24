<?php

class Players{
  private function __construct(){}
  private function __clone(){}

  // might be worth removing
  static function viewUserProfiles(){
    $database = DB::getInstance();
    $users = array();

    $qGetAllUsers = '
      SELECT steam_id FROM user
      ORDER BY register_date
      LIMIT 25
    ';

    $_SESSION['LastFilterQuery'] = $qGetAllUsers;

    if( $result = $database->query($qGetAllUsers)){
      while ($row = $result->fetch_assoc()) {
        $users[] = new User($row['steam_id']);
      }
    } else {
      echo "Failed to get users from DB".$database->error;
    }
    /*
    update the steam stats for all the players, only use for debug
    foreach ($users as $user)
    $user->fetchSteamStats();
    */
    return ['loadview' => 'players', 'users' => $users ];
  }

  static function filterUsers(){
    $database = DB::getInstance();
    $qBaseQuery = '
      SELECT * FROM user 
    ';

    $fullQuery = '';
    $offsetClause = '';
    $qClauses = array();
    $parameters = array(); // saved so we can prefill the inputs in twig later

    if( isset($_GET['language']) && !empty($_GET['language']) ){
      $language = $database->real_escape_string(stripslashes($_GET['language']));
      $prilang = ' ( primary_language = "'.$language.'" '." OR ";
      $seclang = '   secondary_language = "'.$language.'" ) '."\n";

      $qClauses[] = $prilang.$seclang;
      $parameters['language'] = $language;
    }

    if( isset($_GET['rank']) && !empty($_GET['rank']) ){
      $rank = $database->real_escape_string(stripslashes($_GET['rank']));
      $qClauses[] = ' rank = "'.$rank.'" '."\n";
      $parameters['rank'] = $rank;
    }

    if( isset($_GET['hours']) && !empty($_GET['hours']) ){
      $hours = $database->real_escape_string(stripslashes($_GET['hours']));
      $qClauses[] = " hours_played >= $hours \n";
      $parameters['hours'] = $hours;
    }

    if( isset($_GET['nick']) && !empty($_GET['nick']) ){
      $nick = $database->real_escape_string(stripslashes($_GET['nick']));
      $qClauses[] = ' lower(nickname) LIKE lower("%'.$nick.'%") '."\n";
      $parameters['nick'] = $nick;
    }

    if( isset($_GET['offset']) && !empty($_GET['offset']) ){
      $offset = $database->real_escape_string(stripslashes($_GET['offset']));
      $offsetClause = " OFFSET $offset \n";
      $parameters['offset'] = $offset;
    }

    // dont include the word "were" in the query unless we have clauses
    if (count($qClauses) > 0 ){
      $qWhereClause = ' WHERE ';
    } else {
      $qWhereClause = '';
    }

    // construct the where clause
    for ($i = 0 ; $i != count($qClauses) ; $i++){
      $qWhereClause .= $qClauses[$i] ;

      // if we are not on the last clause add an "and" inbetween
      if ($i != count($qClauses) - 1 )
        $qWhereClause .= ' AND ';
    }

    // stitch together the query
    $fullQuery .= $qBaseQuery."\n".$qWhereClause."\n ORDER BY register_date LIMIT 25 "."\n".$offsetClause;

    $users = array();
    if( $result = $database->query($fullQuery) ){
      while ($row = $result->fetch_assoc()) {
        $users[] = new user($row['steam_id']);
      }
    } else {
      echo "failed to get users from db ".$database->error;
    }

    return ['loadview' => 'players', 'users' => $users, 'parameters' => $parameters];
  }

}
