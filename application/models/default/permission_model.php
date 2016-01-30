<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_Model extends MY_Model
{
    protected $table = 'permission';

    function __construct()
    {
        parent::__construct();
    }

    function save( ePermission &$ePermission )
    {
        try
        {
            $row = $this->load($ePermission->id);
            
            if( empty($row) )
            {
                $ePermission->id = $this->genId();
                $this->insert( $ePermission->toData() );
            }
            else
            {
                $this->update($ePermission->toData(FALSE), $ePermission->id);
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    public function listByPermission( $id_permission )
    {
        $query = $this->db->get_where($this->table, array('id'=>$id_permission));

        $rows = $query->result_array();

        $ePermissions = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePermission = new ePermission();
                $ePermission->parseRow($row);
                
                $ePermissions[] = $ePermission;
            }
        }
        
        return $ePermissions;
    }
    
    public function listByModule( $id_module )
    {
        $query = $this->db->get_where($this->table, array('id_module'=>$id_module));
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $rows = $query->result_array();

        $ePermissions = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePermission = new ePermission();
                $ePermission->parseRow($row);
                
                $ePermissions[] = $ePermission;
            }
        }
        
        return $ePermissions;
    }

    public function listByProfileAndModule($id_company_branch, $id_module, $id_profile)
    {
        $sql = '
            SELECT
                "permission".*
            FROM
                "profile", "profile_permission", "permission"
            WHERE 1=1
                AND "profile"."id" = "profile_permission"."id_profile"
                AND "profile_permission"."id_permission" = "permission"."id"
                AND "profile_permission"."id_company_branch" = ?
                AND "permission"."id_module" = ?
                AND "profile"."id" = ?
        ';

        $query = $this->db->query($sql, array($id_company_branch, $id_module, $id_profile));
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();
        //Helper_Log::write($rows);

        $ePermissions = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePermission = new ePermission();
                $ePermission->parseRow($row);
                
                $ePermissions[] = $ePermission;
            }
        }

        return $ePermissions;
    }
    
    public function deleteByModule( $id_module )
    {
        $this->delete($id_module, 'id_module');
    }
}

class ePermission extends MY_Entity
{
    public $id_module;
    public $name;
    public $description;
    public $name_key;

    public function __construct( $useDefault = TRUE )
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_module = NULL;
            $this->name = '';
            $this->description = '';
            $this->name_key = '';
        }
    }
}