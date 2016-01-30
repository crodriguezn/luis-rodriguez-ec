<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_Module_Model extends MY_Model
{
    protected $table = 'rol_module';

    function __construct()
    {
        parent::__construct();
    }

    function save(eRolModule &$eRolModule )
    {
        try
        {
            if( $eRolModule->isEmpty() )
            {
                $eRolModule->id = $this->genId();
                
                $this->insert( $eRolModule->toData() );
            }
            else
            {
                $this->update($eRolModule->toData(FALSE), $eRolModule->id);
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    function load( $id_rol_module )
    {
        $row = parent::load($id_rol_module);

        $eRolModule = new eRolModule();
        $eRolModule->parseRow($row);
        
        return $eRolModule;
    }
    
    function loadByRolModule( $id_rol, $id_module )
    {
        $db =& $this->getConnection();
        
        $db->where('id_rol', $id_rol);
        $db->where('id_module', $id_module);
        
        $query = $db->get( $this->table );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $query->row_array();

        $eRolModule = new eRolModule();
        $eRolModule->parseRow($row);
        
        return $eRolModule;
    }
    
    function listByModule( $id_module )
    {
        $db =& $this->getConnection();
        
        $db->where('id_module', $id_module);
        
        $query = $db->get( $this->table );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();

        $eRolModules = array();
        if( !empty($rows) )
        {
            foreach ( $rows as $row )
            {
                $eRolModule = new eRolModule();
                $eRolModule->parseRow($row);
                
                $eRolModules[] = $eRolModule;
            }
        }
        
        return $eRolModules;
    }
}

class eRolModule extends MY_Entity
{
    public $id_rol;
    public $id_module;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_rol = NULL;
            $this->id_module = NULL;
        }
    }
}