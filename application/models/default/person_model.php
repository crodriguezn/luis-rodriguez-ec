<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Person_Model extends MY_Model
{
    protected $table = 'person';

    function __construct()
    {
        parent::__construct();
    }

    function loadByDocument( $document, $except_value='' )
    {
        $ePerson = $this->load($document, 'document', $except_value);

        return $ePerson;
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $ePerson = new ePerson();
        
        $ePerson->parseRow($row);

        return $ePerson;
    }
    
    function loadByUser($id_user, &$ePerson)
    {
        $db =& $this->getConnection();
        
        $sql = '
            SELECT
                "p".*
            FROM
                "person" AS "p"
                INNER JOIN "user" AS "u" ON "u"."id_person" = "p"."id"
            WHERE 1=1
                AND "u"."id" = '.( $this->db->escape($id_user) ).'
        ';
        
        $query = $db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $row = $query->row_array();
        
        $ePerson = new ePerson();
        
        $ePerson->parseRow($row);
    }

    function save(ePerson &$ePerson)
    {
        try
        {
            if( empty($ePerson->id) )
            {
                $ePerson->id = $this->genId();
                $this->insert($ePerson->toData());
            }
            else
            {
                $this->update($ePerson->toData(FALSE), $ePerson->id);
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    function existDocument($document) {
        $sql = "select count(DOCUMENT) from person where DOCUMENT='$document'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($result[0]->count == 0) {
            return 'success';
        } else {
            return 'error';
        }
    }
    
}

class ePerson extends MY_Entity
{
    public $name;
    public $surname;
    public $tipo_documento;
    public $document;
    public $birthday;
    public $gender;
    public $address;
    public $phone_cell;
    public $email;
    public $estado_civil;
    public $tipo_sangre;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->surname = '';
            $this->tipo_documento = '';
            $this->document = '';
            $this->birthday = NULL;
            $this->gender = '';
            $this->address = '';
            $this->phone_cell = '';
            $this->email = '';
            $this->estado_civil = '';
            $this->tipo_sangre = NULL;
        }
    }
}