<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_schedules extends CI_Migration {
	
	public function up(){
		$this->dbforge->add_field('id');

		$this->dbforge->add_field(array(
			'user_id'		 => array(
								'type' => 'INT',
								'constraint' => '255'
								),
			'longitude' 	=> array(
								'type' 	=> 'FLOAT'
								),
			'latitude'		=> array(
								'type' => 'FLOAT'
								),
										
			'location' 		=> array(
								'type'=> 'VARCHAR',
								'constraint'=>'100'
								),
			'timestart'		=> array(
								'type'=> 'TIME',
								),
			'timelength'	=> array(
								'type'=> 'INT',
								'constraint'=>'5'
								),
			
		));


		$this->dbforge->create_table('schedules');
	}

	public function down(){
		$this->dbforge->drop_table('schedules');
	}
}
