<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Response_Ajax extends MY_Response
{
    // for datatable
    protected $aaData;
    protected $iTotalRecords;
    protected $iTotalDisplayRecords;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->forms = array();
        
        $this->aaData = array();
        $this->iTotalRecords = 0;
        $this->iTotalDisplayRecords = 0;
    }
    
    public function datatable( $arrData, $total_records )
    {
        $this->aaData = $arrData;
        $this->iTotalRecords = $total_records;
        $this->iTotalDisplayRecords = $total_records;
    }
    
    public function toJsonEncode()
    {
        return json_encode( $this->toArray() );
    }
}

