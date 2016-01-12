<?php
require_once 'Classes/Team.class.php';

class Teams{
	private function __construct(){}
	private function __clone(){}

	static function viewTeams(){
		$database = DB::getInstance();
		$teams = array();

		$qGetTeams = '
		SELECT id FROM team
				LIMIT 24
		';

		$result = $database->query($qGetTeams);

			if($result->num_rows > 0 ){
				while ($row = $result->fetch_assoc()) {
					$teams[] = new Team($row['id']);

					$database->query($qGetTeams);
				}
		} else {
			echo "Failed to get teams from DB".$database->error;
		}

		return ['loadview' => 'teams', 'teams' => $teams ];
	}

	static function filterTeams(){

		$database = DB::getInstance();

    	$clauses = array();
    	if(empty($_POST['team_name']) && empty($_POST['looking_for_players'])){

    		return self::viewTeams();
    	}

    	if( isset($_POST['need_players']) && !empty($_POST['need_players']) ){

    		$wantPlayersClause  = ' looking_for_players = "';
			$wantPlayersClause .= $database->real_escape_string(stripslashes($_POST['need_players']));
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
			SELECT id FROM team
			'. $finalClause .'
			LIMIT 24;
		';

		if( $result = $database->query($qGetFilteredTeams)){
			while ($row = $result->fetch_assoc()) {
				$teams[] = new Team($row['id']);
			}
		} else {
			echo "Failed to get teams from DB".$database->error;
		}

		return ['loadview' => 'teams', 'teams' => $teams ];
	}

}
