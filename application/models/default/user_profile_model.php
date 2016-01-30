<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Profile_Model extends MY_Model
{
    protected $table = 'user_profile';

    function __construct()
    {
        parent::__construct();
    }
    
    function save(eUserProfile &$eUserProfile)
    {
        try
        {
            if (empty($eUserProfile->id))
            {
                $eUserProfile->id = $this->genId();
                $this->insert($eUserProfile->toData());
            }
            else
            {
                $this->update($eUserProfile->toData(FALSE), $eUserProfile->id);
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    public function loadByUserProfile($id_user, $id_profile)
    {
        $sql = '
            SELECT
                *
            FROM
                "'.( $this->table ).'"
            WHERE 1=1
                AND "id_user" = '.$this->db->escape($id_user).'
                AND "id_profile" = '.( $this->db->escape($id_profile) ).'
        ';
        
        $query = $this->db->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $query->row_array();
        
        $eUserProfile = new eUserProfile();
        $eUserProfile->parseRow($row);
        
        return $eUserProfile;
    }
}

class eUserProfile extends MY_Entity
{
    public $id_user;
    public $id_profile;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user = NULL;
            $this->id_profile = NULL;
        }
    }
}