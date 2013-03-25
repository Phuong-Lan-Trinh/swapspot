<?php

class Schedules extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('User_schedule_model');
		$this->load->model('Position_model');
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

		$data = $this->input->json(false, true);

		$location = $data['location'];

		$location = $this->Position_model->get_location($location);

		// YAY WE JHAVE THE LCOATIOJN!!!
		$location = $location['path']['to']['location']['nsdfgfdg'];
		//WOOOHOO!
	}

	//only accessible by admin
	public function delete($id){

	}


}