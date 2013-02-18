<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

Class Layouts extends MY_Controller{ 

	function __construct() {
		parent::__construct();
		// Load class-wide libraries here
	}

	function _create() { 
		
	}

	function _show() { 
		// Add Your Read Action Code here
	}

	function _update() { 
		// Add Your Update Action Code here
	}

	function _destroy() { 
		// Add Your Delete Action Code here
	}
	function save_layout() {
		$post = $this->input->post();

		$user = new User();
		$user->get_by_api_key($post["key"]);
		if (!$user->exists()) {
			echo "User not logged in";
			return false;
		}
		$layout = new Layout();
		if ($post["uid"] == "") {
			$layout->save();
			$layout->name = uniqid($layout->id);
		} elseif ($layout->user_id != $user->id) {
			echo "Wrong User";
			return false;
		} else {
			$layout->get_by_name($post["uid"]);
		}
		
		$layout->width = $post["widths"];
		$layout->element = $post["elements"];
		$layout->creator_id = $user->id;
		$layout->save();
		echo "successful!";
		return true;
	}
} 

/* End of file layouts.php in application/controllers/   */