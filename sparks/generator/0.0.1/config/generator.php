<?php

# The path to your different types of files
$config['migrations_path'] = APPPATH . 'migrations/';
$config['controllers_path'] = APPPATH . 'controllers/';
$config['views_path'] = APPPATH . 'views/';
$config['models_path'] = APPPATH . 'models/';


// $config['jquery_path'] = '../public/vendors/jquery/jquery-1.8.2.min.js';
$config['jquery_path'] = 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js';


// Default Controller Names

$config['generator_controller_extends'] = "MY_Controller";
$config['generator_controller_index_action'] = "_index";
$config['generator_controller_create_action'] = "_create";
$config['generator_controller_read_action'] = "_show";
$config['generator_controller_update_action'] = "_update";
$config['generator_controller_delete_action'] = "_destroy";
$config['generator_controller_create_form'] = "_new";
$config['generator_controller_read_form'] = "";
$config['generator_controller_update_form'] = "_edit";
$config['generator_controller_delete_form'] = "";
