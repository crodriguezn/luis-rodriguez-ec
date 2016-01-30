<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Model extends MY_Model {

    protected $table = 'profile';

    function __construct()
    {
        parent::__construct();
    }
    
    public function saveProfile( $eProfile)
    {
        try
        {
            if( !empty($eProfile->id) )
            {
                $this->update( $eProfile->toData(false) , $eProfile->id);
            }
            else
            {
                $eProfile->id = $this->genId();
                $this->insert( $eProfile->toData() );
            }
            
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $eProfile = new eProfile();
        $eProfile->parseRow($row);

        return $eProfile;
    }

    function loadByRolUser( $id_rol, $id_user, &$eProfile )
    {
        $sql = '
            SELECT
                "p".*
            FROM
                "profile" AS "p"
                INNER JOIN "rol" AS "r" ON "r"."id" = "p"."id_rol"
                INNER JOIN "user_profile" AS "up" ON "up"."id_profile" = "p"."id"
                INNER JOIN "user" AS "u" ON "u"."id" = "up"."id_user"
            WHERE 1=1
                AND "r"."id" = '.( $this->db->escape($id_rol) ).'
                AND "u"."id" = '.( $this->db->escape($id_user) ).'
        ';
        
        $query = $this->db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $query->row_array();
        
        $eProfile = new eProfile();
        $eProfile->parseRow($row);
    }
    
    function existProfile($name, $id_except = FALSE, $id_company = FALSE)
    {
        if( $id_company === FALSE)
        {
            $query = '';
            if ($id_except !== FALSE)
            {
                $this->db->where('id <>', $id_except);
            }

            $this->db->where('name', $name);

            $query = $this->db->get($this->table);

            return $query->num_rows() > 0;
        }

        $sql = "
            SELECT * FROM company, profile
            WHERE company.id = profile.id_company AND
                  company.id = ? AND profile.name = ?
                  " . ( $id_except === FALSE ? '' : " AND profile.id<>$id_except " ) . "
        ";

        $query = $this->db->query($sql, array($id_company, $name));

        return $query->num_rows() > 0;
    }

    function listByUser($id_user)
    {
        $sql = '
            SELECT
                "p".*
            FROM
                "profile" AS "p"
                INNER JOIN "user_profile" AS "up" ON "up"."id_profile" = "p"."id"
            WHERE 1=1
                AND "up"."id_user" = '.( $this->db->escape($id_user) ).'
        ';
        
        $query = $this->db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $eProfiles = array();
        
        $rows = $query->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eProfile = new eProfile();
                $eProfile->parseRow($row);
                
                $eProfiles[] = $eProfile;
            }
        }
        
        return $eProfiles;
    }
    
    // ****************************************************************
    
    function filter( filterProfile $filter, &$eProfiles, &$eRols=NULL, &$count=NULL )
    {
        $eProfiles = array();
        $eRols = array();
        $count = 0;
        
        $queryR = $this->db->query($this->filterQuery($filter));
        if( $queryR === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $queryC = $this->db->query($this->filterQuery($filter,TRUE));
        if( $queryC === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $queryC->row_array();
        $count = $row['count'];
        
        $rows = $queryR->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eProfile = new eProfile();
                $eRol = new eRol();
                
                $eProfile->parseRow($row, 'p_');
                $eRol->parseRow($row, 'r_');
                
                $eProfiles[] = $eProfile;
                $eRols[] = $eRol;
            }
        }        
    }

    function filterQuery( filterProfile $filter, $useCounter=FALSE )
    {
        $select_profile = $this->buildSelectFields('p_', 'p', 'profile');
        $select_rol = $this->buildSelectFields('r_', 'r', 'rol');
        
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select_profile.','.$select_rol )."
            FROM \"".( $this->table )."\" AS \"p\"
                INNER JOIN \"rol\" AS \"r\" ON \"r\".\"id\" = \"p\".\"id_rol\"
            WHERE 1=1
                " . ( $filter->withSuperAdmin ? '' : " AND \"p\".\"isSuperAdmin\"<>" . ( $this->db->escape(1) ) . " " ) . "
                " . ( $filter->withAdmin ? '' : " AND \"p\".\"isAdmin\"<>" . ( $this->db->escape(1) ) . " " ) . "
                " . ( is_null($filter->isEditable) ? '' : " AND \"p\".\"isEditable\"=" . ( $this->db->escape($filter->isEditable) ) . " " ) . "
                " . ( is_null($filter->isActive) ? '' : " AND \"p\".\"isActive\"=" . ( $this->db->escape($filter->isActive) ) . " " ) . "
                AND \"r\".\"id_company\"=" . ( $this->db->escape($filter->id_company) ) . "
                AND (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"p\".\"description\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " ORDER BY \"p\".\"name\" ASC " ) . "
            " . ( is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";

        return $sql;
    }
}

class eProfile extends MY_Entity
{
    public $id_rol;
    public $name;
    public $description;
    public $isAdmin;
    public $isSuperAdmin;
    public $isActive;
    public $isEditable;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_rol = NULL;
            $this->name = '';
            $this->description = NULL;        
            $this->isSuperAdmin = 0;
            $this->isAdmin = 0;
            $this->isEditable = 1;
            $this->isActive = 1;
        }
    }
}

class filterProfile extends MY_Entity_Filter
{
    public $id_company;
    public $withSuperAdmin;
    public $withAdmin;
    public $isEditable;
    public $isActive;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->id_company = FALSE;
        $this->withSuperAdmin = FALSE;
        $this->withAdmin = FALSE;
        $this->isEditable = NULL;
        $this->isActive = NULL;
    }
}