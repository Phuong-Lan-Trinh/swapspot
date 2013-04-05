<?php
// this controller is to create a form validation for the submit form in the body of the home pate

use Polycademy\Validation\Validator;

class User_schedule_model extends CI_Model{

    protected $validator;
    protected $errors;
    
    public function __construct(){

        parent::__construct();
        $this->validator = new Validator;
        $this->load->database();

    }

    public function create($data){

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
                'MaxLength:255',
            ),
            'timestart' => array(
                'set_label:Starttime',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100',
            ),
            'timelength' => array(
                'set_label:Timelength',
                'NotEmpty',
                'AlphaNumericSpace',
                'MinLength:1',
                'MaxLength:100',
            ),
            'longitude' => array(
                'set_label:Longitude',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100',
            ),
            'latitude' => array(
                'set_label:Latitude',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100',
            ),
        );

        $this->validator->setup_rules($rules);


        if(!$this->validator->is_valid($data)){

            //returns array of key for data and value
            $this->errors = array(
                'validation_error' => $this->validator->get_errors();
                );
            return false;

        }

        $query = $this->db->insert('schedules', $data);
         
        if(!$query){

            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            $last_query = $this->db->last_query();

            log_message('error', 'Problem inserting to schedules table: ' . $msg . ' (' . $num . '), using this query: "' . $last_query . '"');

            $this->errors = array(
                'system_error'  => 'Problem inserting data to schedules table.',
            );

            return false;

        }

        return $this->db->insert_id();

    }

    public function read($id){

        $query = $this->db->get_where('schedules', array('id' => $id));

        if($query->num_rows() > 0){
            $row = $query->row();
            $data = array(
                'id'        => $id,
                'userId'    => $row->userId,
                'location'  => $row->location,
                'address'   => $row->address,
                'latitude'  => $row->latitude,
                'longitude' => $row->longitude,
                'timestart' => $row->timestart,
                'timelength'=> $row->timelength,
            );
            return $data;
        }else{
            $this->errors = array(
            'error'  => 'Could not find specified schedules.',
            );
            return false;
        }

    }

    public function read_all($limit = 10, $offset = 0){

        $this->db->select('*');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('schedules')
        // $sql = 'SELECT * FROM schedules LIMIT ?, ?';
        // $query = $this->db->query($sql, array(10, 0));

        if($query->num_rows > 0){

            foreach($query->result() as $row){

                $data[] = array(
                    'id'        => $row->id,
                    'userId'    => $row->userId,
                    'location'  => $row->location,
                    'address'   => $row->address,
                    'latitude'  => $row->latitude,
                    'longitude' => $row->longitude,
                    'timestart' => $row->timestart,
                    'timelength'=> $row->timelength,
                );

            }

            return $data;

        }else{

            $this->errors = array(
                'error' => 'No schedules found!',
            );

            return false;

        }

    }

    
    public function update($id, $data){

        $this->validator->setup_rules(array(
            'address'  => array(
                'set_label:Address',
                'NotEmpty',
                'MinLength:5',
                'MaxLength:255'
                ),
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

            $this->errors = array(
                'validation_error' => $this->validator->get_errors(),
            );
            return false;

        }

        $this->db->where('id', $id);
        $this->db->update('schedules', $data);

        //greated or equal to zero (means update worked)
        if($this->db->affected_rows() > 0){

            return true;

        }else{

            $this->errors = array(
            'error'  => 'Nothing to update.',
            );
            return false;

        }

    }

    public function delete($id){

        $this->db->where('id', $id);
        $this->db->delete('schedules');

        if($this->db->affected_rows() > 0){

            return true;

        }else{

            $this->errors = array(
            'error'  => 'Nothing to delete.',
        );

            return false;

        }

    }

    public function get_errors(){
        
        return $this->errors;

    }

}

