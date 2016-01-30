<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resumen_Camera_Model extends MY_Model
{
    protected $table = 'resumen_camera';
    
    function __construct()
    {
        parent::__construct();
    }
    
    function save(eResumenCamera &$eResumenCamera)
    {
        try
        {
            if( empty($eResumenCamera->id) )
            {
                $eResumenCamera->id = $this->genId();
                $this->insert($eResumenCamera->toData());
            }
            else
            {
                $this->update($eResumenCamera->toData(FALSE), $eResumenCamera->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eResumenCamera extends MY_Entity
{

    public $r_date;
    public $id_group_camera;
    public $group_camera;
    public $event;
    public $total;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->r_date = NULL;
            $this->id_group_camera = NULL;
            $this->group_camera = NULL;
            $this->event = NULL;
            $this->total= NULL;
        }
    }
       
}