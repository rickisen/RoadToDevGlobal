<?php
require_once 'Classes/User.class.php';
require_once 'Classes/DB.class.php';
require_once 'Classes/PostReceiver.class.php';
require_once 'Classes/LobbyLoader.class.php';
session_start();

// ROUTE POST REQUESTS ==================================================
if( ! empty($_POST) && isset($_POST['postHandler']) ) {
  PostReceiver::$_POST['postHandler']();
}

// ROUTE GET REQUESTS ==================================================
// Unless we didn't get any get request
if( ! empty($_GET)  ) {
  # $url_params blir en array med alla "värden" som står efter ? avgränsade med /
  # ex. /Posts/single/11 kommer ge en array med 3 värden som är Posts, single och 11
  $url_parts = getUrlParts($_GET) ;

  $class  = array_shift($url_parts); # tar ut första värdet och lägger den i $class
  $method = array_shift($url_parts); # tar ut andra värdet och lägger den i $method

  require_once("Classes/".$class.".class.php"); # Hämta in klassfilen för den klass vi ska anropa
  $data = $class::$method($url_parts); # Anropa metoden vill vill köra på klassen vi har fårr från vår URL samt skicka med övriga parametrar in till den metoden
} else {
  $data = array('loadview' => 'landingpage');
}

if(isset($_SESSION['currentUser'])) {
  $data['currentUser'] = $_SESSION['currentUser'];
}

// RENDER THE TEMPLATE ==================================================
if( ! isset($data['redirect']) ) { // Unless we got a redirect request

        // start twig
	require_once('Include/twig/lib/Twig/Autoloader.php');
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem('Templates/');
	$twig   = new Twig_Environment($loader);

        // render the index template with the data array
	echo $twig->render('index.twig', $data);
} else {
        // redirect to the given location
	header("Location: ".$data['redirect']);
}

// MISQ FUNCTIONS ==================================================

// function that explodes a string with the '/' character as a delimiter
// And returns that array
function getUrlParts($get){
	$get_params = array_keys($get);
	$url = $get_params[0];

	$url_parts = explode("/",$url);
	foreach($url_parts as $k => $v){
		if($v) $array[] = $v;
	}

	$url_parts = $array;
	return $url_parts;
}
