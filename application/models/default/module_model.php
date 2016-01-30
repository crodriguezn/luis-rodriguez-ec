<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_Model extends MY_Model
{
    protected $table = 'module';
    
    const ORDER_BY_NAME  = 0;
    const ORDER_BY_ORDER = 1;

    function __construct()
    {
        parent::__construct();
    }

    function load( $id_module )
    {
        $row = parent::load($id_module);
        //Helper_Log::write( print_r($row,TRUE) );
        $eModule = new eModule();
        $eModule->parseRow($row);
        
        return $eModule;
    }
    
    function save( eModule &$eModule )
    {
        try
        {
            if( $eModule->isEmpty() )
            {
                $eModule->id = $this->genId();
                $this->insert( $eModule->toData() );
            }
            else
            {
                $this->update( $eModule->toData(FALSE), $eModule->id );
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    function saveOrder( eModule $eModule )
    {
        try
        {
            $this->update(array('num_order'=>$eModule->num_order), $eModule->id );
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
            
    function listAll( $withIsAdmin=FALSE )
    {
        $where = array();
        
        if( !$withIsAdmin )
        {
            $where['isAdmin'] = 0;
        }
        
        $this->db->order_by("num_order","asc");
        $query = $this->db->get_where($this->table, $where);

        $rows = $query->result_array();

        $eModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eModule = new eModule();
                $eModule->parseRow($row);
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }

    function listModules( $id_parent = NULL, $ORDER_BY = self::ORDER_BY_ORDER, $withIsAdmin=FALSE, $isActive=NULL )
    {
        $where = array('id_parent'=>$id_parent);
        
        if( !$withIsAdmin )
        {
            $where['isAdmin'] = 0;            
        }
        
        if( !is_null($isActive ) )
        {           
            $where['isActive'] = $isActive;
        }
        
        $this->db->order_by( $ORDER_BY == self::ORDER_BY_NAME ? 'name' : "num_order","asc");
        $query = $this->db->get_where($this->table, $where);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();

        $eModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eModule = new eModule();
                $eModule->parseRow($row);
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }

    // load parents by company
    function listParentsByCompany( $id_company )
    {
        $sql = "
            SELECT module.*
            FROM company_module, module
            WHERE company_module.id_module = module.id AND
                  module.id_parent IS NULL AND
                  company_module.id_company = ?
        ";

        $query = $this->db->query($sql, array($id_company));

        $result_array = $query->result_array();

        return $result_array;
    }

    // load child by parent and company
    function listModulesByParentAndCompany( $id_parent, $id_company )
    {
        $sql = "
            SELECT module.*
            FROM company_module, module
            WHERE company_module.id_module = module.id AND
                  module.id_parent = ? AND
                  company_module.id_company = ?
        ";

        $query = $this->db->query($sql, array($id_parent, $id_company));

        $result_array = $query->result_array();

        return $result_array;
    }

    function existName( $name, $id_except=0 )
    {
        $res = $this->load($name, 'name', $id_except);
        
        return !empty($res);
    }

    function existNameKey( $name_key, $id_except=0 )
    {
        $res = $this->load($name_key, 'name_key', $id_except);
        
        return !empty($res);
    }
    
    //===========================
    //===========================

    function loadAllParent($txt_filter='', $limit=NULL, $offset=NULL )
    {
        $sql  = $this->sqlAllParent($txt_filter, $limit, $offset);
        $query = $this->db->query( $sql );

        $rows = $query->result_array();

        $eModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eModule = new eModule();
                $eModule->parseRow($row);
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }

    function countAllParent($txt_filter='')
    {
        $sql = $this->sqlAllParent($txt_filter, NULL, NULL, TRUE);
        $query = $this->db->query( $sql );

        $row = $query->row_array();
        
        return $row['count'];
    }

    function sqlAllParent( $txt_filter='', $limit=NULL, $offset=NULL, $isQueryCount=FALSE )
    {
        $sql = "
            SELECT
                ".( $isQueryCount ? "COUNT(*) AS \"count\"" : "*" )."
            FROM ".( $this->table )."
            WHERE 1=1
                AND id_parent IS NULL
                AND (
                    \"name\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    \"description\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    \"name_key\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( $isQueryCount ? '' : " ORDER BY name ASC " )."
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
    
    //===========================
    //===========================

    function loadAllChild($txt_filter='', $limit=NULL, $offset=NULL)
    {
        $sql  = $this->sqlAllChild($txt_filter, $limit, $offset);
        $query = $this->db->query( $sql );

        $rows = $query->result_array();

        $eModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eModule = new eModule();
                $eModule->parseRow($row);
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }

    function countAllChild($txt_filter='')
    {
        $sql = $this->sqlAllChild($txt_filter, NULL, NULL, TRUE);
                
        $query = $this->db->query( $sql );

        $row = $query->row_array();
        
        return $row['count'];
    }

    function sqlAllChild($txt_filter='', $limit=NULL, $offset=NULL, $isQueryCount=FALSE)
    {
        $sql = "
            SELECT
                ".( $isQueryCount ? "COUNT(*) AS \"count\"" : "*" )."
            FROM ".( $this->table )."
            WHERE 1=1
                AND id_parent IS NOT NULL
                AND (
                    \"name\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    \"description\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    \"name_key\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( $isQueryCount ? '' : " ORDER BY name ASC " )."
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
}

class eModule extends MY_Entity
{
    public $id_parent;
    public $name;
    public $description;
    public $name_key;
    public $num_order;
    public $isAdmin;
    public $isActive;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_parent = NULL;
            $this->name = '';
            $this->description = '';
            $this->name_key = '';
            $this->num_order = 0;
            $this->isAdmin = 0;
            $this->isActive = 1;
        }
    }
}