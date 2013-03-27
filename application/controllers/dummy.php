<?php
class Dummy extends CI_Controler{
	public function __construct(){
		parent::__construct();

	}

	public function index(){
		$json_data=array(
			'message' => 'Hi'
		);
		Template::compose(false,$json_data,'json');
	}
}