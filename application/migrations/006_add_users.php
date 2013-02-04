<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {
	public function up() {
		$fields = array(

			'api_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				),
			);
		$this->dbforge->add_key(array('api_key'));
		$this->dbforge->add_column('users', $fields);
	}
		public function down() {
			$this->dbforge->drop_column('users','api_key');
		}
	}
/* End of file 007_add_users.php */