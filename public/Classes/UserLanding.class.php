<?php

require_once 'LoginRedirect.class.php';

//fix two different user classes "ME" & "THEM"
class UserLanding{

	private static $steamApiKey = "EC3378BE4E67D544BEA9E6D9B32B5B57";

	public static function fetchSteamStats(){

		// if someone gothere without a steamId in the session, send them to the steam login page
		if(!isset($_SESSION['steamId'])){
			header('http://192.168.13.37/?/LoginRedirect/steamLogin');
		}

		// construct a new user object with the known steamId 
		$_SESSION['currentUser'] = new User($_SESSION['steamId']);
		$currentUser = $_SESSION['currentUser'];

		// then we update the info on thatuser with what is saved in steams servers...

		// get what we need from steam api version 1
	    $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".self::steamApiKey."&steamids=".$_SESSION['steamId'];
	    $api_1_decoded = json_decode(file_get_contents($url));

	    // get what we need from steam api version 2
		$url2 = "http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=730&key=".self::steamApiKey."&steamid=".$_SESSION['steamId'];
	  	$api_2_decoded = json_decode(file_get_contents($url2), true);

	  	// make a clearer assoc array from the api 2 responce
	  	$api_2_array = array();
	    foreach ($api_2_decoded['playerstats']['stats'] as $stat) {
	        $api_2_array[$stat["name"]] = $stat["value"];
	    }

	    $nickname    = $api_1_decoded->response->players[0]->personaname;
	    $image_s     = $api_1_decoded->response->players[0]->avatar;
	    $image_m     = $api_1_decoded->response->players[0]->avatarmedium;
	    $image_l     = $api_1_decoded->response->players[0]->avatarfull;
	    $kills       = $api_2_array['total_kills'];
	    $deaths      = $api_2_array['total_deaths'];
	    $hoursPlayed = $api_2_array['total_time_played']; #might need some mathematical fix

		$currentUser->updateSteamStats($nickname, $kills, $deaths, $hoursPlayed, $image_l, $image_m, $image_s);

		return ['loadview' => 'profile', 'currentUser' => $currentUser];
	}
}