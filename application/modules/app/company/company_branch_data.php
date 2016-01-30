<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_Company_Company_Branch extends MY_Data
{
    public $id_company_branch;
    public $name;
    public $address;
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
            $this->id_company_branch = 0;
            $this->name = '';
            $this->address = '';
            $this->phone = '';
        }
        else
        {
            $this->id_company_branch = '';
            $this->name = '';
            $this->address = '';
            $this->phone = '';
        }
    }
    
    public function readPost()
    {
        $MY = & MY_Controller::get_instance();
        
        $this->id_company_branch   = $MY->input->post('id_company_branch');
        $this->name = $MY->input->post('name');
        $this->address = $MY->input->post('address');
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
        
        if( empty($this->address) )
        {
            $data_error->address = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->phone) )
        {
            $data_error->phone = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        return $isValid;
    }

    public function setCompanyBranchEntity(eCompanyBranch $eCompanyBranch)
    {
        $this->id_company_branch = $eCompanyBranch->id;
        $this->name = $eCompanyBranch->name;
        $this->address = $eCompanyBranch->address;
        $this->phone = $eCompanyBranch->phone;
    }

    public function getCompanyBranchEntity()
    {
        $eCompanyBranch = new eCompanyBranch(FALSE);
        
        //$eCompanyBranch->id = empty($this->id_company_branch) ? NULL : $this->id_company_branch;
        $eCompanyBranch->id = $this->id_company_branch;
        $eCompanyBranch->name = $this->name;
        $eCompanyBranch->address = $this->address;
        $eCompanyBranch->phone = $this->phone;
        
        return $eCompanyBranch;
    }
}
