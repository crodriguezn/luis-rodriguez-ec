<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Camera_General_Model extends MY_Model
{
    protected $table = 'camera_general';
    
    function __construct()
    {
        parent::__construct();
    }
    
    function save(eCameraGeneral &$eCameraGeneral)
    {
        try
        {
            if( empty($eCameraGeneral->id) )
            {
                $eCameraGeneral->id = $this->genId();
                $this->insert($eCameraGeneral->toData());
            }
            else
            {
                $this->update($eCameraGeneral->toData(FALSE), $eCameraGeneral->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eCameraGeneral extends MY_Entity
{
    
    public $r_date;
    public $id_group_camera;
    public $group_camera;
    public $name_camera;
    public $camera;
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
            $this->name_camera = NULL;
            $this->camera = NULL;
            $this->event = NULL;
            $this->total= NULL;
        }
    }
       
}