<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $name_key = '';
    protected $permission = NULL;
    
    protected $link;
    protected $linkx;
    
    const SYSTEM_0 = 0;
    const SYSTEM_SITE = 1;


    function __construct( $SYSTEM_NAME = MY_Controller::SYSTEM_0 )
    {
        parent::__construct();        

        // application
        $this->lang->load('upload', 'spanish');
        
        // AUTOLOAD
        // libraries: upload, libsession
        // helper: url, encrypt, log, fecha, array, email, file, captcha, request, browser
        // config: cah
        // models: default
        // entities: default/*
        
        if( $SYSTEM_NAME == MY_Controller::SYSTEM_SITE )
        {
            //$this->load->database();   
            $this->link  = "site/" . $this->name_key;
            $this->linkx = "site/" . $this->name_key . 'x';
        }
    }
    
    public function redirect( $uri )
    {
        redirect($uri);
    }
    
    /*
     * Se imvoca solamente para mandar permisos del modulo a los js del mvc
     */
    public function mvcjs()
	{
        $js_path = str_replace('_', '/', $this->name_key);
        
        $params = array();
        
        Helper_App_JS::showMVC($js_path, $params);
    }
    
    public function permissionCan( $permission_key )
    {
        return in_array($permission_key, $this->Module_Permissions);
    }

    
}