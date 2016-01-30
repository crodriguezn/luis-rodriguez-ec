<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_Personal_Administrativo extends MY_Form
{
    public $id_personal_administrativo;
    public $name;
    public $surname;
    public $tipo_documento;
    public $document;
    public $document_secure;
    public $birthday;
    public $gender;
    public $address;
    public $calle_principal;
    public $calle_secundaria;
    public $sector_urbanizacion;
    public $phone;
    public $celular;
    public $email;
    public $id_profesion;
    public $tipo_sangre;
    public $estado_civil;
    public $instruccion;
    public $nom_usuario;
    public $id_perfil;
    public $contrasenia;
    public $verificar_contrasenia;
    public $isActive;
    public $id_company_branchs;
        
    public function __construct($isReadPost = FALSE)
    {
        parent::__construct();
        
        $this->reset();
    
        if( $isReadPost )
        {
            $this->readPost();
        }
    }

    public function reset()
    {
        $this->id_personal_administrativo = 0;
        $this->name = '';
        $this->surname = '';
        $this->tipo_documento = 'TIPO_IDENT_CEDULA';
        $this->document = '';
        $this->document_secure = $this->encode($this->document);
        $this->birthday = '';
        $this->gender = 'GENDER_MALE';
        $this->address = '';
        $this->calle_principal = '';
        $this->calle_secundaria = '';
        $this->sector_urbanizacion = '';
        $this->phone = '';
        $this->celular = '';
        $this->email = '';
        $this->id_profesion = 28;
        $this->tipo_sangre = 'TIPO_SANGRE_A+';
        $this->id_religion = 3;
        $this->id_idioma = 1;
        $this->id_pais = 70;
        $this->id_provincia = 1558;
        $this->id_ciudad = 3789;
        $this->instruccion = 'INSTRUC_UNIVERSITARIA';
        $this->lugar_trabajo = '';
        $this->telefono_trabajo = '';
        $this->estado_civil = 'ESTADO_CIVIL_SOLTERO';
        $this->nom_usuario = '';
        $this->id_perfil = 0;
        $this->contrasenia = '';
        $this->verificar_contrasenia = '';
        $this->isActive = 1;
        $this->id_company_branchs = array();
    }
    
    public function readPost()
    {
        $MY = & MY_Controller::get_instance();

        $this->id_personal_administrativo = $MY->input->post('id_personal_administrativo');
        $this->name = $MY->input->post('name');
        $this->surname = $MY->input->post('surname');
        $this->tipo_documento = $MY->input->post('tipo_documento');
        $this->document = $MY->input->post('document');
        $this->document_secure = $MY->input->post('document_secure');
        $this->birthday = $MY->input->post('birthday');
        $this->gender = $MY->input->post('gender');
        $this->address = $MY->input->post('address');
        $this->calle_principal = $MY->input->post('calle_principal');
        $this->calle_secundaria = $MY->input->post('calle_secundaria');
        $this->sector_urbanizacion = $MY->input->post('sector_urbanizacion');
        $this->phone = $MY->input->post('phone');
        $this->celular = $MY->input->post('celular');
        $this->email = $MY->input->post('email');
        $this->instruccion = $MY->input->post('instruccion');
        $this->estado_civil = $MY->input->post('estado_civil');
        $this->tipo_sangre = $MY->input->post('tipo_sangre');
        $this->id_profesion = $MY->input->post('id_profesion');             
        $this->nom_usuario = $MY->input->post('nom_usuario'); 
        $this->id_perfil = $MY->input->post('id_perfil'); 
        $this->contrasenia = $MY->input->post('contrasenia'); 
        $this->verificar_contrasenia = $MY->input->post('verificar_contrasenia'); 
        $this->isActive = $MY->input->post('isActive'); 
        $this->id_company_branchs = $MY->input->post('id_company_branchs');

        if (empty($this->birthday))
        {
            $this->birthday = NULL;
        }

        if (empty($this->id_profesion)){
            $this->id_profesion = NULL;
        }
    }

    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->surname) )
        {
            $this->addError('surname', 'Campo no debe estar vacío');
        }

        if( empty($this->tipo_documento) )
        {
            $this->addError('tipo_documento', 'Campo no debe estar vacío');
        }
        
        if( empty($this->document) )
        {
            $this->addError('document', 'Campo no debe estar vacío');
        }
        else if( $this->document != $this->encode($this->document_secure, TRUE) )
        {
            $this->addError('document', 'Violación de seguridad');
        }

        if( empty($this->birthday) )
        {
            $this->addError('birthday', 'Campo no debe estar vacío');
        }
        else
        {
            if( Helper_Fecha::validar_fecha($this->birthday) === false )
            {
                $this->addError('birthday', 'Ingrese una fecha válida');
            }
        }

        if( empty($this->address) )
        {
            $this->addError('address', 'Campo no debe estar vacío');
        }                        

        if( empty($this->phone) )
        {
            $this->addError('phone', 'Campo no debe estar vacío');
        }

        if( empty($this->celular) )
        {
            $this->addError('celular', 'Campo no debe estar vacío');
        }

        if( empty($this->email) )
        {
            $this->addError('email', 'Campo no debe estar vacío');
        }
        else
        {
            if( !(valid_email($this->email)) )
            {
                $this->addError('email', 'Ingrese un email válido');
            }
        }

        if( empty($this->nom_usuario) )
        {
            $this->addError('nom_usuario', 'Campo no debe estar vacío');
        }

        if( empty($this->id_perfil) )
        {
            $this->addError('id_perfil', 'Campo no debe estar vacío');
        }

        if( empty($this->id_personal_administrativo) )
        {
            if( empty($this->contrasenia) )
            {
                $this->addError('contrasenia', 'Campo no debe estar vacío');
            }  

            if( empty($this->verificar_contrasenia) )
            {
                $this->addError('verificar_contrasenia', 'Campo no debe estar vacío');
            } 
        }

        if( $this->verificar_contrasenia != $this->contrasenia )
        {
            $this->addError('verificar_contrasenia', 'Verificación de contraseña Inválida');
        }

        return $this->isErrorEmpty();
    }
    
    public function setPersonalAdministrativoEntity( ePersonalAdministrativo $ePersonalAdministrativo )
    {
        $this->id_personal_administrativo = $ePersonalAdministrativo->id;
        $this->isActive = $ePersonalAdministrativo->isActive;
    }
    
    public function getPersonalAdministrativoEntity()
    {
        $ePersonalAdministrativo = new ePersonalAdministrativo(FALSE);
        
        $ePersonalAdministrativo->id = $this->id_personal_administrativo;
        $ePersonalAdministrativo->isActive = $this->isActive;

        return $ePersonalAdministrativo;
    }
    
    public function setPersonEntity( ePerson $ePerson )
    {
        if( $ePerson->isEmpty() )
        {
            return;
        }
        
        $this->name = $ePerson->name;
        $this->surname = $ePerson->surname;
        $this->tipo_documento = $ePerson->tipo_documento;
        $this->document = $ePerson->document;
        $this->document_secure = $this->encode($ePerson->document);
        $this->birthday = $ePerson->birthday;
        $this->gender = $ePerson->gender;
        $this->estado_civil = $ePerson->estado_civil;
        $this->address = $ePerson->address;
        $this->calle_principal = $ePerson->calle_principal;
        $this->calle_secundaria = $ePerson->calle_secundaria;
        $this->sector_urbanizacion = $ePerson->sector_urbanizacion;
        $this->phone = $ePerson->phone;
        $this->celular = $ePerson->celular;
        $this->email = $ePerson->email;
        $this->id_profesion = $ePerson->id_profesion;
        $this->tipo_sangre = $ePerson->tipo_sangre;
        $this->instruccion = $ePerson->instruccion;    
    }
    
    public function getPersonEntity()
    {
        $ePerson = new ePerson(FALSE);
                    
        $ePerson->name = $this->name;
        $ePerson->surname = $this->surname;
        $ePerson->tipo_documento = $this->tipo_documento;
        $ePerson->document = $this->document;
        $ePerson->birthday = $this->birthday;
        $ePerson->gender = $this->gender;
        $ePerson->estado_civil  =  $this->estado_civil;
        $ePerson->address = $this->address;
        $ePerson->calle_principal = $this->calle_principal;
        $ePerson->calle_secundaria = $this->calle_secundaria;
        $ePerson->sector_urbanizacion = $this->sector_urbanizacion;
        $ePerson->phone = $this->phone;
        $ePerson->celular = $this->celular;
        $ePerson->email = $this->email;
        $ePerson->id_profesion = $this->id_profesion;
        $ePerson->estado_civil = $this->estado_civil;
        $ePerson->tipo_sangre = $this->tipo_sangre;
        $ePerson->instruccion = $this->instruccion;
        
        return $ePerson;
    }
    
    public function setUserEntity( eUser $eUser )
    {
        if( $eUser->isEmpty() )
        {
            return;
        }
        
        $this->nom_usuario = $eUser->username;
        $this->contrasenia = $eUser->password;
    }
    
    public function getUserEntity()
    {
        $eUser = new eUser(FALSE);
        
        $eUser->username = $this->nom_usuario;
        $eUser->password = $this->contrasenia;
        
        return $eUser;
    }
    
    public function setProfileEntity( eProfile $eProfile )
    {
        if( $eProfile->isEmpty() )
        {
            return;
        }
        
        $this->id_perfil = $eProfile->id;
    }
    
    public function getProfileEntity()
    {
        $eProfile = new eProfile(FALSE);
        
        $eProfile->id = $this->id_perfil;
        
        return $eProfile;
    }
    
    public function getCompanyBranchEntity()
    {
        $eCompanyBranches = array();
                  
        if( !empty($this->id_company_branchs) )
        {
            foreach( $this->id_company_branchs as $id_company_branch ) {

                $eCompanyBranch = new eCompanyBranch(FALSE);
                
                $eCompanyBranch->id = $id_company_branch;

                $eCompanyBranches[] = $eCompanyBranch;
            }
        }
        
        return $eCompanyBranches;
    }
    
    public function setCompanyBranchEntity( $eCompanyBranches )
    {
        if( !empty($eCompanyBranches) )
        {
            /* @var $eCompanyBranch eCompanyBranch */
            foreach( $eCompanyBranches as $eCompanyBranch )
            {               
                $this->id_company_branchs[] = $eCompanyBranch->id;
            }
        }
    }
}