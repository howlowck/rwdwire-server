<?php

class Layout extends DataMapper {

    public $table = 'layouts';
    public $has_many = array('user');

    public function __construct() {
        parent::__construct();
    }

}