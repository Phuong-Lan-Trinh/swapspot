<?php

class Phones extends CI_Controller{

	public $phones;

	public function __construct(){
		parent::__construct();
		
		$this->phones = array(
			array(
				'age'	=> 0,
				'id'	=> 'motorola-xoom-with-wi-fi',
				'name'	=> 'Motorol<>^*#(($KM?a XOOM\u2122 with Wi-Fi',
				'desc'	=> 'Blah blah blah',
			),
			array(
				'age'	=> 1,
				'id'	=> 'motorola-xoom-with-wi-fi',
				'name'	=> 'Motorola XOOM™ with Wi-Fi',
				'desc'	=> 'Blah blah blah',
			),
			array(
				'age'	=> 2,
				'id'	=> 'motorola-xoom-with-wi-fi',
				'name'	=> 'Motorola XOOM&#0153; with Wi-Fi',
				'desc'	=> 'Blah blah blah',
			),
			array(
				'age'	=> 3,
				'id'	=> 'anotherone',
				'name'	=> 'Motorola XOOM\u2122 with Wi-Fi',
				'desc'	=> 'Blah blah blah',
			),
			array(
				'age'	=> 4,
				'id'	=> 'one-specific',
				'name'	=> 'Motorola XOOM\u2122 with Wi-Fi',
				'desc'	=> 'Blah blah blah',
			),
		);
		
	}
	
	//get->phones
	public function index(){
		
		Template::compose(false, $this->phones, 'json');
	
	}
	
	public function show($id){
	
		$output = '';
		
		foreach($this->phones as $item){
			if($id == $item['id']){
				$output = $item;
				break;
			}
		}
		
		if(!$output){
			//Well no phone was found!
			$this->output->set_status_header('404');
			$output = array('error' => 'No phone with that id');
		}
		
		Template::compose(false, $output, 'json');
	
	}
	
	public function create(){
	
		//we should receive post data in the form of the phone as an array
		//second parameter will run it through the xss filter
		
		$input_data = $this->input->json(false, true);
		
		$phone_data = array(
			'age'	=> $input_data['phoneAge'],
			'id'	=> $input_data['phoneId'],
			'name'	=> $input_data['phoneName'],
			'desc'	=> $input_data['phoneDesc'],
		);		
		
		$this->phones[] = $phone_data;
		
		$output = array('status' => 'Done');
		
		//It could return 'error' when there is an error
		//Otherwise it returns 'status' of whatever
		//In terms of validation errors:
		// 'error' in terms of one error message
		// 'status' in terms of non-error messages, or when there are complex error messages
		// $output = array(
			// 'status' => 'ValidationError',
			// 'validationErrors'	=> array(
				// 'VALIDATION ERROR 1',
				// 'VALIDATION ERROR 2'
			// ),
		// );
		
		Template::compose(false, $output, 'json');
	
	}
	
	public function update($id){
	
		$input_data = $this->input->json(false, true);
		
		FB::log($id);
		FB::log($input_data);
	
	}
	
	public function delete($id){
	
		FB::log($id);
		
	}

}