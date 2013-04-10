<?php

use Polycademy\Validation\Validator;

//assume that the google results are stored in schedules model
class Matching_model extends CI_Model{

    protected $errors;
    private $validator;

    public function __construct(){
        parent::__construct();
        $this->validator = new Validator;
    }

    public function owns_schedule($schedule_id, $user_id){
        $rules = array(
            'id'    => array(
                'set_label:Schedule ID',
                'Number'
            )
        );

        $this->validator->setup_rules($rules);

        $data = array(
            'id'    => $schedule_id,
        );

        if($this->validator->is_valid($data)){

            $query = $this->db->get_where('schedules', array('id' => $schedule_id));

            $result = $query->row();

            if($result->userId == $user_id){
                return $result;
            }else{
                $this->errors = array(
                    'error' => 'The user ' . $user_id . ' does not own the schedule ' . $schedule_id,
                );
                return false;
            }


        }else{

            $this->errors = array(
                'validation_error' => $this->validator->get_errors(),
            );

            return false;

        }

    }

    //THIS FUNCTION IS TO READ ALL THE MATCHED SCHEDULES
    public function read_all($own_schedule, $kmrange, $limit,$offset){
    
        $latitude = $own_schedule->latitude;
        $longitude = $own_schedule->longitude;
        $table_name = 'schedules';
        //this is a timestamp calculation

        //timestamp again!
        $timestart = $own_schedule->timestart;
        $timeend = $own_schedule->timeEnd;

        //sql query to find all position matches, based on km range, will show all the results plus a distance column that will be ordered from closest to furtherest away
        $sql = 'SELECT *, 
                ( 
                    6371 * 
                    acos( 
                        cos( radians(?) ) * 
                        cos( radians( latitude ) ) * 
                        cos( radians( longitude ) - radians(?) ) + 
                        sin( radians(?) ) * sin( radians( latitude ) ) 
                    ) 
                ) AS distance 
                FROM schedules 
                WHERE (timestart <= ?) AND (timeEnd >= ?) 
                HAVING distance < ? 
                ORDER BY distance 
                LIMIT ? , ?'; //LIMIT has to use INTEGERS!

        $query = $this->db->query($sql, array($latitude, $longitude, $latitude, $timeend, $timestart, $kmrange, (integer) $offset, (integer) $limit));

        if($query){

            foreach($query->result() as $row){

                $data[] = array(
                    'id'        => $row->id,
                    'userId'    => $row->userId,
                    'email'     => $this->ion_auth->user()->row()->email,
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


// THE BELOW FUNCTION VincentyDistance IS FROM http://stackoverflow.com/questions/5236921/geo-search-distance-in-php-mysql-performance

	public function distance($lat1, $lat2, $lon1, $lon2){
        $a = 6378137 - 21 * sin($lat1);
        $b = 6356752.3142;
        $f = 1/298.257223563;

        $p1_lat = $lat1/57.29577951;
        $p2_lat = $lat2/57.29577951;
        $p1_lon = $lon1/57.29577951;
        $p2_lon = $lon2/57.29577951;

        $L = $p2_lon - $p1_lon;

        $U1 = atan((1-$f) * tan($p1_lat));
        $U2 = atan((1-$f) * tan($p2_lat));

        $sinU1 = sin($U1);
        $cosU1 = cos($U1);
        $sinU2 = sin($U2);
        $cosU2 = cos($U2);

        $lambda = $L;
        $lambdaP = 2*M_PI;
        $iterLimit = 20;

        while(abs($lambda-$lambdaP) > 1e-12 && $iterLimit>0) {
            $sinLambda = sin($lambda);
            $cosLambda = cos($lambda);
            $sinSigma = sqrt(($cosU2*$sinLambda) * ($cosU2*$sinLambda) + ($cosU1*$sinU2-$sinU1*$cosU2*$cosLambda) * ($cosU1*$sinU2-$sinU1*$cosU2*$cosLambda));

            //if ($sinSigma==0){return 0;}  // co-incident points
            $cosSigma = $sinU1*$sinU2 + $cosU1*$cosU2*$cosLambda;
            $sigma = atan2($sinSigma, $cosSigma);
            $alpha = asin($cosU1 * $cosU2 * $sinLambda / $sinSigma);
            $cosSqAlpha = cos($alpha) * cos($alpha);
            $cos2SigmaM = $cosSigma - 2*$sinU1*$sinU2/$cosSqAlpha;
            $C = $f/16*$cosSqAlpha*(4+$f*(4-3*$cosSqAlpha));
            $lambdaP = $lambda;
            $lambda = $L + (1-$C) * $f * sin($alpha) * ($sigma + $C*$sinSigma*($cos2SigmaM+$C*$cosSigma*(-1+2*$cos2SigmaM*$cos2SigmaM)));
        }

        $uSq = $cosSqAlpha*($a*$a-$b*$b)/($b*$b);
        $A = 1 + $uSq/16384*(4096+$uSq*(-768+$uSq*(320-175*$uSq)));
        $B = $uSq/1024 * (256+$uSq*(-128+$uSq*(74-47*$uSq)));

        $deltaSigma = $B*$sinSigma*($cos2SigmaM+$B/4*($cosSigma*(-1+2*$cos2SigmaM*$cos2SigmaM)- $B/6*$cos2SigmaM*(-3+4*$sinSigma*$sinSigma)*(-3+4*$cos2SigmaM*$cos2SigmaM)));

        $s = $b*$A*($sigma-$deltaSigma);
        return $s/1000;
    }

	// public function time_matching(){

	// }

	public function matching(){

        //$date1 = $user->date; // to be insert into the table
        $this->db->get('schedules');

		$query = $this->db->insert_id();
       
        // THIS CONDITION IS TO COMPARE WHETHER DISTANCEW BETWEEN 2 POINTS IS LESS THAN 0.5 KM

		if (!empty($query)){
            
                $lat1 = $user['latitude'];
                $lon1 = $user['longitude'];
                $start1 = $user['timestart'];
                $length1 = $user['timeEnd'];
   				foreach ($users as $user)
   				{
   					$lat2 = $user['latitude'];
					$lon2 = $user['longitude'];
					$d = $this->VincentyDistance($lat1,$lat2,$lon1,$lon2);

			      	if($d < 0.5){
			      		//USE FUNCTION TO MATCH THE TIME
                        return ;
			      	}else{

                        $this->errors = array(
                            'error' => 'Could not match any schedule.'
                            );
                        return false;
			      		//DO NOTHING
		      	   }
                }
		}
		     
	}
 

    public function get_errors(){
        
        return $this->errors;
        
    }





// 	}

// 	public function show($id){

// 	}

// 	public function update($id){

// 	}

// 	public function delete($id){

// 	}
}