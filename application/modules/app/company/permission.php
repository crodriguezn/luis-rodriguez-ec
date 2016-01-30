<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_Permission extends MY_Permission
{
    public $create = FALSE;
    public $edit = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}