<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Profile_Company_Branch_Model extends MY_Model
{
    protected $table = 'user_profile_company_branch';

    function __construct()
    {
        parent::__construct();
    }

    function load( $value, $by='id', $except_value='', $except_by='id' )
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $eUserCompanyBranch = new eUserCompanyBranch();
        $eUserCompanyBranch->parseRow($row);
        
        return $eUserCompanyBranch;
    }
    
    function save(eUserProfileCompanyBranch &$eUserProfileCompanyBranch )
    {
        try
        {
            if( empty($eUserProfileCompanyBranch->id) )
            {
                $eUserProfileCompanyBranch->id = $this->genId();
                $this->insert( $eUserProfileCompanyBranch->toData() );
            }
            else
            {
                $this->update( $eUserProfileCompanyBranch->toData(FALSE), $eUserProfileCompanyBranch->id );
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    public function listByUser( $id_user )
    {
        $query = $this->db->get_where($this->table, array('id_user'=>$id_user));

        $rows = $query->result_array();

        $eUserCompanyBranches = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eUserCompanyBranch = new eUserCompanyBranch();
                
                $eUserCompanyBranch->parseRow($row);
                
                $eUserCompanyBranches[] = $eUserCompanyBranch;
            }
        }
        
        return $eUserCompanyBranches;
    }
    
    public function loadByUserProfileCompanyBranch($id_user_profile, $id_company_branch)
    {
        $sql = '
            SELECT
                *
            FROM
                "'.( $this->table ).'"
            WHERE 1=1
                AND "id_user_profile" = '.( $this->db->escape($id_user_profile) ).'
                AND "id_company_branch" = '.( $this->db->escape($id_company_branch) ).'
        ';
        
        $query = $this->db->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $query->row_array();
        
        $eUserProfileCompanyBranch = new eUserProfileCompanyBranch();
        $eUserProfileCompanyBranch->parseRow($row);
        
        return $eUserProfileCompanyBranch;
    }
}

class eUserProfileCompanyBranch extends MY_Entity
{
    public $id_user_profile;
    public $id_company_branch;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user_profile = NULL;
            $this->id_company_branch = NULL;
        }
    }
}