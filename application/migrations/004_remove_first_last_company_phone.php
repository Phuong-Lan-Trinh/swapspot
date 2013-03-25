<?php

class Migration_remove_first_last_company_phone extends CI_Migration{

	public function up(){
		$this->dbforge->drop_column('users', 'first_name');
		$this->dbforge->drop_column('users', 'last_name');
		$this->dbforge->drop_column('users', 'company');
		$this->dbforge->drop_column('users', 'phone');
	}

	public function down(){
		$this->dbforge->add_column('users', 'first_name');
		$this->dbforge->add_column('users', 'last_name');
		$this->dbforge->add_column('users', 'company');
		$this->dbforge->add_column('users', 'phone');
	}

}