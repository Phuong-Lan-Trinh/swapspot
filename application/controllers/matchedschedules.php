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
		$limit = (empty($limit)) ? '10' : $limit;


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

				$latitude = $own_schedule['latitude'];
				$longitude = $own_schedule['longitude'];
				$table_name = 'schedules';
				//this is a timestamp calculation
				
				//timestamp again!
				$timestart = $own_schedule['timestart'];
				$timeend = $own_schedule['timeEnd'];
				//sql query to find all position matches, based on km range, will show all the results plus a distance column that will be ordered from closest to furtherest away
				$sql = 'SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM ? WHERE (timestart <= ?) AND (timeEnd >= ?) HAVING distance < ? ORDER BY distance LIMIT ? , ?';
				$query = $this->db->query($sql, array($latitude, $longitude, $latitude, $table_name, $timeend, $timestart, $kmrange, $offset, $limit));



			}

		}else{
			//not logged in
		}

		Template::compose(false,  $output, 'json');
	}

}