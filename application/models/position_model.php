<?php

use Guzzle\Http\Client;

class Position_model extends CI_Model{

	public function get_location($location){

		// Create a client and provide a base URL
		$client = new Client('http://maps.googleapis.com/maps/api/geocode/json');

		$request = $client->get('?address=' . $location . '&sensor=false');

		// Send the request and get the response
		$response = $request->send();
		//decode json file to get the longitude and latitude

		$json = json_decode($response->getBody(), true);
		var_dump($json);

		if($json["results"][0]["formatted_address"] AND $json["results"][0]["geometry"]["viewport"]["northeast"]){
				$position["address"] = $json["results"][0]["formatted_address"];
				$position["latitude"] = $json["results"][0]["geometry"]["viewport"]["northeast"]["lat"];
				$position["longitude"] = $json["results"][0]["geometry"]["viewport"]["northeast"]["lng"];

				return $position;
				
				$code = 'success';
				$content = 'LOCATION FOUND ... I AM AWESOME';
				$this->output->set_status_header(201);
			}else{
				$code = 'error';
				$content = 'OOPPS LOCATION NOT FOUND';
				$this->output->set_status_header(400);

			}
		
		}
}