<?php

use Guzzle\Http\Client;

class Position_model extends CI_Model{

	protected $errors;

	public function get_location($location){

		// Create a client and provide a base URL
		$client = new Client('http://maps.googleapis.com/maps/api/geocode/json');

		$request = $client->get('?address=' . $location . '&sensor=false');

		// Send the request and get the response
		$response = $request->send();
		//decode json file to get the longitude and latitude

		$json = json_decode($response->getBody(), true);

		if($json["results"]){
			
			$position["address"] = $json["results"][0]["formatted_address"];
			$position["latitude"] = $json["results"][0]["geometry"]["viewport"]["northeast"]["lat"];
			$position["longitude"] = $json["results"][0]["geometry"]["viewport"]["northeast"]["lng"];
			$position['streetNumber'] =  $json["results"][0]["address_components"][0]["short_name"];
			$position['route'] =  $json["results"][0]["address_components"][1]["short_name"];
			$position['locality'] =  $json["results"][0]["address_components"][2]["short_name"];
			$position['administrativeAreaLevel'] =  $json["results"][0]["address_components"][3]["short_name"];
			$position['country'] =  $json["results"][0]["address_components"][4]["short_name"];
			$position['postCode'] =  $json["results"][0]["address_components"][5]["short_name"];
			// $code = 'success';
			// $content = 'LOCATION FOUND ... I AM AWESOME';
			// $this->output->set_status_header(201);
			return $position;
				
				
		}else{

			$this->errors = array(
				'error' => 'Could not get data from Google'
				);

			return false;

				// $code = 'error';
				// $content = 'OOPPS LOCATION NOT FOUND';
				// $this->output->set_status_header(400);

		}

			// $output = array(
			// 'content' => $content,
			// 'code' => $code,
			// 'redirect' => '',
			// );

		// Template::compose(false, $output, 'json');
		
	}

    public function get_errors(){
        
        return $this->errors;
        
    }		
}