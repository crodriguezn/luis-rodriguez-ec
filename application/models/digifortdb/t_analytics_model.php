<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_Analytics_Model extends MY_Model
{
    public $table='T_ANALYTICS';
    
    function __construct()
    {
        parent::__construct(MY_Model::CONN_DBD);
    }
    
    //===========================
    //===========================
    
    function loadCameraGeneral($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/camera_general_sql.php');
        $sql = Camera_General_SQL::sql($dateEnd, $dateBegin);
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    
    /*
    function loadGrupoCamera($dateEnd, $dateBegin, $condicion)
    {
        $this->load->file('application/models/digifortdb/sql/grupo_camera_sql.php');
        if($condicion==Helper_Config::getFTTProcessAccessTerminal())
        {
            $sql = Grupo_Camera_SQL::access_terminal($dateEnd, $dateBegin);
        }
        elseif($condicion==Helper_Config::getFTTProcessBanio())
        {
            $sql = Grupo_Camera_SQL::banios($dateEnd, $dateBegin);
        }
        elseif($condicion==Helper_Config::getFTTProcessPatioComida())
        {
            $sql = Grupo_Camera_SQL::patio_comida($dateEnd, $dateBegin);
        }
        elseif($condicion==Helper_Config::getFTTProcessEscaleraAscensor())
        {
            $sql = Grupo_Camera_SQL::escaleras_ascensores($dateEnd, $dateBegin);
        }
        elseif($condicion==Helper_Config::getFTTProcessTorniquete())
        {
            $sql = Grupo_Camera_SQL::torniquetes($dateEnd, $dateBegin);
        }
        else
        {
            $sql = '';
        }
        
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    */
    function loadAccessTerminal($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/access_terminal_sql.php');
        $sql = Access_Terminal_SQL::sql($dateEnd, $dateBegin);
        
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function loadBanios($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/banios_sql.php');
        $sql = Banios_SQL::sql($dateEnd, $dateBegin);
        
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function loadPatioComida($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/patio_comida_sql.php');
        $sql = Patio_Comida_SQL::sql($dateEnd, $dateBegin);
        
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function loadEscaleraAscensor($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/escalera_ascensor_sql.php');
        $sql = Escalera_Ascensor_SQL::sql($dateEnd, $dateBegin);
        
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function loadTorniquete($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/torniquete_sql.php');
        $sql = Torniquete_SQL::sql($dateEnd, $dateBegin);
        
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function loadResumenCamera($dateEnd, $dateBegin)
    {
        $this->load->file('application/models/digifortdb/sql/resumen_camera_sql.php');
        $sql = Resumen_Camera_SQL::sql($dateEnd, $dateBegin);
        //$query = $this->query($sql);
        $query = $this->dbd->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            //throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        $result_array = $query->result_array();
        return $result_array;
    }

}

class eT_ANALYTICS extends MY_Entity
{

    public $code;
    public $camera;
    public $start_date;
    public $end_date;
    public $zone_name;
    public $event_type;
    public $object_class;
    public $metdata;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->code = '';
            $this->camera = '';
            $this->start_date = '';
            $this->end_date = '';
            $this->zone_name = '';
            $this->event_type = '';
            $this->object_class= '';
            $this->metdata= '';
        }
    }
       
}