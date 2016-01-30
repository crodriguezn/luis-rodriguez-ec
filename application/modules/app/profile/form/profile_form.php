<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Profile extends MY_Form
{
    public $id_profile;
    public $id_rol;
    public $name;
    public $description;
    public $isActive;
    public $id_permissions;
    
    public $_is_profile_editable;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_profile = 0;
        $this->id_rol = 0;
        $this->name = '';
        $this->description = '';
        $this->isActive = 0;
        $this->id_permissions = array();
        
        $this->_is_profile_editable = 1;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_profile = $MY->input->post('id_profile');
        $this->id_rol = $MY->input->post('id_rol');
        $this->name = $MY->input->post('name');
        $this->description = $MY->input->post('description');
        $this->isActive = $MY->input->post('isActive');
        $this->id_permissions = $MY->input->post('id_permissions');   
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->description) )
        {
            $this->addError('description', 'Campo no debe estar vacío');
        }       
        
        return $this->isErrorEmpty();
    }
    
    public function getProfileEntity()
    {
        $eProfile = new eProfile(FALSE);
        
        $eProfile->id = empty($this->id_profile) ? NULL : $this->id_profile;
        $eProfile->id_rol = empty($this->id_rol) ? NULL : $this->id_rol;
        $eProfile->name = $this->name;
        $eProfile->description = $this->description;
        $eProfile->isActive = $this->isActive;
        
        return $eProfile;
    }
    
    public function getPermissionEntities()
    {
        $eProfilePermissions = array();
                  
        if( !empty($this->id_permissions) )
        {
            foreach( $this->id_permissions as $id_permission ) {

                $eProfilePermission= new eProfilePermission(FALSE);
                $eProfilePermission->id_profile = $this->id_profile;
                $eProfilePermission->id_permission = $id_permission;

                $eProfilePermissions[]=$eProfilePermission;
            }
        }
        
        return $eProfilePermissions;
    }  
    
    public function setProfileEntity( eProfile $eProfile )
    {
        $this->id_profile = $eProfile->id;
        $this->id_rol = $eProfile->id_rol;
        $this->name = $eProfile->name ;
        $this->description = $eProfile->description;
        $this->isActive = $eProfile->isActive;
        
        $this->_is_profile_editable = $eProfile->isEditable;
    }       
    
    public function setProfilePermissionEntities( $eProfilePermissions )
    {
        if( !empty($eProfilePermissions) )
        {
            /* @var $eProfilePermission eProfilePermission */
            foreach( $eProfilePermissions as $eProfilePermission )
            {               
                $this->id_permissions[] = $eProfilePermission->id_permission;
            }
        }
    }
}