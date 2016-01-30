<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _Default extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->redirect('site/home');
    }
    
    /*public function index()
    {
        echo "WELCOME TO PUBLIC";
    }*/
}