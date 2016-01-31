<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Site_Mail
{
    
    static public function sendEmail( $data )
    {   
        $MY = & MY_Controller::get_instance();
        
        $config_email = Helper_Config::getEmail();
        
        $MY->load->library('email',$config_email);
        
        $oBus = new Response_Business();
        
        $smtp_user = $config_email['smtp_user'];
        
        $messege    = "De: ".$data['name']." <br>";
        $messege   .= "Email:".$data['email']." <br>";
        $messege   .= "Detalle:".$data['message']." <br>";
        try 
        {
            $MY->email->from($smtp_user, $data['name']);
            $MY->email->to('taylorluis93@gmail.com');
            $MY->email->subject($data['subject']);
            $MY->email->message($messege);
            if( !$MY->email->send() )
            {
                throw new Exception($MY->email->print_debugger());
            }
            
            $oBus->isSuccess( TRUE );
            $oBus->message( 'Email enviado!' );
        } 
        catch (Exception $ex) 
        {
            $oBus->isSuccess( FALSE );
            $oBus->message( $ex->getMessage() );
        }
        
        return $oBus;
    }
}