<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_Model extends MY_Model
{
    protected $table = 'rol';

    function __construct()
    {
        parent::__construct();
    }

    function load( $id_rol )
    {
        $row = parent::load($id_rol);

        $eRol = new eRol();
        $eRol->parseRow($row);
        
        return $eRol;
    }
    
    function loadByNameKey( $name_key )
    {
        $row = parent::load($name_key, 'name_key');

        $eRol = new eRol();
        $eRol->parseRow($row);
        
        return $eRol;
    }
    
    function listByModule( $id_module )
    {
        $eRols = array();
        
        $sql = '
            SELECT
                "r".*
            FROM
                "'.( $this->table ).'" AS "r"
                INNER JOIN "rol_module" AS "rm" ON "rm"."id_rol" = "r"."id"
                INNER JOIN "module" AS "m" ON "m"."id" = "rm"."id_module"
            WHERE 1=1
                AND "m"."id" = '.( $this->db->escape($id_module) ).'
            ORDER BY "r"."name" ASC
        ';
        
        $query = $this->db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eRol = new eRol();
                $eRol->parseRow($row);

                $eRols[] = $eRol;
            }
        }
        
        return $eRols;
    }
    
    // ****************************************************************
    
    //function loadAllByCompany($id_company, $txt_filter='', $limit=NULL, $offset=NULL, $withSuperAdmin=FALSE, $withAdmin=FALSE, $isEditable=NULL/* 0||1 */, $isActive=NULL/* 0||1 */)
    function filter( filterRol $filter, &$eRols, &$count )
    {
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
                $eRol = new eRol();
                $eRol->parseRow($row);

                $eRols[] = $eRol;
            }
        }
    }

    function filterQuery( filterRol $filter, $useCounter=FALSE )
    {
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : "*" )."
            FROM \"".( $this->table )."\"
            WHERE 1=1
                AND (
                    UPPER(\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"name_key\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " ORDER BY \"name\" ASC " ) . "
            " . ( is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";

        return $sql;
    }
}

class eRol extends MY_Entity
{
    public $name;
    public $name_key;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->name_key = '';
        }
    }
}

class filterRol extends MY_Entity_Filter
{
    public function __construct()
    {
        parent::__construct();
    }
}