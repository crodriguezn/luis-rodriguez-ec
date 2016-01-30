<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Torniquete_Model extends MY_Model
{
    protected $table='torniquete';
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function save(eTorniquete &$eTorniquete)
    {
        try
        {
            if( empty($eTorniquete->id) )
            {
                $eTorniquete->id = $this->genId();
                $this->insert($eTorniquete->toData());
            }
            else
            {
                $this->update($eTorniquete->toData(FALSE), $eTorniquete->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eTorniquete extends MY_Entity
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