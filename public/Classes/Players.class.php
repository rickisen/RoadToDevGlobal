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

		return ['loadview' => 'players', 'users' => $users ];
	}

}
