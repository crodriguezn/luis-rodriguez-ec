<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_Company_Company extends MY_Data
{
    public $name;
    public $name_key;
    public $description;
    public $phone;

    public function __construct($isReadPost = FALSE) 
    {
        parent::__construct();
        
        $this->reset();
        
        if ($isReadPost)
        {
            $this->readPost();
        }
    }

    public function reset( $RESET_TYPE=self::RESET_DEFAULT )
    {
        if( $RESET_TYPE == self::RESET_STRING )
        {
            $this->name = '';
            $this->name_key = '';
            $this->description = '';
            $this->phone = '';
        }
        else
        {
            $this->name = '';
            $this->name_key = '';
            $this->description = '';
            $this->phone = '';
        }
    }
    
    public function readPost()
    {
        $MY = & MY_Controller::get_instance();
        
        $this->name = $MY->input->post('name');
        $this->description = $MY->input->post('description');
        $this->name_key = $MY->input->post('name_key');
        $this->phone = $MY->input->post('phone');
    }

    public function isValid( &$data_error )
    {
        $isValid = TRUE;
        
        $data_error = new $this();
        $data_error->reset(self::RESET_STRING);
        
        if( empty($this->name) )
        {
            $data_error->name = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->description) )
        {
            $data_error->description = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->name_key) )
        {
            $data_error->name_key = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->phone) )
        {
            $data_error->phone = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        return $isValid;
    }

    public function setCompanyEntity(eCompany $eCompany)
    {
        $this->name = $eCompany->name;
        $this->description = $eCompany->description;
        $this->name_key = $eCompany->name_key;
        $this->phone = $eCompany->phone;
    }

    public function getCompanyEntity()
    {
        $eCompany = new eCompany(FALSE);
        
        $eCompany->name = $this->name;
        $eCompany->description = $this->description;
        $eCompany->name_key = $this->name_key;
        $eCompany->phone = $this->phone;
        
        return $eCompany;
    }
}
