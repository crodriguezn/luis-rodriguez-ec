<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Session_Activity_Model extends MY_Model
{
    protected $table = 'session_activity';

    function __construct()
    {
        parent::__construct();
    }

    function load( $id_session_activity )
    {
        $row = parent::load($id_session_activity);

        $eSessionActivity = new eSessionActivity();
        $eSessionActivity->parseRow($row);
        
        return $eSessionActivity;
    }
    
    function loadInUse( $id_user )
    {
        $sql = '
            SELECT
                *
            FROM
                "user" AS "u"
                INNER JOIN "user_profile" AS "up" ON "up"."id_user" = "u"."id"
        ';
        
        $row = parent::load(1, 'inUse');

        $eSessionActivity = new eRol();
        $eSessionActivity->parseRow($row);
        
        return $eSessionActivity;
    }
}

class eSessionActivity extends MY_Entity
{
    public $id_user_profile;
    public $session_id;
    public $last_activity;
    public $inUse;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user_profile = NULL;
            $this->session_id = '';
            $this->last_activity = NULL;
            $this->inUse = 0;
        }
    }
}