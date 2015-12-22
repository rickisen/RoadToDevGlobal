<?php
session_start();
require_once("Classes/DB.class.php");

if($url_parts = getUrlParts($_GET)){
  # $url_params blir en array med alla "värden" som står efter ? avgränsade med /
  # ex. /Posts/single/11 kommer ge en array med 3 värden som är Posts, single och 11
  
  $class  = array_shift($url_parts); # tar ut första värdet och lägger den i $class 
  $method = array_shift($url_parts); # tar ut andra värdet och lägger den i $method

  require_once("Classes/".$class.".class.php"); # Hämta in klassfilen för den klass vi ska anropa
  $data = $class::$method($url_parts); # Anropa metoden vill vill köra på klassen vi har fårr från vår URL samt skicka med övriga parametrar in till den metoden
}

// listen if we got a redirect request and load that location emidiatly
// else render the template
if( isset($data['redirect']) ) {
	header("Location: ".$data['redirect']);
} else {
        // start twig 
	require_once('Include/twig/lib/Twig/Autoloader.php');
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem('Templates/');
	$twig = new Twig_Environment($loader);

        // render the index template with the data array
	echo $twig->render('index.twig', $data);
}

# Funktion som "slår sönder" det vi får efter ? på alla /
# och skickar tillbaka som en array
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

