<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_date_column extends CI_Migration{

	public function up(){
		$field = array(
			'date' => array(
				'type' => 'DATE'
				)
			);
		$this->dbforge->add_column('schedules', $field);

	}

	public function down(){
		$this->dbforge->drop_column('schedules','date');

	}
}