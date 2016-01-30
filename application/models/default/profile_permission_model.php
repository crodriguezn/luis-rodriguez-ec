<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Permission_Model extends MY_Model
{
    protected $table = 'profile_permission';

    function __construct()
    {
        parent::__construct();
    }

    public function listByProfile( $id_profile )
    {
        $query = $this->db->get_where($this->table, array('id_profile'=>$id_profile));

        $result_array = $query->result_array();

        return $result_array;
    }
    
    //cargar menu x perfil de usuario
    public function listPermissionByProfile( $id_profile )
    {
        $query = $this->db->get_where($this->table, array('id_profile'=>$id_profile));

        $rows = $query->result_array();

        $eProfilePermissions = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eProfilePermission = new eProfilePermission();
                
                $eProfilePermission->parseRow($row);
                
                $eProfilePermissions[] = $eProfilePermission;
            }
        }
        
        return $eProfilePermissions;
    }    

    public function saveProfilePermission( $eProfilePermission)
    {
        try
        {
            $eProfilePermission->id = $this->genId();
            $this->insert( $eProfilePermission->toData() );
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    public function deleteByProfile( $id_profile )
    {
        if( $this->db->delete($this->table, array('id_profile'=>$id_profile)) === FALSE )
        {
            throw new Exception("Error in: TABLE:".$this->table.", FUNCTION:".__FUNCTION__);
        }
    }
}

class eProfilePermission extends MY_Entity
{
    public $id_profile;
    public $id_permission;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_profile = NULL;
            $this->id_permission = NULL;
        }
    }
}
