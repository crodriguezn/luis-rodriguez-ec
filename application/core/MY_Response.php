<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Response
{
    protected $isSuccess;
    protected $message;
    protected $data;

	function __construct()
    {
        $this->isSuccess = FALSE;
        $this->message   = '';
        $this->data      = array();
    }
    
    public function isSuccess( $isSuccess = NULL )
    {
        if( !is_bool($isSuccess) )
        {
            return $this->isSuccess;
        }
        
        $this->isSuccess = $isSuccess;
    }
    
    public function message( $message = NULL )
    {
        if( !is_string($message) )
        {
            return $this->message;
        }
            
        $this->message = $message;
    }

    public function data( $data_name='', $mixed=FALSE )
    {
        if( empty($data_name) )
        {
            return $this->data;
        }
        
        if( $mixed === FALSE )
        {
            return isset($this->data[ $data_name ]) ? $this->data[ $data_name ] : $mixed;
        }
        
        $this->data[ $data_name ] = $mixed;
    }
    
    public function toArray()
    {
        $arrR = array();
        
        $arr = get_class_vars( get_class($this) );
        foreach( $arr as $attr => $value )
        {
            $arrR[ $attr ] = $this->$attr;
        }
        
        return $arrR;
    }
}