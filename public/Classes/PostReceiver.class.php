<?php

class postReceiver{
	private function __construct(){}
	private function __clone(){}

	static function profileUpdate(){
		$database = DB::getInstance();

		if( isset($_POST['rank'])&& !empty($_POST['rank']) ){
			$_SESSION['currentUser']->rank = $database->real_escape_string(stripslashes($_POST['rank']));
		}

		if( isset($_POST['born'])&& !empty($_POST['born']) ){
			$_SESSION['currentUser']->born = $database->real_escape_string(stripslashes($_POST['born']));
		}

		if( isset($_POST['country'])&& !empty($_POST['country']) ){
			$_SESSION['currentUser']->country = $database->real_escape_string(stripslashes($_POST['country']));
		}

		if( isset($_POST['bio'])&& !empty($_POST['bio']) ){
			$_SESSION['currentUser']->bio = $database->real_escape_string(stripslashes($_POST['bio']));
		}

		if( isset($_POST['primary_language'])&& !empty($_POST['primary_language']) ){
			$_SESSION['currentUser']->priLang = $database->real_escape_string(stripslashes($_POST['primary_language']));
		}

		if( isset($_POST['secondary_language'])&& !empty($_POST['secondary_language']) ){
			$_SESSION['currentUser']->secLang = $database->real_escape_string(stripslashes($_POST['secondary_language']));
		}

		$_SESSION['currentUser']->updateUserSuppliedInfo();
		header('Location: ' . '?/Profile/displayUser/'.$_SESSION['currentUser']->steamId);
	}

	static function createTeam(){
		$database = DB::getInstance();

		if (isset($_POST['team_name']) && !empty($_POST['team_name']) && isset($_POST['team_desc']) && !empty($_POST['team_desc']) && isset($_POST['team_img']) && !empty($_POST['team_img'])) {

			$team_creator = $database->real_escape_string($_SESSION['currentUser']->steamId);
			$team_name = $database->real_escape_string($_POST['team_name']);
			$team_desc = $database->real_escape_string($_POST['team_desc']);
			$team_img = $database->real_escape_string($_POST['team_img']);

			$qInsertTeam = '
					INSERT INTO team (creator, name, descr, img)
		      VALUES (\''.$team_creator.'\' , \''.$team_name.'\',\''.$team_desc.'\', \''.$team_img.'\' )';

					$database->query($qInsertTeam);

			if ($database->error) {
				echo "something went wrong when updating the user data".$database->error;
			}

			header('Location: ' . '?/TeamProfile/Team/');
		}
	}

    static function logout(){
        unset($_SESSION['currentUser']);
        unset($_SESSION['steamId']);
    }

}
