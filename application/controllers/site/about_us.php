<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_Us extends MY_Controller
{
    function __construct()
    {
        parent::__construct( self::SYSTEM_SITE );
    }

    public function index()
    {
        $resources_path = 'resources/assets/site';
        $arrParams = array ('resources_path' => $resources_path,);
        Helper_Site_View::layout('site/html/pages/about_us/page', $arrParams);

    }
}