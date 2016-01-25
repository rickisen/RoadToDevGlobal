<?php
require_once 'Include/lightopenid/openid.php';
require_once 'Classes/DB.class.php';
require_once 'Classes/User.class.php';
require_once 'Classes/Team.class.php';
require_once 'Classes/TeamComment.class.php';
session_start();

// ROUTE POST REQUESTS ==================================================
if( ! empty($_POST) && isset($_POST['postHandler']) ) {
  require_once 'Classes/protected/PostReceiver.class.php';
  $database = DB::getInstance();
  $postHandler = $database->real_escape_string(stripslashes($_POST['postHandler']));
  PostReceiver::$postHandler();
}

// ROUTE GET REQUESTS ==================================================
// Unless we didn't get any get request
if( ! empty($_GET)  ) {

  $url_parts = getUrlParts($_GET) ;

  $class  = array_shift($url_parts); 
  $method = array_shift($url_parts); 

  require_once("Classes/views/".$class.".class.php"); 
  $data = $class::$method($url_parts); 
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
  $database = DB::getInstance();
	$get_params = array_keys($get);
	$url = $get_params[0];

	$url_parts = explode("/",$url);
	foreach($url_parts as $k => $v){
    $v = $database->real_escape_string(stripslashes($v));
		if($v) $array[] = $v;
	}

	$url_parts = $array;
	return $url_parts;
}
