<?php

class Role extends DataMapper {

    public $table = 'roles';
    public $has_many = array('user');

    public function __construct() {
        parent::__construct();
    }

    

}