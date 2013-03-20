<?php

class Courses extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Courses_model');
	}
	
	/**
	 * Gets all Courses
	 *
	 * @queryparam int Limit the number of courses
	 * @queryparam int Offset the number of courses for pagination
	 * @return JSON
	 **/
	public function index(){
		
		$limit = $this->input->get('limit', true);
		$offset = $this->input->get('offset', true);
		
		$query = $this->Courses_model->read_all($limit, $offset);
		
		if($query){
			foreach($query as &$course){
				$course = output_message_mapper($course);
			}
			$output = $query;
		}else{
			$this->output->set_status_header('404');
			$output = array(
				'error'			=> output_message_mapper($this->Courses_model->get_errors()),
			);
		}
		
		Template::compose(false, $output, 'json');

	}
	
	/**
	 * Gets one course
	 *
	 * @param int Course ID
	 * @return JSON
	 **/
	public function show($id){
		
		$query = $this->Courses_model->read($id);		
		
		if($query){
			$output = output_message_mapper($query);
		}else{
			$this->output->set_status_header('404');
			$output = array(
				'error'			=> output_message_mapper($this->Courses_model->get_errors()),
			);
		}
		
		Template::compose(false, $output, 'json');
		
	}
	
	/**
	 * Posts a new course
	 *
	 * @postparam json Input data of the course
	 * @return JSON
	 **/
	public function create(){
		//post a new course
		
		$this->authenticated();
		
		$data = $this->input->json(false, true);
		
		$data['numberOfApplications'] = (!empty($data['numberOfApplications']) ? $data['numberOfApplications'] : 0);
		$data['numberOfStudents'] = (!empty($data['numberOfStudents']) ? $data['numberOfStudents'] : 0);
		
		//var_dump($data);
		
		$data = input_message_mapper($data);
		
		//var_dump($data);
		
		//return;
		
		$query = $this->Courses_model->create($data);
		
		//return;
		
		if($query){
			$output = array(
				'status'		=> 'Created',
				'resourceId'	=> $query,
			);
		}else{
			$this->output->set_status_header('400');
			$output = array(
				'error'			=> output_message_mapper($this->Courses_model->get_errors()),
			);
		}
		
		Template::compose(false, $output, 'json');
		
	}
	
	/**
	 * Updates a particular course
	 *
	 * @param int Course ID
	 * @putparam json Updated input data for the course
	 * @return JSON
	 **/
	public function update($id){
		//update a course
		
		$this->authenticated();
		
		$data = $this->input->json(false, true);
		
		//change camelcase to snakecase and remove the model prefix
		$data = input_message_mapper($data);
		
		$query = $this->Courses_model->update($data, $id);
		
		if($query){
			$output = array(
				'status'		=> 'Updated',
				'resourceId'	=> $id,
			);
		}else{
			$this->output->set_status_header('204');
			$output = array(
				'error'			=> output_message_mapper($this->Courses_model->get_errors()),
			);
		}
		
		Template::compose(false, $output, 'json');
		
	}
	
	/**
	 * Deletes a particular course
	 *
	 * @param int Course ID
	 * @return JSON
	 **/
	public function delete($id){
		//delete a course
		
		$this->authenticated();
		
		$query = $this->Courses_model->delete($id);
		
		if($query){
			$output = array(
				'status'		=> 'Deleted',
				'resourceId'	=> $id,
			);
		}else{
			$this->output->set_status_header('204');
			$output = array(
				'error'			=> output_message_mapper($this->Courses_model->get_errors()),
			);
		}
		
		Template::compose(false, $output, 'json');
		
	}
	
	protected function authenticated(){
		//check if person was authenticated
	}

}