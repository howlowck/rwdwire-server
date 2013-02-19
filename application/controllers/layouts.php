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
	function load_layout() {
		$post = $this->input->post();
		$layout = new Layout();
		$layout->get_by_name($post["uid"]);
		$output["dimensions"] = $layout->width;
		$output["elements"] = $layout->element;
		echo json_encode($output);
	}
	function save_layout() {
		$post = $this->input->post();

		$user = new User();
		$user->get_by_api_key($post["key"]);

		if (!$user->exists()) {
			echo "User not logged in";
			return false;
		}

		$orig_layout = new Layout();

		if ($post["uid"] == "") {
			$orig_layout->save();
			$orig_layout->name = uniqid($orig_layout->id);
			$orig_layout->width = $post["widths"];
			$orig_layout->element = $post["elements"];
			$orig_layout->user_id = $user->id;
			$orig_layout->save();
			echo "successful! create brand new!";
			return true;
		} 

		else{ 
			$orig_layout->get_by_name($post["uid"]);

			if($orig_layout->user_id != $user->id) {//not the original user, so create a new layout but save the original layout in parent_id
				$new_layout = new Layout();
				$new_layout->parent_id = $orig_layout->id;
				$new_layout->save();
				$new_layout->name = uniqid($new_layout->id);
				$new_layout->width = $post["widths"];
				$new_layout->element = $post["elements"];
				$new_layout->user_id = $user->id;
				$new_layout->save();
				echo "successful! createfrom another layout";
				return true;
			} else {
				$orig_layout->width = $post["widths"];
				$orig_layout->element = $post["elements"];
				$orig_layout->save();
				echo "successful! update old layout";
				return true;
			}
		} 
	}
} 

/* End of file layouts.php in application/controllers/   */