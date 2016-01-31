<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_Site_Email extends MY_Form
{
    
    public $name;
    public $email;
    public $subject;
    public $message;
    
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->name     = $MY->input->post('name');
        $this->email    = $MY->input->post('email');
        $this->subject  = $MY->input->post('subject');
        $this->message  = $MY->input->post('message');
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->email) )
        {
            $this->addError('email', 'Campo no debe estar vacío');
        }   
        
        if( !valid_email($this->email) )
        {
            $this->addError('email', 'Email Invalido');
        }   
        
        if( empty($this->subject) )
        {
            $this->addError('subject', 'Campo no debe estar vacío');
        }   
        
        if( empty($this->message) )
        {
            $this->addError('message', 'Campo no debe estar vacío');
        }   
        
        return $this->isErrorEmpty();
    }
    
    public function getEmail()
    {
        $Email = array();
        
        $Email['name']      = $this->name;
        $Email['email']     = $this->email;
        $Email['subject']   = $this->subject;
        $Email['message']   = $this->message;
        
        return $Email;
    }

    
}