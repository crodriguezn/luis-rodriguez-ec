<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banios_Model extends MY_Model
{
    protected $table='banio';
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function save(eBanio &$eBanio)
    {
        try
        {
            if( empty($eBanio->id) )
            {
                $eBanio->id = $this->genId();
                $this->insert($eBanio->toData());
            }
            else
            {
                $this->update($eBanio->toData(FALSE), $eBanio->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eBanio extends MY_Entity
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