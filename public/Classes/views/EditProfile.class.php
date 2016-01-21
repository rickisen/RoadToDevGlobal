<?php

class EditProfile {
  private function __construct(){}
  private function __clone(){}

  static function  currentUser() {
    return ['loadview' => 'editplayerprofile', 'user' => $_SESSION['currentUser']];
  }
}
