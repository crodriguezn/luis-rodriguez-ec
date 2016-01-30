<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_Branch_Model extends MY_Model
{
    protected $table = 'company_branch';

    function __construct()
    {
        parent::__construct();
    }

    function load( $id_company_branch )
    {
        $row = parent::load($id_company_branch);

        $eCompanyBranch = new eCompanyBranch();
        $eCompanyBranch->parseRow($row);
        
        return $eCompanyBranch;
    }
    
    function loadByUserProfile( $id_user_profile )
    {
        $sql = '
        ';
    }
    
    function save( eCompanyBranch &$eCompanyBranch )
    {
        try
        {
            if( empty($eCompanyBranch->id) )
            {
                $eCompanyBranch->id = $this->genId();
                $this->insert( $eCompanyBranch->toData() );
            }
            else
            {
                $this->update( $eCompanyBranch->toData(FALSE), $eCompanyBranch->id );
            }
        }
        catch( Exception $e )
        {
            //Helper_Log::write( $e->getMessage() );
            throw new Exception( $e->getMessage() );
        }
    }
    
    function listAll($id_company, $txt_filter='', $limit=NULL, $offset=NULL, $isActive=NULL)
    {
        $query = $this->db->query( $this->queryAll($id_company, $txt_filter, $limit, $offset, FALSE, $isActive) );

        $rows = $query->result_array();

        $eCompanyBranchs = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eCompanyBranch = new eCompanyBranch();
                $eCompanyBranch->parseRow($row);
                
                $eCompanyBranchs[] = $eCompanyBranch;
            }
        }
            
        return $eCompanyBranchs;
    }
    
    function countAll($id_company, $txt_filter='', $isActive=NULL)
    {
        $query = $this->db->query( $this->queryAll($id_company, $txt_filter, NULL, NULL, TRUE, $isActive) );

        $row = $query->row_array();
        
        return $row['count'];
    }
    
    function queryAll($id_company, $txt_filter='', $limit=NULL, $offset=NULL, $isQueryCount=FALSE, $isActive=NULL)
    {
        $sql = "
            SELECT
                ".( $isQueryCount ? "COUNT(*) AS \"count\"" : "*" )."
            FROM
                ".( $this->table )."
            WHERE 1=1
                AND \"id_company\" = ".( $this->db->escape($id_company) )."
                AND (
                    UPPER(\"name\") LIKE UPPER('%".( $this->db->escape_like_str($txt_filter) )."%') OR
                    UPPER(\"address\") LIKE UPPER('%".( $this->db->escape_like_str($txt_filter) )."%') OR
                    UPPER(\"phone\") LIKE UPPER('%".( $this->db->escape_like_str($txt_filter) )."%') OR
                    UPPER(\"rector_national\") LIKE UPPER('%".( $this->db->escape_like_str($txt_filter) )."%') OR
                    UPPER(\"secretary\") LIKE UPPER('%".( $this->db->escape_like_str($txt_filter) )."%')
                )
            ".( is_null($isActive) ? '' : " AND \"isActive\"=" . ( $this->db->escape($isActive) ) . " " )."
            ".( $isQueryCount ? '' : " ORDER BY name ASC " )."            
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";
        //Helper_Log::write($sql);
        return $sql;
    }

    public function listByCompany( $id_company )
    {
        $db =& $this->getConnection();
        
        //var_dump($value);
        $db->where('id_company', $id_company);
        $db->order_by('name','ASC');
        $query = $db->get( $this->table );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();

        $eCompanyBranches = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eCompanyBranch = new eCompanyBranch();
                
                $eCompanyBranch->parseRow($row);
                
                $eCompanyBranches[] = $eCompanyBranch;
            }
        }
        
        return $eCompanyBranches;
    }
    
    public function listByUserProfile( $id_user, $id_profile )
    {
        $db = $this->getConnection();
        
        $select_company_branch = $this->buildSelectFields("cb_", "cb", $this->table);
        
        $sql = '
            SELECT
                '.$select_company_branch.'
            FROM
                "company_branch" AS "cb"
                INNER JOIN "user_profile_company_branch" AS "upcb" ON "upcb"."id_company_branch" = "cb"."id"
                INNER JOIN "user_profile" AS "up" ON "up"."id" = "upcb"."id_user_profile"
                INNER JOIN "user" AS "u" ON "u"."id" = "up"."id_user"
                INNER JOIN "profile" AS "p" ON "p"."id" = "up"."id_profile"
            WHERE 1=1
                AND "p"."id" = '.( $this->db->escape($id_profile) ).'
                AND "u"."id" = '.( $this->db->escape($id_user) ).'
            ORDER BY
                "cb"."name" ASC
        ';
        
        $query = $db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $rows = $query->result_array();

        $eCompanyBranches = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eCompanyBranch = new eCompanyBranch();
                
                $eCompanyBranch->parseRow($row);
                
                $eCompanyBranches[] = $eCompanyBranch;
            }
        }
        
        return $eCompanyBranches;
    }
    
    // ****************************************************************
    
    function filter(filterCompanyBranch $filter, &$eCompanyBranches, &$count=NULL )
    {
        $eCompanyBranches = array();
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
                $eCompanyBranch = new eCompanyBranch();
                
                $eCompanyBranch->parseRow($row, 'cb_');
                
                $eCompanyBranches[] = $eCompanyBranch;
            }
        }        
    }

    function filterQuery( filterCompanyBranch $filter, $useCounter=FALSE )
    {
        $select_company_branch = $this->buildSelectFields('cb_', 'cb', $this->table);
        
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select_company_branch )."
            FROM \"".( $this->table )."\" AS \"cb\"
            WHERE 1=1
                " . ( is_null($filter->isActive) ? '' : " AND \"cb\".\"isActive\"=" . ( $this->db->escape($filter->isActive) ) . " " ) . "
                AND \"cb\".\"id_company\"=" . ( $this->db->escape($filter->id_company) ) . "
                AND (
                    UPPER(\"cb\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"cb\".\"address\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"cb\".\"phone\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " ORDER BY \"cb\".\"name\" ASC " ) . "
            " . ( is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";

        return $sql;
    }
}

class eCompanyBranch extends MY_Entity
{
    public $id_company;
    public $name;
    public $address;
    public $phone;
    public $isActive;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct( $useDefault );
        
        if( $useDefault )
        {
            $this->id_company = NULL;
            $this->name = '';
            $this->address = '';
            $this->phone = '';
            $this->isActive = 1;
        }
    }
}

class filterCompanyBranch extends MY_Entity_Filter
{
    public $id_company;
    public $isActive;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->id_company = FALSE;
        $this->isActive = NULL;
    }
}