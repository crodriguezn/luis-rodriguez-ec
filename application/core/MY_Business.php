<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Business
{
    const DB_DEFAULT = 10;
    const DB_DIGIFORT = 11;
    
    const TRANSACCION_BEGIN = 0;
    const TRANSACCION_COMMIT = 1;
    const TRANSACCION_ROLLBACK = 2;
    
    static public function transaccion( $TRANSACCION_TYPE, $DB_TYPE=self::DB_DEFAULT )
    {
        $MY =& MY_Controller::get_instance();
        
        $db = NULL;
        switch( $DB_TYPE )
        {
            case self::DB_DEFAULT:
                $db =& $MY->db;
                break;
            case self::DB_DIGIFORT:
                $db =& $MY->dbd;
                break;
        }
        
        if( !empty($db) )
        {
            switch( $TRANSACCION_TYPE )
            {
                case self::TRANSACCION_BEGIN:
                    $db->trans_begin();
                    break;
                case self::TRANSACCION_COMMIT:
                    $db->trans_commit();
                    break;
                case self::TRANSACCION_ROLLBACK:
                    $db->trans_rollback();
                    break;
            }
        }
    }
}