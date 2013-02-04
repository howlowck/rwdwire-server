<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db extends CI_Controller {

    private $is_command_line;
    private $is_development_mode;

    function __construct()
	{
            parent::__construct();
            $this->is_command_line = (php_sapi_name() === 'cli');
            $this->is_development_mode = (ENVIRONMENT === 'development');

            $this->load->library('migration');
	}
    function migrate($opt = 'latest') {

        // only permissible to run from CLI, or from anywhere when in development:
        if ($this->is_development_mode || $this->is_command_line) {

            switch($opt) {

                case 'current':

                        if ( !$this->migration->current() )
                        {
                            show_error($this->migration->error_string());
                        } else {
                            echo "Migration to current successful".PHP_EOL;
                        }

                    break;

                case 'latest':

                        if ( !$this->migration->latest() )
                        {
                            show_error($this->migration->error_string());
                        } else {
                            echo "Migration to latest successful".PHP_EOL;
                        }

                    break;

                default:
                    echo 'Not recognized'.PHP_EOL;

            }

        } else {
            exit('not permitted');
        }
    }

}

/* End of file migrate.php */
/* Location: ./application/controllers/migrate.php */
