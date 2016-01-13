<?php

class TeamComment{
  private $teamId, $text, $date, $commentId;

  public static function fromText($text, $teamId){
    $database = DB::getInstance();

    $ret = new self();

    $qInsertNewComment = '
      INSERT INTO team_comment (team_id, author, text)
      VALUES ( \''.$teamId.'\',\''.$_SESSION['currentUser']->steamId.'\', \''.$text.'\')
    ';
    $database->query($qInsertNewComment);

    if($error = $database->error){ 
      echo "Something went wrong when trying to insert a comment $id : $error";
      return FALSE;
    }else {
      $commentId = $database->insert_id;
      $ret->commentId = $commentId;
      return $ret;
    }
  }

  public static function withID($commentId){
    $database = DB::getInstance();

    $ret = new self();
    $ret->commentId = $commentId;

    $qGetTeamComment = '
      SELECT * FROM team_comment WHERE id = '. $id .'
    ';

    if($result = $database->query($qGetTeamComment)){
      $row = $result->fetch_assoc();
      $ret->text = $row['text'];
      $ret->date = $row['date'];

    } elseif($error = $database->error){ 
      echo "Something went wrong when trying to fetch comment $id : $error";

    }

    return $ret;
  }


  function __construct(){}

  function __get($x){
    return $this->$x;
  }

  /*function __isset($x){
    return isset($this->$x);
  }*/
}