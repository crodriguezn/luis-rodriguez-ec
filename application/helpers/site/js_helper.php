<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Site_JS
{
    static public function showMVC($view_js_folder, $params=array())
    {
        // FLASH MESSAGE
        $flash_type = 'none';
        $flash_message = '';

        /* @var $rFlash Response_Flash */
        $rFlash = Helper_Site_Flash::get();
        //Helper_Log::write($rFlash);
        if( !$rFlash->isEmpty() )
        {
            $flash_type = $rFlash->getFlashTypeText();
            $flash_message = $rFlash->message();
        }
        
        $params_res = array_merge($params, array(
            'flash_type' => $flash_type, 'flash_message' => $flash_message
        ));
        
        Helper_Site_View::view("site/js/$view_js_folder/base.js", $params_res);
        Helper_Site_View::view("site/js/$view_js_folder/controller.js");
        Helper_Site_View::view("site/js/$view_js_folder/model.js");
        Helper_Site_View::view("site/js/$view_js_folder/view.js");
    }
}