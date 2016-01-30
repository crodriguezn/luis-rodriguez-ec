<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends MY_Model
{
    protected $table = 'user';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by='id', $except_value='', $except_by='id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eUser = new eUser();
        $eUser->parseRow($row);
        
        return  $eUser;
    }
    
    function loadUserByPersonRolProfile($id_person, $id_rol, $id_profile)
    {
        $sql = '
            SELECT
                "u"."id" AS "u_id",
                "u"."id_person" AS "u_id_person",
                "u"."id_rol" AS "u_id_rol",
                "u"."username" AS "u_username",
                "u"."password" AS "u_password",
                "u"."isActive" AS "u_isActive"
            FROM
                "'.( $this->table ).'" AS "u"
                INNER JOIN "person" AS "p" ON "p"."id" = "u"."id_person"
                INNER JOIN "rol" AS "r" ON "r"."id" = "u"."id_rol"
                INNER JOIN "profile" AS "pr" ON "pr"."id" = "u"."id_profile"
            WHERE 1=1
                AND "p"."id" = '.( $this->db->escape($id_person) ).'
                AND "r"."id" = '.( $this->db->escape($id_rol) ).'
                AND "pr"."id" = '.( $this->db->escape($id_profile) ).'
        ';
        
        //Helper_Log::write( $sql );
        $query = $this->db->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $query->row_array();
        
        $eUser = new eUser();
        $eUser->parseRow($row,'u_');
        
        return $eUser;
    }
    
    
    function login($id_company, $username, $password)
    {
        $sql = '
            SELECT
                "u".*
            FROM
                "user" AS "u"
                INNER JOIN "person" AS "p" ON "p"."id" = "u"."id_person"
                INNER JOIN "company" AS "c" ON "c"."id" = "u"."id_company"
            WHERE 1=1
                AND "c"."id" = '.( $this->db->escape($id_company) ).'
                AND "u"."username" = '.( $this->db->escape($username) ).'
                AND "u"."password" = '.( $this->db->escape(md5($password)) ).'
        ';

        //Helper_Log::write($sql, Helper_Log::LOG_DB);
        
        $query = $this->db->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $row = $query->row_array();
        
        $eUser = new eUser();
       
        $eUser->parseRow($row);
        
        return $eUser;
    }
    
    function loginAdmin( $username, $password, &$eUser, &$eProfile, &$eRol )
    {
        $select_user = $this->buildSelectFields('u_', 'u', 'user' );
        $select_profile = $this->buildSelectFields('p_', 'p', 'profile' );
        $select_rol = $this->buildSelectFields('r_', 'r', 'rol' );
        
        $sql = '
            SELECT
                '.$select_user.','.$select_profile.','.$select_rol.'
            FROM
                "user" AS "u",
                "profile" AS "p",
                "rol" AS "r"
            WHERE 1=1
                AND "u"."id_profile" = "p"."id"
                AND "u"."id_rol" = "r"."id"
                AND "p"."isAdmin" = '.( $this->db->escape(1) ).'
                AND "u"."username" = '.( $this->db->escape($username) ).'
                AND "u"."password" = '.( $this->db->escape(md5($password)) ).'
        ';
        
        $query = $this->db->query( $sql );

        $row = $query->row_array();
        
        $eUser = new eUser();
        $eProfile = new eProfile();
        $eRol = new eRol();
        
        if( !empty($row) )
        {
            $eUser->parseRow($row, 'u_');
            $eProfile->parseRow($row, 'p_');
            $eRol->parseRow($row, 'r_');
        }
    }
    
    function checkPassword( $id_user, $password )
    {
        $query = $this->db->get_where($this->table, array('id'=>$id_user, 'password'=>md5($password)));
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $row = $query->row_array();
        
        return !empty($row);
    }
    
    function updatePassword( $id_user, $password )
    {
        // throw new Exception
        parent::update(array('password'=>md5($password)), $id_user);
    }
    
    function loadByUsername($username)
    {
        $row = parent::load($username, 'username');
        
        $eUser = new eUser();
        $eUser->parseRow($row);
        
        return $eUser;
    }

    //===========================
    //===========================

    function loadAllByProfile( $id_profile, $limit=null, $offset=null, $isActive=null/*0||1*/ )
    {
        $query = $this->db->query( $this->queryAllByProfile($id_profile, $limit, $offset, $isActive) );

        $result_array = $query->result_array();

        return $result_array;
    }

    function countAllByProfile( $id_profile, $isActive=null/*0||1*/ )
    {
        $query = $this->db->query( $this->queryAllByProfile($id_profile, null, null, $isActive) );

        return $query->num_rows();
    }

    function queryAllByProfile( $id_profile, $limit=null, $offset=null, $isActive=null/*0||1*/ )
    {
        $sql = "
            SELECT *
            FROM ".( $this->table )."
            WHERE 1=1
                ".( is_null($isActive)  ? '' : " AND isActive=".( $this->db->escape($isActive) )." " )."
                AND id_profile=".( $this->db->escape($id_profile) )."
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }

    //===========================
    //===========================

    function loadAllByCompany( $id_company, $txt_filter='', $limit=null, $offset=null, $isActive_personal=null/*0||1*/, $isAdmin_profile=null/*0||1*/, $isActive_profile=null/*0||1*/ )
    {
        $sql = $this->sqlAllByCompany($id_company, $txt_filter, $limit, $offset, $isActive_personal, $isAdmin_profile, $isActive_profile, TRUE);
        
        $query = $this->db->query( $sql );

        $result_array = $query->result_array();

        return $result_array;
    }

    function countAllByCompany( $id_company, $txt_filter='', $isActive_personal=null/*0||1*/, $isAdmin_profile=null/*0||1*/, $isActive_profile=null/*0||1*/ )
    {
        $sql = $this->sqlAllByCompany($id_company, $txt_filter, null, null, $isActive_personal, $isAdmin_profile, $isActive_profile);
        
        $query = $this->db->query( $sql );

        return $query->num_rows();
    }

    function sqlAllByCompany( $id_company, $txt_filter='', $limit=null, $offset=null, $isActive_personal=null/*0||1*/, $isAdmin_profile=null/*0||1*/, $isActive_profile=null/*0||1*/, $withOrderBy=FALSE )
    {
        $sql = "
            SELECT
                personal.id AS personal_id, person.name AS person_name, person.surname AS person_surname, personal.username AS personal_username, personal.isActive AS personal_isActive,
                profile.id AS profile_id, profile.name AS profile_name
            FROM
                company, profile, ".( $this->table ).", person
            WHERE 1=1
                AND company.id = profile.id_company
                AND profile.id = personal.id_profile
                AND person.id = personal.id_person

                AND id_company=".( $this->db->escape($id_company) )."
                ".( is_null($isActive_personal) ? '' : " AND personal.isActive=".( $this->db->escape($isActive_personal) )." " )."
                ".( is_null($isAdmin_profile)   ? '' : " AND profile.isAdmin=".( $this->db->escape($isAdmin_profile) )." " )."
                ".( is_null($isActive_profile)  ? '' : " AND profile.isActive=".( $this->db->escape($isActive_profile) )." " )."
                AND (
                    person.name       LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    person.surname    LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    personal.username LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    profile.name      LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( $withOrderBy ? " ORDER BY person.name ASC, person.surname ASC " : "" )."
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }

    //===========================
    //===========================
    
    
    function save(eUser &$eUser)
    {
        try
        {
            if (empty($eUser->id))
            {
                $eUser->id = $this->genId();
                $this->insert($eUser->toData());
            }
            else
            {
                $this->update($eUser->toData(FALSE), $eUser->id);
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function loadUserPersonRol($id_persona, $id_rol, $id, $isActive=NULL) {
       $sql = '
            SELECT *FROM "user"
            where "id_person" = '.( $this->db->escape($id_persona) ).'
            and "id_rol" = '.( $this->db->escape($id_rol) ).'
            '.( is_null($isActive) ? '' : ' AND  "isActive" = '.( $this->db->escape($id) )." " ).'
            '.( is_null($id) ? '' : ' AND  "id" <> '.( $this->db->escape($id) )." " ).'
        ';
       //print_r($sql);

        $query = $this->db->query( $sql );

        $row = $query->row_array();
        
        $eUser = new eUser();
        
        if( !empty($row) )
        {
            $eUser->parseRow($row);
        }
        
        return $eUser;
    } 
    
    function loadUsuariosExistentes($value, $by = 'id', $except_value = '', $except_by = 'id') {
        $row = $this->load_($value, $by, $except_value, $except_by);

        $eUser = new eUser();
        $eUser->parseRow($row);

        return $eUser;
    } 
    
    function load_($value, $by='id', $except_value='', $except_by='id')
    {
        $this->db->where($by, $value);
        
        if( !empty($except_value) )
        {
            if(empty($except_by))
            {
                $this->db->where("\"isActive\" = 1");
            }
            else
            {
                $this->db->where("$except_by <>", $except_value);
            }
        }
        
        $query = $this->db->get( $this->table );
        
        return $query->row_array();
    }
    
    function listProfilesByUser( $id_user, &$eProfiles )
    {
        $select_profile = $this->buildSelectFields('p_', 'p', 'profile' );
        
        $sql = '
            SELECT
                '.( $select_profile ).'
            FROM
                "'.( $this->table ).'" AS "u"
                INNER JOIN "user_profile" AS "up" ON "up"."id_user" = "u"."id"
                INNER JOIN "profile" AS "p" ON "p"."id" = "up"."id_profile"
            WHERE 1=1
                AND "u"."id" = '.( $this->db->escape($id_user) ).'
        ';
        
        $query = $this->db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();
        
        $eProfiles = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eProfile = new eProfile();
                $eProfile->parseRow($row, 'p_');
                
                $eProfiles[] = $eProfile;
            }
        }
    }
}

class eUser extends MY_Entity
{
    public $id_person;
    public $id_company;
    public $username;
    public $password;
    public $isActive;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_person = NULL;
            $this->id_profile = NULL;
            $this->id_rol = NULL;
            $this->username = '';
            $this->password = '';
            $this->isActive = 1;
        }
    }
}