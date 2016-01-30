<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Log_Model extends MY_Model
{
    protected $table = 'user_log';

    function __construct()
    {
        parent::__construct();
    }

    public function deleteByCompany( $id_company )
    {
        $sql = "
            DELETE ".( $this->table )."
            FROM company, profile, users, ".( $this->table )."
            WHERE company.id =  profile.id_company AND
                  profile.id = user.id_profile AND
                  user.id = ".( $this->table ).".id_personal AND
                  company.id = ?
        ";

        if( $this->db->query($sql, array($id_company), FALSE) === FALSE )
        {
            throw new Exception("Error in: TABLE:".$this->table.", FUNCTION:".__FUNCTION__);
        }
    }

    //===========================
    //===========================
    
    function loadAllByCompany( $id_company, $txt_filter='', $limit=null, $offset=null, $isActive_personal=null/*0||1*/, $withOrderBy=FALSE )
    {
        $query = $this->db->query( $this->queryAllByCompany($id_company, $txt_filter, $limit, $offset, $isActive_personal, $withOrderBy) );

        $result_array = $query->result_array();

        return $result_array;
    }

    function countAllByCompany( $id_company, $txt_filter='', $isActive_personal=null/*0||1*/ )
    {
        $query = $this->db->query( $this->queryAllByCompany($id_company, $txt_filter, null, null, $isActive_personal) );

        return $query->num_rows();
    }

    function queryAllByCompany( $id_company, $txt_filter='', $limit=null, $offset=null, $isActive_personal=null/*0||1*/, $withOrderBy=FALSE )
    {
        $sql = "
            SELECT
                user.name AS personal_name,
                user.surname AS personal_surname,
                user.username AS personal_username,
                log.date_time AS log_date_time,
                log.info AS log_info
            FROM
                company, profile, user, ".( $this->table )."
            WHERE
                company.id = profile.id_company AND
                profile.id = personal.id_profile AND
                personal.id = log.id_personal AND
                company.id = ".( $this->db->escape($id_company) )." AND
                ( personal.name LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    personal.surname LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    personal.username LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' )
                ".( is_null($isActive_personal)  ? '' : " AND personal.isActive = ".( $this->db->escape($isActive) )." " )."
            ".( $withOrderBy ? ' ORDER BY log.date_time DESC ' : '' )."
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
}

class eUserLog extends MY_Entity
{
    public $id_user;
    public $info;
    public $date_time;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user = NULL;
            $this->info = '';
            $this->date_time = NULL;
        }
    }
}