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
    $author   = $database->real_escape_string(stripslashes($this->author));
    $text     = $database->real_escape_string(stripslashes($this->text));

    $qInsQuery = '
			INSERT INTO comment (author, text, date)
			VALUES ( \''.$_SESSION['currentUser']->steamId.'\', \''.$text.'\')
			';

			$database->query($qInsQuery);

			if ($database->error) {
				echo "Sorry, something went wrong when trying to upload your comment: ".$database->error;
		}
  }

  function fetchComments {
    $database = DB::getInstance();

    $qFetchComments = '
    SELECT team_comment.*
    FROM team_comment
    WHERE team_comment.id = team.id
    ';

    $result = $database->query($qFetchComments);
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $comments[] = new TeamComment($row['id']);

          $database->query($qFetchComments);
      }
    } else {
			echo "Failed to get teams from DB".$database->error;
		}

  }
}
