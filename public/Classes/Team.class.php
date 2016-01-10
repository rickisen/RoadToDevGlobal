<?php

class Team {
  private function __construct(){}
	private function __clone(){}

	static function viewTeam(){
		return ['loadview' => 'teamprofile', 'team' => $_SESSION['currentUser']->inTeam];
	}
}
