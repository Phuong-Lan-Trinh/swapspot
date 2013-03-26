<?php
// this controller is to create a form validation for the submit form in the body of the home pate

use Polycademy\Validation\Validator;

class Validation_insertion_schedule_model extends CI_Model{

    protected $validator;
    
    public function __construct(){

        parent::__construct();
        $this->validator = new Validator;

    }

    public function create(){
        $this->input->json(false,true);
        $rules = array(
            'address'  => array(
                'set_label:Address',
                'NotEmpty',
                'MinLength:5',
                'MaxLength:255'
                ),
            'location' => array(
                'set_label:location',
                'NotEmpty',
                'MinLength:5',
                'MaxLength:200',
            ),
            'timestart' => array(
                'set_label:Starttime',
                'NotEmpty',
                'AlphaNumericSpace',
                'MinLength:5',
                'MaxLength:100',
            ),
            'timelength' => array(
                'set_label:Timelength',
                'NotEmpty',
                'AlphaNumericSpace',
                'MinLength:5',
                'MaxLength:100',
            ),
            'longitude' => array(
                'set_label:Longitude',
                'NotEmpty',
                'AlphaNumericSpace',
                'MinLength:5',
                'MaxLength:100',
            ),
            'latitude' => array(
                'set_label:Latitude',
                'NotEmpty',
                'AlphaNumericSpace',
                'MinLength:5',
                'MaxLength:100',
            ),
        );

        $this->validator->setup_rules($rules);

        if(!$this->validator->is_valid($data)){

            //returns array of key for data and value
            $this->errors = $this->validator->get_errors();
            return false;

        }

        $query = $this->db->insert('schedules', $data);
         
        if(!$query){

            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            $last_query = $this->db->last_query();

            log_message('error', 'Problem inserting to schedules table: ' . $msg . ' (' . $num . '), using this query: "' . $last_query . '"');

            $this->errors = array(
            'database'  => 'Problem inserting data to schedules table.',
            );

            return false;

        }

        return $this->db->insert_id();

    }

    public function read($id){

        $this->authenticated();

        $query = $this->db->get_where('schedules', array('id' => $id));

        if($query->num_rows() > 0){
            $row = $query->row();
            $data = array(
                'id'    => $id,
                'location'  => $row->location,
                'timestart' => $row->timestart,
                'timelength'=> $row->timelength,
                );
            return $data;
        }else{
        $this->errors = array(
        'database'  => 'Could not find specified schedules.',
        );
        return false;
        }

    }

    
    public function update($id, $data){

        $this->authenticated();

        $this->validator->setup_rules(array(
            'location' => array(
            'set_label:location',
            'NotEmpty',
            'AlphaNumericSpace',
            'MinLength:5',
            'MaxLength:200',
        ),
        'timestart' => array(
            'set_label:start time',
            'NotEmpty',
            'AlphaNumericSpace',
            'MinLength:5',
            'MaxLength:100',
        ),
        'timelength' => array(
            'set_label:time length',
            'NotEmpty',
            'AlphaNumericSpace',
            'MinLength:5',
            'MaxLength:100',
        ),
        'longitude' => array(
            'set_label:time length',
            'NotEmpty',
            'AlphaNumericSpace',
            'MinLength:5',
            'MaxLength:100',
        ),
        'latitude' => array(
            'set_label:time length',
            'NotEmpty',
            'AlphaNumericSpace',
            'MinLength:5',
            'MaxLength:100',
        ),
        ));

        if(!$this->validator->is_valid($data)){

        $this->errors = $this->validator->get_errors();
        return false;

        }

        $this->db->where('id', $id);
        $this->db->update('schedules', $data);

        //greated or equal to zero (means update worked)
        if($this->db->affected_rows() > 0){

            return true;

        }else{

            $this->errors = array(
            'database'  => 'Nothing to update.',
        );
                    return false;

        }

    }

    public function delete($id){
        $this->authenticated();
        $this->db->where('id', $id);
        $this->db->delete('schedules');

        if($this->db->affected_rows() > 0){

            return true;

        }else{

            $this->errors = array(
            'database'  => 'Nothing to delete.',
        );

                    return false;

        }

    }

    public function get_errors(){
        return $this->errors;
    }

}

