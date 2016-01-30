<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patio_Comida_Model extends MY_Model
{
    protected $table='patios_comida';
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function save(ePatioComida &$ePatioComida)
    {
        try
        {
            if( empty($ePatioComida->id) )
            {
                $ePatioComida->id = $this->genId();
                $this->insert($ePatioComida->toData());
            }
            else
            {
                $this->update($ePatioComida->toData(FALSE), $ePatioComida->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class ePatioComida extends MY_Entity
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