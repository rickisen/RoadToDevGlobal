<?php

class postReceiver{
	private function __construct(){}
	private function __clone(){}

	static function profileUpdate(){
		$database = DB::getInstance();

		if( isset($_POST['rank'])&& !empty($_POST['rank']) ){
			$_SESSION['currentUser']->rank = $database->real_escape_string(stripslashes($_POST['rank']));
		}

		if( isset($_POST['age'])&& !empty($_POST['age']) ){
			$_SESSION['currentUser']->age = $database->real_escape_string(stripslashes($_POST['age']));
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

    static function logout(){
        unset($_SESSION['currentUser']);
        unset($_SESSION['steamId']);
    }

}