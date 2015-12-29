<?php

class EditProfile {
  private function __construct(){}
  private function __clone(){}

  static function  {
    return ['loadview' => 'editprofile', 'user' => $_SESSION['currentUser']];
  }
}
