<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_address_components_columns extends CI_Migration{

	public function up(){
		$field = array(
			'streetNumber' => array(
				'type' => 'INT',
				'constraint'	=> '5'
				), 
			'route' => array(
				'type' => 'VARCHAR',
				'constraint'	=> '255'
				),
			'locality' => array(
				'type' => 'VARCHAR',
				'constraint'	=> '255'
				),
			'administrativeAreaLevel' => array(
				'type' => 'VARCHAR',
				'constraint'	=> '255'
				),
			'country' => array(
				'type' => 'VARCHAR',
				'constraint'	=> '255'
				),
			'postCode' => array(
				'type' => 'INT',
				'constraint'	=> '10'
				)
			);
		$this->dbforge->add_column('schedules', $field);

	}

	public function down(){
		$this->dbforge->drop_column('schedules','streetNumber','route','locality','administrativeAreaLevel','country','postCode');

	}
}