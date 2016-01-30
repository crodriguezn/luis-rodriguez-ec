<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Fecha
{
    static public function validar_fecha($fecha)
    {
        $format="ymd";
        
        $separator_type= array(
            "/",
            "-",
            "."
        );
        
        foreach ($separator_type as $separator) {
            $find= stripos($fecha,$separator);
            
            if($find<>false){
                $separator_used= $separator;
            }
        }
        
        $fecha_array= explode($separator_used,$fecha);
        
        if ($format=="mdy") {
            return checkdate($fecha_array[0],$fecha_array[1],$fecha_array[2]);
        } elseif ($format=="ymd") {
            return checkdate($fecha_array[1],$fecha_array[2],$fecha_array[0]);
        } else {
            echo checkdate($fecha_array[1],$fecha_array[0],$fecha_array[2]);
            return checkdate($fecha_array[1],$fecha_array[0],$fecha_array[2]);
        }
        
        $fecha_array=array();
    }
    
    /*
     * 
     * @param $year and month
     * @param $isReturnString BOLLEAN FALSE/TRUE (default FALSE)
     * return last day
     * 
     */
    static public function getLastDay_By_YearMonth($year=NULL, $month=NULL, $isReturnString = FALSE )
    {
        if(empty($year)) {$year=date("Y");}
        if(empty($month)) {$month=date("m");}
        if($isReturnString)
        {
            return str_pad(date("d",(mktime(0,0,0,$month+1,1,$year)-1)), 2, "0", STR_PAD_LEFT);
        }
        else 
        {
            return date("d",(mktime(0,0,0,$month+1,1,$year)-1));
        }
    }
    
    
    static public function getArrayYear($next=0, $range=100)
    {
        $year = array();
        
        for($i = date("Y"); $i >= date("Y") - $range; $i--)
        {
            if(empty($next))
            {
                $year[] = $i;
            }
            else
            {
                $year[] = array($i, $i + $next);
            }
            
        }
        
        return $year;
    }
    
    static public function getArrayMonth()
    {
        $lastMonth = 12;
        $month = 1;
        $array = array();
        
        for ($month; $month <= $lastMonth; $month++)
        {
            $array[] = array('code' => str_pad($month, 2, "0", STR_PAD_LEFT), 'name' => str_pad(self::getMonth_Translate($month), 2, "0", STR_PAD_LEFT));
        }
        
        return $array;
    }
    
    static public function getArrayDay($year, $month)
    {
        $lastDay = self::getLastDay_By_YearMonth($year, $month);
        $array = array();
        $day = 1;
        for ($day; $day <= $lastDay; $day++)
        {
            
            $array[] = array('code' => str_pad($day, 2, "0", STR_PAD_LEFT), 'name' => str_pad($day, 2, "0", STR_PAD_LEFT));
        }
        
        return $array;
    }

    /*
     * 
     * @param month(default (date('m')))
     * return translate month Spanish
     * 
     */
    static public function getMonth_Translate($month=null)
    {
        if(empty($month)){ $month= date("m"); }
        //Helper_Log::write($month);
        switch( $month )
        {
            case '01':  return 'Enero';         
            case '02':  return 'Febrero';       
            case '03':  return 'Marzo';         
            case '04':  return 'Abril';         
            case '05':  return 'Mayo';          
            case '06':  return 'Junio';         
            case '07':  return 'Julio';         
            case '08':  return 'Agosto';        
            case '09':  return 'Septiembre';    
            case '10':  return 'Octubre';       
            case '11':  return 'Noviembre';     
            case '12':  return 'Diciembre';     
            default:    return 'NO FOUND';      
        }
    }
    
    /*
     * 
     * @param string $dateTimeB (Fecha de Inicio)
     * @param string $dateTimeE (Fecha de Fin, defaul date("Y-m-d H:i:s"))
     * @param boolean $isTimeStamp::Retorna el tiempo
     * return diferencia de %d días - %d horas - %d minutos - %s segundos
     * 
     */
    static public function getDiff_DateTime($dateTimeB, $isTimeStamp=FALSE)
    {
        $Date_Begin = new DateTime($dateTimeB);
        $Date_End = new DateTime(date("Y-m-d H:i:s"));
        $Diff_Date = $Date_Begin->diff($Date_End);
        if($isTimeStamp)
        {
            return $Diff_Date;
        }
        else
        {
            return sprintf('%d días - %d horas - %d minutos - %s segundos', $Diff_Date->d, $Diff_Date->h, $Diff_Date->i, $Diff_Date->s);
        }
    }
    
    /*
     * 
     * @param string $date (Fecha a validar)
     * @param string $format (Formato a validar)
     * return boolean
     * 
     */
    static public function isValid($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        
        return $d && $d->format($format) == $date;
    }
    
    /*
     * 
     * @param string $dateBegin (Fecha de inicio)
     * @param string $dateEnd (Fecha fin)
     * @param string $date (Fecha a validar en el rango)
     * @param string $format (Formato a validar)
     * return boolean
     * 
     */
    
    static public function isValidRangeDate($dateBegin, $dateEnd, $date, $format = 'Y-m-d H:i:s' )
    {
        
        if(!self::isValid($date, $format) || !self::isValid($dateBegin, $format) || !self::isValid($dateEnd, $format))
        {
            //throw new Exception('Fecha Invalida.');
            return FALSE;
        }
        if(!($date>=$dateBegin && $date<=$dateEnd))
        {
            //throw new Exception('Rango de Fecha Invalida.');
            return FALSE;
        }
        return TRUE;
    }
    
}
