<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Escalera_Ascensor_Model extends MY_Model
{
    protected $table='escalera_and_ascensor';
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function save(eEscaleraAscensor &$eEscaleraAscensor)
    {
        try
        {
            if( empty($eEscaleraAscensor->id) )
            {
                $eEscaleraAscensor->id = $this->genId();
                $this->insert($eEscaleraAscensor->toData());
            }
            else
            {
                $this->update($eEscaleraAscensor->toData(FALSE), $eEscaleraAscensor->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eEscaleraAscensor extends MY_Entity
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