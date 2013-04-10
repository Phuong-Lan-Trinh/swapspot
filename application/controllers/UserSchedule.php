<?php

class UserSchedule extends CI_Controller{

	private function authenticated(){}

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
		// $this->authenticated();
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
		$data['streetNumber'] = $position['streetNumber'];
		$data['route'] = $position['route'];
		$data['locality'] = $position['locality'];
		$data['administrativeAreaLevel'] = $position['administrativeAreaLevel'];
		$data['country'] = $position['country'];
		$data['postCode'] = $position['postCode'];

		//we now have a $data array with 'userId' and 'location'
		//we create date data to insert into the schedule
		$data['date'] = date("d.m.y");
		$time = strtotime($data['timestart']);
		$data['timestart'] = date('Y-m-d G-i-s', $time) ;
		$data['timeEnd'] = date('Y-m-d G-i-s', strtotime('+'.$data['timeEnd'].'hour', $time));
		

		$schedule_id = $this->User_schedule_model->create($data);

		if($schedule_id){

			$this->output->set_status_header('201');
			$content = $schedule_id; // resource id
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
		'code'	=> $code,
		);

		Template::compose(false, $output, 'json');
	}

	//this is the user id
	//this will show the menu, all schedules that are part of a person's id
	public function show($id){
		
		//authenticate based on logged in and ownership
		if($this->ion_auth->logged_in()){

			//person needs to be logged in

			$current_user = $this->ion_auth->user()->row();

			//if the current user owns the id or is admin
			if($current_user->id == $id OR $this->ion_auth->is_admin()){

				//setting up the pagination for limit and offset
				$limit = $this->input->get('limit', true);
				$limit = (empty($limit)) ? 10 : $limit;
				$offset = $this->input->get('offset', true);
				$offset = (empty($offset)) ? 0 : $offset;

				//returns all the schedules of the user
				$query = $this->User_schedule_model->read($id);

				$output = $query;

			}else{

				$this->output->set_status_header(403);

				$output = array(
					'content'	=> 'You are not authorised to view the schedules of user ' . $id . '.',
					'code'		=> 'error',
				);

			}

		}else{

			$this->output->set_status_header(403);
			$output = array(
				'content'	=> 'You need to be logged in to view your schedules.',
				'code'		=> 'error',
			);

		}

		Template::compose(false, $output, 'json');
	}

	//only accessible by admin
	public function delete($id){
		$this->User_schedule_model->delete($id);

	}

	


}