<?php
use Polycademy\Validation\Validator;

class Sessions extends CI_Controller{


	protected $validator;
	protected $errors;

	public function __construct(){

		parent::__construct();
		$this->validator = new Validator;

	}
	//Use POST HTTP method
	public function create(){
		public function create($data){
			$data = array(
				'email' => array(
					'set_label:email',
					'NotEmpty',
					'AlphaNumericSpace',
					'MinLength:5',
					'MaxLength:200',
				),
				'password' => array(
					'set_label:password',
					'NotEmpty',
					'AlphaNumericSpace',
					'MinLength:5',
					'MaxLength:100',
				)
			);

			$this->validator->setup_rules($data);
		
			if(!$this->validator->is_valid($data)){

		//returns array of key for data and value
				$this->errors = $this->validator->get_errors();
				return false;

			}else{
					if($this->ion_auth->logged_in($email,$password)){
						//login success
						
					}else{
						//login failure
						$this->errors = array('message', $this->ion_auth->errors());
						
					}
			}	

			Template::compose(false, $data, 'json');
	}

	
	 
	        
	}

	//Use DELETE HTTP method
	public function delete(){

	}

	public function update(){

		$this->ion_auth->logout();

	}

	public function read(){

	}
}