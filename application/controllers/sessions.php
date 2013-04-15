<?php
use Polycademy\Validation\Validator;

class Sessions extends CI_Controller{

	protected $validator;

	public function __construct(){

		parent::__construct();
		$this->validator = new Validator;
		$this->load->library('session');
	}


	public function index(){
		if($this->ion_auth->is_admin()){
			//show all the current sessions
			$query = $this->db->get($this->config->item('sess_table_name'));
			if($query->num_row() > 0) {
				foreach($query->result() as $row){
					//have to unserialize the customer data
					$customer_data = $this-> unserialize($row->user_data);
					$user_sessions[] = array(
						'type' => (!empty($row->user_data)) ? 'member' : 'guest',
						'session_id' => $row->ip_address, // ip_address from sessions
						'ip_address' => $row->user_agent,
						'last_activity' => $row->last_activity,
						'user_data' => $customer_data
						);
				}
				$output = array(
					'content' => $user_sessions,
					'code' => 'success'
					);
			}else{

				$this->output->set_status_header('404');
				$output = array(
					'content' => 'No one is currently logged in.',
					'code' => 'error'
					);
			}
			
		}else{

			$this->output->set_status_header('403');
			$output = array(
				'content' => 'You are not authorised to see all the sessions',
				'code' => 'error'
				);

		}

		Template::compose(false, $output, 'json');
	}


	private function unserialize($data){

		$data = @unserialize(trim($data));
		if (is_array($data)){
			array_walk_recursive($data, array(&$this, 'unescape_slashes'));
			return $data;
		}

		return is_string($data) ? str_replace('{{slash}}', '\\', $data) : $data;

	}


	private function unescape_slashes(&$val, $key){

		if (is_string($val)){
		$val = str_replace('{{slash}}', '\\', $val);
		}

	}

	//show the the session data relating to user id
	//can only show current person's session, $id is just for REST
	//this is the function that will be utilised at startup!	

	public function show($id){
		if($id == 0){

			//if $id is 0, just grab the current session
			$output = array(
			'content'	=> $this->session->all_userdata(),
			'code'	=> 'success',
			);

			$user_data = $this->ion_auth->user()->row();

			if(!empty($user_data)){
				$user_id = $user_data->id;
				//we want to store the userId in a different place, as this could overwrite the session id
				$output['content']['userId'] = $user_id;
			}

		}else{

		//grab a specified session, either the person must own it, or the person is an admin
		//not yet implemented

		}

		Template::compose(false, $output, 'json');

	}
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
			//only delete if the person is logged in
		if($this->ion_auth->logged_in()){
			$current_user = $this->ion_auth->user()->row();

			$this->ion_auth->logout();

			$output = array(
				'content'	=> $current_user->id,
				'code'	=> 'success',
			);

			//this function should check for 0, to logout the current person, if not 0, logout a particular person...

		}else{

		//no resource to delete
			$this->output->set_status_header(200);

			$output = array(
			'content'	=> 'You cannot log out when you are not logged in.',
			'code'	=> 'error',
			);

		}

	Template::compose(false, $output, 'json');

	}


	public function update(){
		return false;
		
	}
	

	public function read(){

	}
}