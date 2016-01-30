<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Config
{
    static public function getCompanyId()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('company');
        
        return $config['id_company'];
    }
    
    static public function getBinaryJava()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('binary');
        
        return $config['java_bin'];
    }
    
    static public function getJasperStarterFirebirdTT()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('jasperstarter');
        
        return $config['firebird']['terminal_terrestre'];
    }
    
    static public function getJasperStarterPostgresTT()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('jasperstarter');
        
        return $config['postgres']['terminal_terrestre'];
    }
    
    static public function getFTTProcessCameraGeneral()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['camara_general'];
    }
    
    static public function getFTTProcessAccessTerminal()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['acceso_terminal'];
    }
    
    static public function getFTTProcessBanio()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['banio'];
    }
    
    static public function getFTTProcessPatioComida()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['patio_comida'];
    }
    
    static public function getFTTProcessEscaleraAscensor()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['escalera_ascensor'];
    }
    
    static public function getFTTProcessTorniquete()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['torniquete'];
    }
    
    static public function getFTTProcessResumenCamera()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('ftt');
        
        return $config['process']['resumen_camera'];
    }
}