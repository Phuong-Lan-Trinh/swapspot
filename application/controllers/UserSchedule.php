<?php

class UserSchedule extends CI_Controller{

	protected function authenticated(){}

	public function __construct(){
		parent::__construct();
		$this->load->model('Position_model');
		$this->load->model('User_schedule_model');
		$this->load->library('ion_auth');
		$this->load->model('Matching_model');
	}

	//only accessible by admin
	public function index(){
		//NEEDS AUTHENTICATION
		// $this->authenticated(),
		// $limit = $this->input->get('limit', true);
		// $offset = $this->input->get('offset', true);

		// $query = $this->User_schedule_model->read_all($limit, $offset);

		// if($query){
			
		// 	$content = $query; // assign query
		// 	$code = 'success'; // assign code
		// }else{
		// 	$this->output->set_status_header('404');
		// 	$content = current($this->//YOUR MODEL);
		// 	$output = array(
		// 	'error'	=> output_message_mapper($this->User_schedule_model->get_errors()),
		// 	);
		// };

		// Template::compose(false, $output, 'json');
	}

	//publicly accessible!
	public function create(){
		
		$this->authenticated();

		$data = $this->input->json(false, true);		

		$data['userId'] = $this->ion_auth->user()->row()->id;

		$position = $this->Position_model->get_location($data['location']);

		$data['address'] = $position['address'];
		$data['latitude'] = $position['latitude'];
		$data['longitude'] = $position['longitude'];

		//we now have a $data array with 'userId' and 'location'

		$query = $this->User_schedule_model->create($data);

		if($query){

			$this->output->set_status_header('201');
			$content = $query; // resource id
			$code = 'success';

		}else{

			$content = current($this->User_schedule_model->get_errors()); //gets the value of get_errors()
			$code = key($this->User_schedule_model->get_errors()); //gets the key of the get_errors()

			if($code == 'validation_error'){
				$this->output->set_status_header(400);
			}elseif($code == 'system_error'){
				$this->output->set_status_header(500);
			}
		
		}

		//match the

		$output = array(
			'content'	=> $content,
			'code'		=> $code,
		);

		Template::compose(false, $output, 'json');

	}

	//takes an id of the schedule, and outputs the schedule and its matches
	public function show($id){
		
		$this->authenticated();

		$limit = $this->input->get('limit', true);
		$limit = (empty($limit)) 10 : $limit;
		$offset = $this->input->get('offset', true);
		$offset = (empty($offset)) 0 : $offset;

		//will store all matches
		$matches = array();

		//get the schedule from the db

		$query = $this->User_schedule_model->read($id);

		if($query){

			//first do a position match
			$user_latitude = $query['latitude'];
			$user_longitude = $query['longitude'];
			//$user_time = $query['time'];

			//array of all schedules
			$all_schedules = $this->User_schedule_model->read_all($limit, $offset) //$user_time needs to be injected

			foreach($all_schedules as $potential_match){
				$distance = $this->Matching_model->distance($user_latitude, $potential_match['latitude'], $user_longitude, $potential_match['longitude']);
				if($distance < 0.5){
					//this is a match
					$matches[$potential_match['id']] = $potential_match;
				}
			}

			//second do a time match
			//FILTER BASED ON TIME NEED TO DO!

		}else{

			$this->output->set_status_header(404);
			$content = current($this->User_schedule_model->get_errors());
			$code = key($this->User_schedule_model->get_errors());

		}

		$output = array(
			'content' => $content,
			'code' => $code,
		);

		Template::compose(false, $output, 'json');

	}

	//only accessible by admin
	public function delete($id){
		$this->User_schedule_model->delete($id);

	}

	private authenticated(){
	 	//NOTHING
	}


}