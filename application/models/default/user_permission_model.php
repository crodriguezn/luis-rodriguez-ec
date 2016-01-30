<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personal_Permission_Model extends MY_Model
{
    protected $table = 'user_permission';

    function __construct()
    {
        parent::__construct();
    }

    public function listByPersonal( $id_personal )
    {
        $query = $this->db->get_where($this->table, array('id_personal'=>$id_personal));

        $result_array = $query->result_array();

        return $result_array;
    }
    
    public function deleteByPersonal( $id_personal )
    {
        if( $this->db->delete($this->table, array('id_personal'=>$id_personal)) === FALSE )
        {
            throw new Exception("Error in: TABLE:".$this->table.", FUNCTION:".__FUNCTION__);
        }
    }
}