<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {
    
    function __construct() 
    {
        parent::__construct();
        $this->load->helper('form');
    }
    protected function _authorize(){
        $response = parent::_authorize();
        switch ($this->action)
        {
            case '_index':
                return can('read', 'Users');
                break;

            case '_show':
                return can('read', 'Users');
                break;
            case '_new':
            case '_create':
            case '_update': 
            case '_edit': 
            case '_destroy': 
                return can('manage', 'Users');
                break;
        }
        return $response;
    }
    function login() {
        header("Access-Control-Allow-Origin: http://localhost");
        header("Access-Control-Allow-Credentials: true");
        header('Content-type: application/json');
        $email = strtolower($this->input->post('email',TRUE));
        $password = $this->input->post('pass');
        $user = new User();

        $user = User::authenticate($email, $password);
        if (!$user){
            $output = array(
                'error' => 'sorry your crediential did not match'
                );
           echo json_encode($output);
           return false;
        }
        $output = array(
                'email' => $user->email,
                'api_key' => $user->api_key
                );
        echo json_encode($output);
        return true;
    }

    function register() {
        header('Content-type: application/json');
        $email = strtolower($this->input->post('email',TRUE));
        $password = $this->input->post('pass');
        $vpassword = $this->input->post('vpass');
        $user = new User();
        if ($password != $vpassword) { 
            $output = array(
                "error" => "Your passwords don't match"
            );
        } elseif ($user->get_by_email($email)->exists()) {
            $output = array(
                "error" => "Email already exists"
            );
        } else {  //If it passed my poor man's validation
            $user->email = $email;
            $user->password_hash = $password;
            $user->vpassword = $vpassword;
            if (!$user->save()) {
                foreach ($user->error->all as $e){
                    $errorMessage .= $e."<br>";
                }
                $output = array(
                    "error" => $errorMessage
                );
            }
            else {
                $user->api_key = md5(uniqid(rand(), true));
                $user->save();
                $output = array(
                    "email" => $user->email,
                    "api_key" => $user->api_key
                );
            }
        }
        
        echo json_encode($output);
        return;
    }
    function getProjects(){
        $post = $this->input->post();
        $output = array();
        $user = new User();
        $user->get_by_api_key($post["key"]);

        $layout = new Layout();
        $layout->where("user_id", $user->id)->order_by("updated_at","desc")->get();

        $count = 0;

        foreach ($layout as $oneLayout) {
            $output[$count]["name"] = $oneLayout->name;
            $output[$count]["ts"] = (!$oneLayout->updated_at) ? $oneLayout->created_at : $oneLayout->updated_at;
            $count++;
        }

        echo json_encode($output);
    }
    function _index(){
        $users = new User();
        $users->get();
        $this->data['users'] = $users;
        $this->gen_lib->include_datatables("bootstrap");
        $this->gen_lib->include_js('short','users/users.js');
        $this->template->build('users/index',$this->data);
    }
    function _show(){
        $this->template->build('users/show',$this->data);
    }
    function _new(){
        $this->template->build('users/new',$this->data);
    }

    function _create(){
        
        $post = $this->input->post();

        /* reCAPTCHA Code */
        require_once(APPPATH.'libraries/recaptchalib.php');
        $privatekey = $this->config->item('recaptcha_priviate');
        $resp = recaptcha_check_answer ($privatekey,
                                      $_SERVER["REMOTE_ADDR"],
                                      $_POST["recaptcha_challenge_field"],
                                      $_POST["recaptcha_response_field"]);
        if (!$resp->is_valid) {
          // What happens when the CAPTCHA was entered incorrectly
            $this->session->set_flashdata("error", "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
               "(reCAPTCHA said: " . $resp->error . ")");
            $this->gen_lib->flashFormData($post, array("password_hash","vpassword"));
            $this->gen_lib->redirect("users/new");
        }

        /* End of reCAPTCHA Code */
 
        $user = new User();
        
        foreach ($post as $name => $value) {
            $user->$name = $post[$name];
        }

        $role = new Role();
        $role->get_by_name("user");


        $user->verif = md5(time());
        if (!$user->save($role)) {
            $errorMessage = "";
            foreach ($user->error->all as $e){
                $errorMessage .= $e;
            }

            $this->session->set_flashdata('error',$errorMessage);

            $this->gen_lib->flashFormData($post, array("password_hash","vpassword"));
            $this->gen_lib->redirect("users/new");
        }
        $this->session->set_flashdata('success','you have been added!! <br> Check your email inbox for a confirmation email :)');
        $this->sendEmailVerify($user);
        $this->gen_lib->redirect("welcome","resume");
    }

    function _edit($id){
        $this->template->build('users/edit',$this->data);
    }

    function _update(){
        
    }

    function _destroy($user_id){
        $user = new User($user_id);
        $user->delete();
        $this->gen_lib->redirect("users/index");
    }
    public function sendEmailVerify($user){
        $link = base_url("users/emailConf?username={$user->username}&verif={$user->verif}");
        $this->load->library('email');
        $this->email->from("noreply@example.com", $this->app_name." Admin");
        $this->email->to($user->email);
        $this->email->subject($this->app_name." Email Confirmation");
        $this->email->message($this->load->view('users/email_verify',array('link'=>$link),TRUE));
        if (!$this->email->send()) {
            $this->session->set_flashdata("error","Sorry your email confirmation could not be sent. Admin has been notified.");// <br>".$this->email->print_debugger());
            $user->verif = "ERROR";
            $user->save();
        }
    }


    public function emailConf(){
        $get = $this->input->get();
        // if (!$this->current_user) {
        //     $this->session->set_flashdata("error","Please login first");
        //     $this->gen_lib->redirect("sessions/login","save");
        // }elseif ($this->current_user->username != $get["username"]) {
        //     $this->session->set_flashdata("error","Hey! The username you are verifying is not your username!");
        //     $this->gen_lib->redirect("","resume");
        // }
        $user = new User();
        $user->get_by_username($get["username"]);
        if ($user->verif == $get["verif"]){
            $user->verif = 1;
            $this->session->set_flashdata("success","your email has been confirmed! You can now log in :)");
            $user->save();
            $this->gen_lib->redirect("sessions/login","resume");
        }
        if ($user->verif==1) {
            $this->session->set_flashdata("notice","You have already verified your email");
            $this->gen_lib->redirect("","resume");
        }
        $this->template->build("users/failed_email_conf");
    }

    public function passwordResetInit(){
        $this->template->build("users/password_reset_init", $this->data);
    }
    public function passwordResetEmailForm(){
        $post= $this->input->post();
        $user= new User();
        $user->get_by_email($post['email']);
        /* varify email to see if exists, if not, refresh, else redirects to input.
        /* sends reset link to email if user exists, sets pass_reset field to hash */
        if (!$user->exists()) {
            $this->session->set_flashdata("error","your email was not found");
            $this->gen_lib->redirect("users/passwordResetInit");
        }
        $user->pass_reset = md5(time());
        $user->save();

        $link = base_url("users/passwordResetForm?username={$user->username}&verif={$user->pass_reset}");
        // $this->load->library('email');
        // $this->email->from("noreply@example.com", $this->app_name." Admin");
        // $this->email->to($user->email);
        // $this->email->subject($this->app_name." Password Reset");
        // $this->email->message($this->load->view('users/email_password_reset',array('link'=>$link),TRUE));
        // $this->session->set_flashdata("success","your reset email has been set, please go to your inbox and follow the directions. <br> You can close this tab.");
        // $this->gen_lib->redirect("welcome");
        $this->template->build("users/email_password_reset", array('link'=>$link));
    }
    public function passwordResetForm(){
        $get = $this->input->get();
        $user= new User();
        $user->get_by_username($get['username']);
        if ($user->pass_reset != $get["verif"]) {
            $this->session->set_flashdata("error","Something is wrong. If you want to reset your password again, please try again.");
            $this->session->redirect("sessions/login");
        }
        $this->template->build("users/password_reset_form", array("id" => $user->id));
    }
    public function passwordReset(){
        $post = $this->input->post();
        $user = new User($post["id"]);
        $reset_link = base_url("users/passwordResetForm?username={$user->username}&verif={$user->pass_reset}");

        
        $user->password_hash = $post["password_hash"];
        $user->vpassword = $post["vpassword"];
        $user->pass_reset = NULL;
        if (!$user->save()) {
            $errorMessage = "";
            foreach ($user->error->all as $e){
                $errorMessage .= $e;
            }

            $this->session->set_flashdata('error',$errorMessage);
            $this->gen_lib->redirect($reset_link);

        }
        $this->session->set_flashdata('success',"Your password has been changed.<br> Please Login.");
        $this->gen_lib->redirect("sessions/login");
    }

}

