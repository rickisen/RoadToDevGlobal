<?php

require 'Include/lightopenid/openid.php';

class LoginRedirect{

	public static function steamLogin(){

		if(!isset($_SESSION['steamId'])) 
		{
		    $openid = new LightOpenID('http://192.168.13.37/?/LoginRedirect/steamLogin');
		    if(!$openid->mode && isset($_GET['login']))
		    {
                      $openid->identity = 'http://steamcommunity.com/openid/?l=english';    // This is forcing english because it has a weird habit of selecting a random language otherwise
                      header('Location: ' . $openid->authUrl());
		    }
		    elseif($openid->mode == 'cancel')
		    {
		        echo 'User has canceled authentication!';
		    }
		    elseif($openid->validate())
                    {
                      $id = $openid->identity;
                      // identity is something like: http://steamcommunity.com/openid/id/76561197960435530
                      // we only care about the unique account ID at the end of the URL.
                      $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                      preg_match($ptn, $id, $matches);
                      $_SESSION['steamId'] = $matches[1];
                      /* header('http://192.168.13.37/?/UserLanding/fetchSteamStats'); */
                      require('UserLanding.class.php');
                      UserLanding::fetchSteamStats();
                    } 
                      else 
                    {
                            echo "<a href='http://192.168.13.37/?/LoginRedirect/steamLogin'>Try again</a>";
                    }
                  } 
                  else {// If user is logged in
                    echo "You are logged in!";
                  }
                }
              }
