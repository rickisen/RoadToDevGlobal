<?php

class postReceiver{
	private function __construct(){}
	private function __clone(){}

	static function profileUpdate(){

		$database = DB::getInstance();

		if(isset($_POST['rank'])){
			$_SESSION['currentUser']->rank = $database->real_escape_string(stripslashes($_POST['rank']));
		}

		if(isset($_POST['age'])){
			$_SESSION['currentUser']->age = $database->real_escape_string(stripslashes($_POST['age']));
		}

		if(isset($_POST['bio'])){
			$_SESSION['currentUser']->bio = $database->real_escape_string(stripslashes($_POST['bio']));
		}

		$_SESSION['currentUser']->updateUserSuppliedInfo();
		header('Location: ' . '?/Profile/displayUser/' . $_SESSION['currentUser']->steamId);
	}
}