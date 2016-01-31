<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class IndexX extends MY_Controller
{
    protected $name_key = 'index';
    
    function __construct()
    {
        parent::__construct(MY_Controller::SYSTEM_SITE);
    }

    public function index()
    {
        $this->process(NULL);
    }

    public function process($action)
    {
        switch( $action )
        {
            case 'send':
                $this->send();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }

    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
    
        echo $resAjax->toJsonEncode();
    }

    private function send()
    {
        $this->load->file('application/modules/site/index/form/email_form.php');
        
        
        $resAjax = new Response_Ajax();
        
        $frm_data = new Form_Site_Email(TRUE);
    
        try
        {
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $Email = $frm_data->getEmail();

            $oBus = Helper_Site_Mail::sendEmail($Email);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }

            $resAjax->isSuccess(TRUE);
            $resAjax->message($oBus->message());
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($ex->getMessage());
            $resAjax->form('email', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }

}
