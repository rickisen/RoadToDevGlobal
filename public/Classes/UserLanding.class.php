<?php

require_once 'LoginRedirect.class.php';
require_once 'User.class.php';

//fix two different user classes "ME" & "THEM"
class UserLanding{

	// MAYBE THIS SHOULD BE MOVED TO THE USER CLASS
	public static function fetchSteamStats(){

		// if someone go there without a steamId in the session, send them to the steam login page
		if(!isset($_SESSION['steamId'])){
			header('http://192.168.13.37/?/LoginRedirect/steamLogin');
		}

		// construct a new user object with the known steamId 
		$_SESSION['currentUser'] = new User($_SESSION['steamId']);
		$currentUser = $_SESSION['currentUser'];
                if ($currentUser->existed) $currentUser->fetchSteamStats();


                return ['loadview' => 'playerprofile', 'user' => $currentUser];
        }
}
