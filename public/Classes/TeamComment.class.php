<?php

class TeamComment{
  private $author, $text, $date;

  function __construct($content, $signature, $date=""){
    $this->author    = $author;
    $this->text      = $text;
    $this->date      = $date;
  }

  function __get($x){
    return $this->$x;
  }

  function __isset($x){
    return isset($this->$x);
  }

  function storeComment($teamId){
    $database = DB::getInstance();

    // escape the input before upload
    $teamId   = $database->real_escape_string(stripslashes($teamId));
    $author   = $database->real_escape_string(stripslashes($this->signature));
    $text     = $database->real_escape_string(stripslashes($this->content));

    $qInsQuery = '
			INSERT INTO comment (author, text, date)
			VALUES ( \''.$_SESSION['currentUser']->steamId.'\', \''.$post_comment.'\')
			';

			$database->query($qInsQuery);

			if ($database->error) {
				echo "Sorry, something went wrong when trying to upload your comment: ".$database->error;
		}
  }
}
