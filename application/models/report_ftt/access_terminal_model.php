<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access_Terminal_Model extends MY_Model
{
    protected $table='access_terminal';
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function save(eAccessTerminal &$AccessTerminal)
    {
        try
        {
            if( empty($AccessTerminal->id) )
            {
                $AccessTerminal->id = $this->genId();
                $this->insert($AccessTerminal->toData());
            }
            else
            {
                $this->update($AccessTerminal->toData(FALSE), $AccessTerminal->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eAccessTerminal extends MY_Entity
{

    public $r_date;
    public $r_hour;
    public $id_group_camera;
    public $group_camera;
    public $event;
    public $camera;
    public $total;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->r_date = NULL;
            $this->r_hour = NULL;
            $this->id_group_camera = NULL;
            $this->group_camera = NULL;
            $this->camera = NULL;
            $this->event = NULL;
            $this->total= NULL;
        }
    }
       
}