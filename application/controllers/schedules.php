<?php

class Schedules extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Position_model');
		$this->load->model('validation_insertion_schedule_model');
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

		$data = $this->input->json(false, true); // this does not access the input at all ~"~

		$location = $data['location'];

		$location = $this->Position_model->get_location($location);
		var_dump($location);

		// YAY WE JHAVE THE LCOATIOJN!!!
		// if ($this->authenticated()){
		// 	$address = $this->location->position['address'];
		// 	$longitude = $this->location->position['longitude'];
		// 	$latitude = $this->location->position['latitude'];
		// 	$timestart = $data['timestart'];
		// 	$timelength = $data['timelength'];
		// 	$location = $data['location'];
		// 	$this->Validation_insertion_schedule_model->create();
		// }
		//WOOOHOO!
	}

	//only accessible by admin
	public function delete($id){

	}


}