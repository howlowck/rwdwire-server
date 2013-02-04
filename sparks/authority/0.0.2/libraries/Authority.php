<?php 
/**
 * Authority
 *
 * Authority is an authorization library for CodeIgniter 2+ and PHPActiveRecord
 * This library is inspired by, and largely based off, Ryan Bates' CanCan gem
 * for Ruby on Rails.  It is not a 1:1 port, but the essentials are available.
 * Please check out his work at http://github.com/ryanb/cancan/
 *
 * @package     Authority
 * @version     0.0.3
 * @author      Matthew Machuga
 * @license     MIT License
 * @copyright   2011 Matthew Machuga
 * @link        http://github.com/machuga
 *
 **/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require 'authority/ability.php';
require 'authority/rule.php';

class Authority extends Authority\Ability {

    public static function initialize($user)
    {   

        Authority::action_alias('manage', array('create', 'read', 'update', 'delete'));
        Authority::action_alias('moderate', array('read', 'update', 'delete' ));
        // an example configuration

        /*
        

        if ( ! $user || ! $user->role) return false;

        if ($user->role == 'admin')
        {
            Authority::allow('manage', 'all');
            Authority::deny('update', 'User', function ($a_user) use ($user) {
                return $a_user->id !== $user->id;
            });
        }

        if ($user->role == 'member')
        {

            Authority::allow('manage', 'Project');
            Authority::allow('manage', 'User', function($a_user) use ($user) {
                return $user->id == $a_user->id;
            });
        }

        if ($user->role == 'client')
        {
            Authority::allow('read', 'Project', function($project) use ($user) {
                return $user->company_id == $project->company_id;
            });
        }
        */
        if ( ! $user || ! $user->role) return false;

        if ($user->is('admin')){
            Authority::allow('manage','all');
        }
        if ($user->is('user')) {
            //Authority::allow('read','articles');
            Authority::allow('read', 'Users');
            //Authority::allow('moderate','User');
            Authority::deny('read', 'Users', function ($user_id) use ($user) {
                die($user_id == $user->id);
                //return $user_id !== $user->id;
            }); 
        }
    }

    protected static function current_user()
    {
        $ci = get_instance();
        return $ci->current_user;
    }
}
