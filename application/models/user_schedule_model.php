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
                'MaxLength:255'
            ),
            'timestart' => array(
                'set_label:Starttime',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'timeEnd' => array(
                'set_label:TimeEnd',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'longitude' => array(
                'set_label:Longitude',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'latitude' => array(
                'set_label:Latitude',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'streetNumber' => array(
                'set_label:Street Number',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ), 
            'route' => array(
                'set_label:Route',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'locality' => array(
                'set_label:Locality',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'administrativeAreaLevel' => array(
                'set_label:Administrative area level',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'country' => array(
                'set_label:Country',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'postCode' => array(
                'set_label:Post code',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            )
        );

        $this->validator->setup_rules($rules);

        //VALIDATE THE DATA FIELDS AND INSERT DATA INTO THE TABLE
        if(!$this->validator->is_valid($data)){

            //returns array of key for data and value
            $this->errors = array(
                'validation_error' => $this->validator->get_errors()
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

    //take the user id, and return all schedules that are part of the user
    public function read($id){

        $this->db->limit($limit,$offset);
        $query = $this->db->get_where('schedules', array('userId' => $id));

        if($query->num_rows() > 0){

            foreach($query->result() as $row){

                $data[] = array(
                    'id'        => $row->id,
                    'userId'    => $id,
                    'location'  => $row->location,
                    'address'   => $row->address,
                    'latitude'  => $row->latitude,
                    'longitude' => $row->longitude,
                    'timestart' => $row->timestart,
                    'timeEnd'   => $row->timeEnd,

                );

            }

            return $data;

        }else{

            $this->errors = array(
                'error'  => 'Could not find specified schedules for user ' . $id . '.',
            );

            return false;

        }

    }



    public function read_all($limit,$offset){

        $this->db->select('*');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('schedules');
        // $sql = 'SELECT * FROM schedules LIMIT ?, ?';
        // $query = $this->db->query($sql, array(10, 0));
      
        if($query){

            foreach($query->result() as $row){

                $data[] = array(
                    'id'        => $row->id,
                    'userId'    => $row->userId,
                    'location'  => $row->location,
                    'address'   => $row->address,
                    'latitude'  => $row->latitude,
                    'longitude' => $row->longitude,
                    'timestart' => $row->timestart,
                    'timeEnd'   => $row->timeEnd
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
                'MinLength:5',
                'MaxLength:100',
            ),
            'timeEnd' => array(
                'set_label:time end',
                'NotEmpty',
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
            'streetNumber' => array(
                'set_label:Street Number',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ), 
            'route' => array(
                'set_label:Route',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'locality' => array(
                'set_label:Locality',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'administrativeAreaLevel' => array(
                'set_label:Administrative area level',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'country' => array(
                'set_label:Country',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            ),
            'postCode' => array(
                'set_label:Post code',
                'NotEmpty',
                'MinLength:1',
                'MaxLength:100'
            )

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

