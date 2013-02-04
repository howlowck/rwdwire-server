<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Application-level Controller which almost all controllers should inherit from
 *
 * @author haoluo
 */

class MY_Controller extends CI_Controller {
    public $action = NULL;
    public $current_user = NULL;
    public $app_name = 'RWDWire Server App';
    public $params = NULL;
    public $format = 'html';
    public $data = array();
    public $controller = NULL;
    private $guest_allowed = array(
                                'welcome'=>  'all',
                                'sessions'=>//controller
                                    array(//action in controller
                                        'login',
                                        'authenticate'
                                    ),
                                'users'=>
                                    array(
                                        '_new',
                                        '_create',
                                        'emailConf',
                                        'passwordResetInit',
                                        'passwordResetEmailForm',
                                        'passwordResetForm',
                                        'passwordReset',
                                        'login'

                                    ),
                                'generate'=>'all',
                             );
    function __construct()
	{
            parent::__construct();
            //$this->session->set_userdata('loggedin', false);

            $this->_load_sparks();
            $this->load->library('session');
            $this->data['app_name'] = $this->app_name;
            if($this->session->userdata('user_id')){
                $user = new User();
                $this->current_user = $user->get_by_id($this->session->userdata('user_id'));
                $this->data['current_user'] = $this->current_user;
            }
	}
    protected function _authorize(){

        /* set to TRUE if testing */
        /* this is the default value which is meant to be overwritten in most cases*/
        return FALSE;
    }
    private function _load_sparks(){
        $this->load->spark('DataMapper-ORM/1.8.2');
        $this->load->spark('authority/0.0.2');

    }
    public function _remap($action, $params = array() ){
		$this->action     = $action;
		$this->params     = $params;
        $this->controller = $this->router->class;
        switch ($action)
        {
            case 'index':  $this->action = '_index'  ; break;
            case 'show':   $this->action = '_show'   ; break;
            case 'new':    $this->action = '_new'    ; break;
            case 'create': $this->action = '_create' ; break;
            case 'edit':   $this->action = '_edit'   ; break;
            case 'update': $this->action = '_update' ; break;
            case 'destroy':$this->action = '_destroy'; break;
        }

		if ($this->_authorize())
		{
			return $this->_execute();
		}
		else {
            #for guest allowed
            if (array_key_exists($this->controller, $this->guest_allowed)){

                if($this->guest_allowed[$this->controller]=='all') {

                    return $this->_execute();
                }
                elseif(in_array($this->action, $this->guest_allowed[$this->controller])){
                    return $this->_execute();
                }
            } 
            #for pages that reqiure login
            if ($this->current_user) {
                $this->session->set_flashdata("error","Sorry, you are not authorized.");
                redirect("welcome");
            }
            else{
                $this->session->set_flashdata("error","Sorry, you are not authorized.  Please Login in first.");
                $this->gen_lib->redirect("sessions/login","save");
            }
		}
        show_404();
	}
    private function _execute(){
        if (method_exists($this, $this->action)){
            return call_user_func_array(array($this, $this->action), $this->params);
        }
        show_error("The Action does not exist!");
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */
