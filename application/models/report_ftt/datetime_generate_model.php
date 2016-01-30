<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datetime_Generate_Model extends MY_Model
{
    protected $table = 'datetime_generate';
    
    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eDatetimeGenerate = new eDatetimeGenerate();
        $eDatetimeGenerate->parseRow($row);
        
        return $eDatetimeGenerate;
    }
    
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id')
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eDatetimeGenerate = new eDatetimeGenerate();
        $eDatetimeGenerate->parseRow($row);
        
        return $eDatetimeGenerate;
        
    }
    
    
    function save(eDatetimeGenerate &$eDatetimeGenerate)
    {
        try
        {
            if( empty($eDatetimeGenerate->id) )
            {
                $eDatetimeGenerate->id = $this->genId();
                $this->insert($eDatetimeGenerate->toData());
            }
            else
            {
                $this->update($eDatetimeGenerate->toData(FALSE), $eDatetimeGenerate->id);
            }
        }
        catch( Exception $e )
        {
            Helper_Process_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

}

class eDatetimeGenerate extends MY_Entity
{

    public $update_datetime;
    public $process_name;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->update_datetime = NULL;
            $this->process_name = NULL;
        }
    }
       
}