<?php

//This resource is the schedule for the USER THAT IS LOGGED IN.
class Matchedschedules extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Position_model');
		$this->load->model('User_schedule_model');
		$this->load->library('ion_auth');
		$this->load->model('Matching_model');
	}


	public function index(){

	

	}

	//show all matched schedules based on schedule id
	public function show($id){

		$kmrange = $this->input->get('kmrange', true);
		$offset = $this->input->get('offset', true);
		$limit = $this->input->get('limit', true);
		$kmrange = (empty($kmrange)) ? '0.5' : $kmrange;
		$offset = (empty($offset)) ? '0' : $offset;
		$limit = (empty($limit)) ? '7' : $limit;


		//check if the person is logged in

		//check if the person owns the schedule ID, or is admin

		//use one schedule ID, get the latitude and longitude

		//use latitiude and longitude to find all matched schedules

		//using position matcher, then date matcher

		if($this->ion_auth->logged_in()){

			//do a query to find the user ID of the schedule ID
			$current_user = $this->ion_auth->user()->row()->id;
			$own_schedule = $this->Matching_model->owns_schedule($id, $current_user);

			if($own_schedule OR $this->ion_auth->is_admin()){

				$query = $this->Matching_model->read_all($own_schedule, $kmrange, $limit, $offset);
				
				if($query){
					
					$output = array(
						'content'	=> $query,
						'code'		=> 'success',
					);

				}else{

					$this->output->set_status_header(404);
					$output = array(
						'content'	=> current($this->Matching_model->get_errors()),
						'code'		=> key($this->Matching_mode->get_errors()),
					);

				}

			}else{
				
				$this->output->set_status_header(403);

				$output = array(
					'content'	=> current($this->Matching_model->get_errors()),
					'code'		=> key($this->Matching_model->get_errors()),
				);
			}

		}else{
			//not logged in
			$this->output->set_status_header(403);
			$output = array(
				'content'	=> 'You need to be logged in to view your schedules.',
				'code'		=> 'error',
			);
		}

		Template::compose(false,  $output, 'json');
	}

}