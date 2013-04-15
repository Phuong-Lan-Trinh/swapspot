<?php
use Polycademy\Validation\Validator;

class Accounts extends CI_Controller{

	protected $validator;

	public function __construct(){

		parent::__construct();
		$this->validator = new Validator;

	}

	public function index(){}

	public function show($id){

		
		if($this->ion_auth->logged_in()){
			//logged in

			//check if the current user owns the id
			$current_user = $this->ion_auth->user()->row();

			if($current_user->id == $id OR $this->ion_auth->is_admin()){

				$selected_user = $this->ion_auth->user($id)->row();
				$groups = $this->ion_auth->get_users_groups($id)->result_array();

				//need group...
				$output = array(
					'content'	=> array(
					'id'	=> $selected_user->id,
					'ipAddress'	=> inet_ntop($selected_user->ipAddress), //processed from binary format, only used in MySQL...
					'username'	=> $selected_user->username,
					'email'	=> $selected_user->email,
					'createdOn'	=> $selected_user->createdOn,
					'lastLogin'	=> $selected_user->lastLogin,
					'active'	=> $selected_user->active,
					'groups'	=> $groups,
				),
				'code'	=> 'success',
				);

			}

		}else{
		//not logged in

			$this->output->set_status_header(401);

			$output = array(
				'content'	=> 'You are unauthorised to view user data without logging in.',
				'code'	=> 'error',
			);

		}

		Template::compose(false, $output, 'json');


	}

	//Use POST HTTP method
	public function create(){

		$data = $this->input->json(false, true);

		$rules = array(
			'username' => array(
				'set_label:Username',
				'NotEmpty',
				'AlphaNumericSpace',
				'MinLength:5',
				'MaxLength:200',
			),
			'email' => array(
				'set_label:Email',
				'NotEmpty',
				'Email',
				'MinLength:5',
				'MaxLength:200',
			),
			'password' => array(
				'set_label:Password',
				'NotEmpty',
				'AlphaNumericSpace',
				'MinLength:5',
				'MaxLength:100',
			)
		);

		$this->validator->setup_rules($rules);

		if(!$this->validator->is_valid($data)){

			//did not pass validation
			$code = 'validation_error';
			$content = $this->validator->get_errors();
			$this->output->set_status_header(400);


		}else{

			//passed validation

			if($this->ion_auth->username_check($data['username']) OR $this->ion_auth->email_check($data['email'])){

				$code = 'error';
				$content = 'You are already registered!';
				$this->output->set_status_header(409);

			}else{

				//register the user!

				if($id = $this->ion_auth->register($data['username'], $data['password'], $data['email'])){
					$code = 'success';
					$content = $id;
					$this->output->set_status_header(201);					
				}else{
					$code = 'system_error';
					$content = 'Could not register user, please try again later!';
					$this->output->set_status_header(500);
				}

			}

		}

		$output = array(
			'content' => $content,
			'code' => $code,
			'redirect' => '',
		);

		Template::compose(false, $output, 'json');

	}

	public function update($id){}

	public function delete($id){}

}