<?php

use Guzzle\Http\Client;

class Position extends CI_Model{

	public function get_location($location){

		// Create a client and provide a base URL
		$client = new Client('http://maps.googleapis.com/maps/api/geocode/json');

		$request = $client->get('?address' . $location . '&sensor=false');

		// Send the request and get the response
		$response = $request->send();


		$json = json_decode($response->getBody(), true);

		foreach ($json as $point) {
			if($point["formatted_address"]){
				return $address = $point["formatted_address"];
				$this->dbforge->insert()
			}

			if($point["geometry"]["viewport"]["northeast"]){
				
				$position['lat'] = $point["geometry"]["viewport"]["northeast"]["lat"];
				$poisition['long'] = $point["geometry"]["viewport"]["northeast"]["lng"];

				return $position;
			}
		}


	}

}