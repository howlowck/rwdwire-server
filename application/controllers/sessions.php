<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }
    protected function _authorize(){
        $response = parent::_authorize();   

        switch ($this->action)
        {
            case 'logout': 
                return $this->current_user;
                break;
        }
        return $response;
    }
    function login(){
        if ( $this->session->userdata('user_id')!=NULL){
            $this->session->set_flashdata('notice','You are already signed in.');
            redirect('welcome');
        }

        $this->template->build('sessions/login',$this->data);
    }
    
    function authenticate(){
        $email = strtolower($this->input->post('email',TRUE));
        $password = $this->input->post('password');
        $user = User::authenticate($email, $password);

        if (!$user){
            $this->session->set_flashdata('error','Sorry your credentials didn\'t match.');
            $this->gen_lib->redirect('sessions/login');
        }

        if ($user->verif != 1){
            $this->session->set_flashdata('error','Hold your horses... Check your email for the verification email please, then follow the instructions there.');
            $this->gen_lib->redirect('sessions/login');
        }
        $this->session->set_userdata('user_id',$user->id);
        $this->session->set_flashdata('success','Hello! '.$user->first_name . ' you are now logged in.');
        $this->gen_lib->redirect("","resume");
    }

    function logout(){
        $this->session->unset_userdata('user_id');
        $this->session->set_flashdata('success','you have logged out');
        redirect('welcome');
    }
}

