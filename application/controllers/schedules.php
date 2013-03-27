<?php

class Schedules extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Position_model');
		$this->load->model('User_schedule_model');
		$this->load->library('ion_auth');
	}

	//only accessible by admin
	public function index(){
		//NEEDS AUTHENTICATION
		// $this->authenticated(),
		// $limit = $this->input->get('limit', true);
		// $offset = $this->input->get('offset', true);

		// $query = $this->User_schedule_model->read_all($limit, $offset);

		// if($query){
		// 	foreach($query as &$schedule){
		// 		$schedule = output_message_mapper($);
		// 	}
		// 	$output = $query;
		// }else{
		// 	$this->output->set_status_header('404');
		// 	$output = array(
		// 	'error'	=> output_message_mapper($this->User_schedule_model->get_errors()),
		// 	);
		// };

		// Template::compose(false, $output, 'json');
	}

	//publicly accessible!
	public function create(){
		//$this->authenticated();
		$user = $this->ion_auth->user()->row();
		$user_id = $user->id;

		$data = $this->input->json(false, true); 

		$location = $data['location'];

		$location = $this->Position_model->get_location($location);
		var_dump($location);

		// YAY WE JHAVE THE LOCATIOJN!!!
		$data = $this->input->json(false,true);
		$data['user_id'] = $user_id;
		$location = $data['location'];
		$position = $this->Position_model->get_location($location);
		$data += $position;
		var_dump($data);

		//NOW WE NEED TO INSERT ALL THESE INPUT DATA INTO THE TABLE
		$this->User_schedule_model->create($data);

		
		//WOOOHOO!
	}

	//only accessible by admin
	public function delete($id){
		$this->User_schedule_model->delete($id);

	}


}