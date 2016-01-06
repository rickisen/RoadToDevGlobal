<?php
require_once 'Classes/User.class.php';

class Players{
	private function __construct(){}
	private function __clone(){}

	static function viewUserProfiles(){
		$database = DB::getInstance();
		$users = array();

		$qGetAllUsers = '
			SELECT steam_id FROM user
			LIMIT 24;
		';

		if( $result = $database->query($qGetAllUsers)){
			while ($row = $result->fetch_assoc()) {
				$users[] = new User($row['steam_id']);
			}
		} else {
			echo "Failed to get users from DB".$database->error;
		}

                /* // update the steam stats for all the players, only use for debug
                foreach ($users as $user) 
                $user->fetchSteamStats(); 
                */

		return ['loadview' => 'players', 'users' => $users ];
	}

	static function filterUsers($attributes){

		$database = DB::getInstance();
    	$attributes = "";

    	$clauses = array();

    	if( isset($_POST['language'])&& !empty($_POST['language']) ){
    		$languageClause  = ' language = ';
			$languageClause .= $database->real_escape_string(stripcslashes($_POST['language']));
			$clauses[] = $languageClause;
    	}

    	if( isset($_POST['rank'])&& !empty($_POST['rank']) ){
			$rankClause  = ' rank = "';
			$rankClause .= $database->real_escape_string(stripcslashes($_POST['rank']));
			$rankClause .= '"';
			$clauses[] = $rankClause;
    	}

    	if( isset($_POST['hours'])&& !empty($_POST['hours']) ){
			$hoursClause  = ' hours_played > ';
			$hoursClause .= $database->real_escape_string(stripcslashes($_POST['hours']));
			$clauses[] = $hoursClause;
    	}

    	$finalClause = ' WHERE ';

    	foreach ($clauses as $clause) {
    		// If we are not on the first clause, prefix an "AND" .
    		if(!$clauses[0] == $clause){
    			$finalClause .= ' AND ';
    		}

    		$finalClause .= $clause;
    	}

    	$users = array();

		$qGetFilteredUsers = '
			SELECT steam_id FROM user
			'. $finalClause .'
			LIMIT 24;
		';

		if( $result = $database->query($qGetFilteredUsers)){
			while ($row = $result->fetch_assoc()) {
				$users[] = new User($row['steam_id']);
			}
		} else {
			echo "Failed to get users from DB".$database->error;
		}

		return ['loadview' => 'players', 'users' => $users ];
	}

}
