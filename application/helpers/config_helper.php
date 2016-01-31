<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Config
{
    static public function getEmail()
    {
        $MY =& MY_Controller::get_instance();
        
        $config_email = $MY->config->item('email');
        
        return $config_email;
    }
    
    
}