<?php

class Faq{
	private function __construct(){}
	private function __clone(){}

	static function viewFaq(){
		return ['loadview' => 'faq' ];
	}
}
