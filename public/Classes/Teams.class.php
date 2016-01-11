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

}
