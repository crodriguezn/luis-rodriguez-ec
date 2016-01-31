<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{
    protected $name_key = 'index';
    
    function __construct()
    {
        parent::__construct( self::SYSTEM_SITE );
    }

    public function index()
    {
        $resources_path = 'resources/assets/site';
        $arrParams = array ('resources_path' => $resources_path,);
        Helper_Site_View::layout('site/html/pages/index/page', $arrParams);

    }
    
    public function mvcjs() 
    {
        $this->load->file('application/modules/site/index/form/email_form.php');
        $frm_data = new Form_Site_Email();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'email_form_default' => $frm_data->toArray()
        );
        
        Helper_Site_JS::showMVC('index', $params);
    }
    
}