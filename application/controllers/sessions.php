<?php
use Polycademy\Validation\Validator;

class Sessions extends CI_Controller{

	protected $validator;

	public function __construct(){

		parent::__construct();
		$this->validator = new Validator;
		$this->load->library('session');
	}

	public function index(){}

	public function show($id){}
	//Use POST HTTP method
	public function create(){

		$data = $this->input->json(false, true);
		$rules = array(
			'email' => array(
				'set_label:email',
				'NotEmpty',
				'Email',
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

		$this->validator->setup_rules($rules);
	
		if(!$this->validator->is_valid($data)){

	//returns array of key for data and value
			$code = 'validation_error';
			$content = $this->validator->get_errors();
			$this->output->set_status_header(400);

		}else{
			$this->ion_auth->login($data['email'],$data['password']);
			if($this->ion_auth->logged_in($data['email'],$data['password'])){
				//login success
				$user = $this->ion_auth->user()->row();
				$id = $user->id;
				$code = 'success';
				$content = $id;
				$this->output->set_status_header(201);
				
			}else{
				//login failure
				$code = 'system_error';
				$content = 'login failure';
				$this->output->set_status_header(401);
				}
		}	

		$output = array(
			'code' => $code,
			'content' => $content,
			'redirect' => ''
			);

		Template::compose(false, $output, 'json');
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