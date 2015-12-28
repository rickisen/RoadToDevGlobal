<?php
require 'includes/lightopenid/openid.php';

session_start();

$_STEAMAPI = "EC3378BE4E67D544BEA9E6D9B32B5B57";
// If user is not logged in
if(!isset($_SESSION['steamId'])) {

try
{
    $openid = new LightOpenID('http://192.168.13.37/Steam_api_test.php');
    if(!$openid->mode)
    {
        if(isset($_GET['login']))
        {
            $openid->identity = 'http://steamcommunity.com/openid/?l=english';    // This is forcing english because it has a weird habit of selecting a random language otherwise
            header('Location: ' . $openid->authUrl());
        }
?>

<!--Move this to "header.twig" when we've figured out how it should be implemented-->
<form action="?login" method="post">
    <input type="image" src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_small.png">
</form>

<?php

    }
    elseif($openid->mode == 'cancel')
    {
        echo 'User has canceled authentication!';
    }
    else
    {
        if($openid->validate())
        {
                $id = $openid->identity;
                // identity is something like: http://steamcommunity.com/openid/id/76561197960435530
                // we only care about the unique account ID at the end of the URL.
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
                $_SESSION['steamId'] = $matches[1];

                echo "User is logged in (steamID: $matches[1])\n";

                $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$_STEAMAPI&steamids=$matches[1]";
                $json_object= file_get_contents($url);
                $json_decoded = json_decode($json_object);

                foreach ($json_decoded->response->players as $player) {
                    echo "
                    <br/>Player ID: $player->steamid
                    <br/>Player Name: $player->personaname
                    <br/>Profile URL: $player->profileurl
                    <br/>SmallAvatar: <img src='$player->avatar'/>
                    <br/>MediumAvatar: <img src='$player->avatarmedium'/>
                    <br/>LargeAvatar: <img src='$player->avatarfull'/>
                    <br/>Account created: $player->timecreated
                    <br>
                    ";
                }


              $url = file_get_contents("http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=730&key=$_STEAMAPI&steamid=$matches[1]");
              $content = json_decode($url, true);

              $stats = array();
                foreach ($content['playerstats']['stats'] as $stat) {
                    $stats[$stat["name"]] = $stat["value"];
                }

                $total_kills = $stats["total_kills"];
                $total_deaths = $stats["total_deaths"];
                $total_planted_bombs = $stats["total_planted_bombs"];

                  echo '<br>';
                  echo 'Total kills: ' .$total_kills;
                  echo '<br>';
                  echo 'Total deaths: ' .$total_deaths;
                  echo '<br>';
                  echo 'Total bombs planted: ' .$total_planted_bombs;

        } else echo "<a href='http://192.168.13.37/Steam_api_test.php'>Try again</a>";
    }
}

catch(ErrorException $e)
{
    echo $e->getMessage();
}

}

// If user is logged in
else {
  echo "You are logged in!";
}

?>
