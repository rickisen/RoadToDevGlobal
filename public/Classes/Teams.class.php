<?php
require_once 'Classes/Team.class.php';

class Teams{
  private function __construct(){}
  private function __clone(){}

  static function viewTeams(){
    $database = DB::getInstance();
    $teams = array();

    $qGetTeams = '
    SELECT id
    FROM team
    ORDER BY id DESC
    LIMIT 24
    ';

    $_SESSION['LastFilterQuery'] = $qGetTeams;

    $result = $database->query($qGetTeams);
      if($result->num_rows > 0 ){
        while ($row = $result->fetch_assoc()) {
          $teams[] = new Team($row['id']);

          $database->query($qGetTeams);
        }
    } else {
      echo "Failed to get teams from DB".$database->error;
    }

    return ['loadview' => 'teams', 'teams' => $teams, 'lastOffset' => 0 ];
  }

  static function filterTeams(){

    $database = DB::getInstance();

      $clauses = array();
      if(empty($_POST['team_name']) && empty($_POST['looking_for_players'])){

        return self::viewTeams();
      }

      if( isset($_POST['looking_for_players']) && !empty($_POST['looking_for_players']) ){

      $wantPlayersClause  = ' looking_for_players = "';
      $wantPlayersClause .= $database->real_escape_string(stripslashes($_POST['looking_for_players']));
      $wantPlayersClause .= '"';
      $clauses[] = $wantPlayersClause;
    }


      if( isset($_POST['team_name']) && !empty($_POST['team_name']) ){
        $teamNameClause  = ' name LIKE "%';
        $teamNameClause .= $database->real_escape_string(stripslashes($_POST['team_name']));
        $teamNameClause .= '%"';
        $clauses[] = $teamNameClause;
      }


      $finalClause = ' WHERE ';

      for ($i = 0; $i != count($clauses); $i++) {
        // If we are not on the first clause, prefix an "AND" .
        if($i != 0){
          $finalClause .= ' AND ';
        }

        $finalClause .= $clauses[$i];
      }
      $teams = array();

    $qGetFilteredTeams = '
      SELECT team.id FROM team
      '. $finalClause .'
      LIMIT 24
    ';
      
    // save this query so that we can offset it later
    $_SESSION['LastFilterQuery'] = $qGetFilteredTeams;

    if( $result = $database->query($qGetFilteredTeams)){
      while ($row = $result->fetch_assoc()) {
        $teams[] = new Team($row['id']);
      }
    } else {
      echo "Failed to get teams from DB ".$database->error;
    }

    return ['loadview' => 'teams', 'teams' => $teams, 'lastOffset' => 0 ];
  }

  static function offsetLastFilter($offset){
    $database = DB::getInstance();
    $users = array();
    if (count($offset) > 0 )
      $offset = 24 * $database->real_escape_string(stripslashes($offset[0]));
    else 
      $offset = 0;

    $qGetFilteredOffset = $_SESSION['LastFilterQuery'].' OFFSET '.$offset;

    if( $result = $database->query($qGetFilteredOffset)){
      while ($row = $result->fetch_assoc()) 
        $teams[] = new Team($row['id']);
    } else {
      echo "failed to get teams from db ".$database->error;
    }

    return ['loadview' => 'teams', 'teams' => $teams, 'lastOffset' => $offset / 24];
  }
}
