<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_layouts extends CI_Migration {
	public function up() {
		$fields = array(

			'parent_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				),
			);
		$this->dbforge->add_key(array('parent_id'));
		$this->dbforge->add_column('layouts', $fields);
	}
		public function down() {
			$this->dbforge->drop_column('layouts','parent_id');
		}
	}
/* End of file 008_add_layouts.php */