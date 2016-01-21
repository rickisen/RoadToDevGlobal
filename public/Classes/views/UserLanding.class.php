<?php

require_once 'LoginRedirect.class.php';

//fix two different user classes "ME" & "THEM"
class UserLanding{

	// MAYBE THIS SHOULD BE MOVED TO THE USER CLASS
	public static function currentUserCheck(){

		// if someone go there without a steamId in the session, send them to the steam login page
		if(!isset($_SESSION['steamId'])){
			header('http://192.168.13.37/?/LoginRedirect/steamLogin');
		}

		// construct a new user object with the known steamId 
		$_SESSION['currentUser'] = new User($_SESSION['steamId']);
		$currentUser = $_SESSION['currentUser'];

      if ($currentUser->existed) {
        // only run this on already existing users, 
        // since it's run when constructing a fresh user
        $currentUser->fetchSteamStats(); 

        // send the user to the landingpage when logged in. 
        return ['loadview' => 'landingpage'];

      } else {
        // Otherwise if they are new users 
        // send them to the edit-profile-page
        require_once "EditProfile.class.php";
        return EditProfile::currentUser();
      }
    }
  }
