<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_address_column extends CI_Migration {
	
	public function up(){
		$field = array(
                        'address' => array(
                        	'type' => 'VARCHAR',
                        	'constraint' => '255'
                        	)
		);

		$this->dbforge->add_column('schedules', $field);
				
	}

	public function down(){
		$this->dbforge->drop_column('schedules', 'address');
	}
}