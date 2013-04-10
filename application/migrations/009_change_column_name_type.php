<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_change_column_name_type extends CI_Migration{

	public function up(){
		$fields = array(
            'timelength' => array(
                'name' => 'timeEnd',
                'type' => 'TIMESTAMP'
                'default'	=> '0000-00-00 00:00:00',
            ),
            'timestart' => array(
            	'type' => 'TIMESTAMP',
            	'default'	=> '0000-00-00 00:00:00',
            )

		);
		$this->dbforge->modify_column('schedules', $fields);


	}

	public function down(){
		$fields = array(
			'timeEnd' => array(
				'name' => 'timelength',
				'type' => 'INT'
				),
			'timestart' => array(
				'type' => 'INT'
				)

		);

	}
}
