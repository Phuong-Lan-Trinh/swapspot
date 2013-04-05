<?php
//assume that the google results are stored in schedules model
class Matching_model extends CI_Model{

    protected $errors;

	public function index(){}


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

	public function matching($id){

        //$date1 = $user->date; // to be insert into the table

		$users = $this->ion_auth->users(2);
       
// THIS CONDITION IS TO COMPARE WHETHER DISTANCEW BETWEEN 2 POINTS IS LESS THAN 0.5 KM

		if (!empty($users)){
                $user = $this->ion_auth->user()->row();
                $lat1 = $user['latitude'];
                $lon1 = $user['longitude'];
                $start1 = $user['timestart'];
                $length1 = $user['timelength'];
   				foreach ($users as $user)
   				{
   					$lat2 = $user['latitude'];
					$lon2 = $user['longitude'];
					$d = $this->VincentyDistance($lat1,$lat2,$lon1,$lon2);

			      	if($d < 0.5){
			      		//USE FUNCTION TO MATCH THE TIME
                        return $d;
			      	}else{

                        $this->errors = array(
                            'error' => 'Could not match any schedule.'
                            );
                        return false
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