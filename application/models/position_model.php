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

		if($json["results"][0]["formatted_address"] AND $json["results"][0]["geometry"]["viewport"]["northeast"]){
			
			$position["address"] = $json["results"][0]["formatted_address"];
			$position["latitude"] = $json["results"][0]["geometry"]["viewport"]["northeast"]["lat"];
			$position["longitude"] = $json["results"][0]["geometry"]["viewport"]["northeast"]["lng"];

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