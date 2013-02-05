<?php

class User extends DataMapper {

    public $table = 'users';
    public $has_many = array('role');
    public $validation = array(
                            'email' => array(
                                'label' => 'Email Address',
                                'rules' => array('required','trim', 'valid_email','unique')
                            ),
                            'password_hash' => array(
                                'label' => 'Password',
                                'rules' => array('required','min_length' => 6, 'encrypt')
                            ),
                            'vpassword' => array(
                                'label' => 'Verify Password',
                                'rules' => array('required','encrypt','matches'=>'password_hash')
                            ),
                        );

    public function __construct($id = NULL) {
        parent::__construct($id);
    }

    public function is($testRole){
        $roles = array();
        if (is_array($this->role->name)) {
            $roles =  $this->role->name;
        }
        else{
            $roles = explode(" ",$this->role->name, 1);
        }
        return in_array($testRole,$roles);
    }

    public static function authenticate($email, $password) {
        $user = new User;
        //$user->get_by_netid($username);
        $user->get_by_email($email);

        //if ($user->exists() && $user->password_hash != NULL) {  //This is part of the LDAP code
            if ($user->password_hash == crypt($password,$user->salt)) {
                log_message('info',$user->first_name.' authenticated locally');
                return $user;
            } else {
                return false;
            }
            //LDAP Code goes here!
    }

    function _encrypt($field){
        // Don't encrypt an empty string
        if (!empty($this->{$field}))
        {
            //Generate a random salt if empty
            if (empty($this->salt))
            {
                $this->salt = '$2a$07$'.substr(md5(uniqid(rand(), true)),0,22).'$';
            }
            $this->{$field} = crypt($this->{$field},$this->salt);
        }
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
