<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_App_Layout_Password extends MY_Data
{
    public $password_current;
    public $password_new;
    public $password_new_repeat;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->password_current = '';
        $this->password_new = '';
        $this->password_new_repeat = '';
            
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    // *********************************************
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->password_current    = $MY->input->post('password_current');
        $this->password_new        = $MY->input->post('password_new');
        $this->password_new_repeat = $MY->input->post('password_new_repeat');
    }
    
    public function isValid( &$dataError )
    {
        $isValid = TRUE;
        
        $dataError = new $this();
        
        if( empty($this->password_current) )
        {
            $dataError->password_current = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->password_new) )
        {
            $dataError->password_new = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        else if( $this->password_new != $this->password_new_repeat )
        {
            $dataError->password_new = 'Comprobación incorrecta'; $isValid=FALSE;
        }
        else if( strlen($this->password_new) < 6 )
        {
            $dataError->password_new = '6 mínimo tamaño contraseña'; $isValid=FALSE;
        }
        
        return $isValid;
    }
}