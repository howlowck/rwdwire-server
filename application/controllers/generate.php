<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generate Controller Used by the Generator Spark
 * @todo Generate Controller, form, view, and create
 */
class Generate extends CI_Controller {
	public function __construct() {
		if(!in_array($_SERVER["SERVER_ADDR"], array('::1', '127.0.0.1'))){
		    die("not on local!");
		}
        parent::__construct();
        $this->load->spark('generator/0.0.1');
        $this->load->database();
    }

	public function index()
	{
		$this->load->view('generate/index');
	}
	/**
	 * Renders Migration Creation Form
	 */
	public function form_migration(){
		$this->load->helper('form');
		$this->load->view('generate/form_migration');
	}

	/**
	 *  Ajax Call Function Shows migration file
	 * @return string HTML 
	 */
	public function view_migration(){
		
		$post = $this->input->post();
        $filename = render_migration_filename($post['type'], $post['name']);
        $filecontent = render_migration_content($post['type'],$post['name'],$post['columns']);
        echo "<br><br><b> Will generate $filename </b><br><br>";
        echo '<div id="file-preview">';
        highlight_string($filecontent);
        echo '</div>';
	}
	/**
	 * Ajax Call Function calls Spark Generate function
	 */
	public function create_migration(){
		$migration_data = $this->input->post();
		$generate = new Generator();
        if(!$generate->migration($migration_data)){
        	//show_error("Sorry, The migration was not generated correctly");
        	echo 0;
        }
        else{
        	echo 1;
        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */