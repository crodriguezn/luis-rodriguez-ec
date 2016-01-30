<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_Model extends MY_Model 
{
    protected $table = 'company';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eCompany = new eCompany();
        
        $eCompany->parseRow($row);
        
        return $eCompany;
    }
    
    function save(eCompany &$eCompany)
    {
        try
        {
            if (empty($eCompany->id)) 
            {
                $eCompany->id = $this->genId();
                 
                $this->insert($eCompany->toData());
            }
            else
            {
                $this->update($eCompany->toData(TRUE), $eCompany->id);
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function existName($name, $id_except = FALSE) 
    {
        $sql = "
            SELECT * FROM company
            WHERE name = ?
                  " . ( empty($id_except) ? '' : " AND id<>$id_except " ) . "
        ";
        
        $query = $this->db->query($sql, array($name));
        
        return $query->num_rows() > 0;
    }

    function existNameKey($name_key, $id_except = FALSE)
    {
        $sql = "
            SELECT * FROM company
            WHERE name_key = ?
                  " . ( empty($id_except) ? '' : " AND id<>$id_except " ) . "
        ";
        $query = $this->db->query($sql, array($name_key));
        return $query->num_rows() > 0;
    }

    //===========================
    //===========================

    function loadAll($value = '', $limit = null, $offset = null, $isActive = null/* 0||1 */)
    {
        
        $query = $this->db->query($this->queryAll($value, $limit, $offset, $isActive));
        
        $result_array = $query->result_array();
        
        return $result_array;
    }

    function countAll($value = '', $isActive = null/* 0||1 */) 
    {
        
        $query = $this->db->query($this->queryAll($value, null, null, $isActive));
        
        return $query->num_rows();
        
    }

    function queryAll($value = '', $limit = null, $offset = null, $isActive = null/* 0||1 */)
    {
        $sql = "
            SELECT *
            FROM " . ( $this->table ) . "
            WHERE 1=1
                " . ( is_null($isActive) ? '' : " AND isActive=" . ( $this->db->escape($isActive) ) . " " ) . "
                AND ( name LIKE '%$value%' OR description LIKE '%$value%' )
            " . ( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " ) . "
        ";
        
        return $sql;
    }

    //===========================
    //===========================
    
    function listByUser( $id_user )
    {
        
    }
    
    function listByUserProfile( $id_user )
    {
        
    }
}

class eCompany extends MY_Entity
{
    public $name;
    public $name_key;
    public $description;
    public $phone;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->name_key = '';
            $this->description = '';
            $this->phone = '';
        }
    }
}