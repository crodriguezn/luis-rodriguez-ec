<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * SQL = Accesos al Terminal
 * $dateBegin string 'date()'
 * $dateEnd string 'date()'
 */

class Resumen_Camera_SQL
{
    static public function sql($dateEnd, $dateBegin = null)
    {
        $sql = "
                    SELECT
                        A2.WEEK2           AS week,
                        A2.DATE2           AS r_date,
                        A2.ID_GRUPO_CAMARA AS id_group_camera,
                        A2.GRUPO_CAMARA    AS group_camera,
                        A2.EVENT_TYPE2     AS event,
                        COUNT (A2.CAMERA)  AS total
                    FROM
                        (
                            SELECT
                                T_A.*,
                                ( EXTRACT (WEEK FROM T_A.START_DATE) ) AS WEEK2,
                                CAST (T_A.START_DATE AS DATE)          AS DATE2,
                                (
                                    CASE
                                        WHEN (T_A.CAMERA BETWEEN 1 AND 4)
                                        THEN 'PUERTA #1'
                                        WHEN (T_A.CAMERA BETWEEN 5 AND 8)
                                        THEN 'PUERTA # 2'
                                        WHEN (T_A.CAMERA BETWEEN 9 AND 10)
                                        THEN 'PUERTA # 3'
                                        WHEN (T_A.CAMERA BETWEEN 11 AND 12)
                                        THEN 'PUERTA A'
                                        WHEN (T_A.CAMERA BETWEEN 13 AND 14)
                                        THEN 'PUERTA B'
                                        WHEN (T_A.CAMERA BETWEEN 15 AND 16)
                                        THEN 'PUERTA C'
                                        WHEN (T_A.CAMERA BETWEEN 17 AND 20)
                                        THEN 'PATIO DE COMIDAS'
                                        WHEN (T_A.CAMERA BETWEEN 21 AND 22)
                                        THEN 'ASCENSORES PB'
                                        WHEN (T_A.CAMERA BETWEEN 23 AND 24)
                                        THEN 'BAÑOS PB ZONA A - B'
                                        WHEN (T_A.CAMERA BETWEEN 25 AND 28)
                                        THEN 'ESCALERAS ELECTRICAS'
                                        WHEN (T_A.CAMERA BETWEEN 29 AND 30)
                                        THEN 'ASCENSORES 1er. PISO'
                                        WHEN ( T_A.CAMERA = 31
                                            OR T_A.CAMERA = 33 )
                                        THEN 'BAÑOS 1er. PISO'
                                        WHEN (T_A.CAMERA BETWEEN 34 AND 37)
                                        THEN 'TORNIQUETE 1er. PISO'
                                        WHEN (T_A.CAMERA = 32)
                                        THEN 'V.I.P ORENSES'
                                        WHEN (T_A.CAMERA BETWEEN 38 AND 39)
                                        THEN 'ASCENSORES 2do. PISO'
                                        WHEN ( (T_A.CAMERA = 40)
                                            OR (T_A.CAMERA BETWEEN 42 AND 43) )
                                        THEN 'BAÑOS 2do. PISO'
                                        WHEN (T_A.CAMERA BETWEEN 44 AND 47)
                                        THEN 'TORNIQUETES 2do. PISO'
                                        WHEN (T_A.CAMERA = 41)
                                        THEN 'V.I.P FBI'
                                        ELSE 'NO DEFINIDO'
                                    END ) AS GRUPO_CAMARA,
                                (
                                    CASE
                                        WHEN (T_A.CAMERA BETWEEN 1 AND 4)
                                        THEN '010'
                                        WHEN (T_A.CAMERA BETWEEN 5 AND 8)
                                        THEN '011'
                                        WHEN (T_A.CAMERA BETWEEN 9 AND 10)
                                        THEN '012'
                                        WHEN (T_A.CAMERA BETWEEN 11 AND 12)
                                        THEN '013'
                                        WHEN (T_A.CAMERA BETWEEN 13 AND 14)
                                        THEN '014'
                                        WHEN (T_A.CAMERA BETWEEN 15 AND 16)
                                        THEN '015'
                                        WHEN (T_A.CAMERA BETWEEN 17 AND 20)
                                        THEN '016'
                                        WHEN (T_A.CAMERA BETWEEN 21 AND 22)
                                        THEN '017'
                                        WHEN (T_A.CAMERA BETWEEN 23 AND 24)
                                        THEN '018'
                                        WHEN (T_A.CAMERA BETWEEN 25 AND 28)
                                        THEN '019'
                                        WHEN (T_A.CAMERA BETWEEN 29 AND 30)
                                        THEN '020'
                                        WHEN ( T_A.CAMERA = 31
                                            OR T_A.CAMERA = 33 )
                                        THEN '021'
                                        WHEN (T_A.CAMERA BETWEEN 38 AND 39)
                                        THEN '022'
                                        WHEN ( (T_A.CAMERA = 40)
                                            OR (T_A.CAMERA BETWEEN 42 AND 43) )
                                        THEN '023'
                                        WHEN (T_A.CAMERA BETWEEN 34 AND 37)
                                        THEN '024'
                                        WHEN (T_A.CAMERA = 32)
                                        THEN '025'
                                        WHEN (T_A.CAMERA BETWEEN 44 AND 47)
                                        THEN '026'
                                        WHEN (T_A.CAMERA = 41)
                                        THEN '027'
                                        ELSE '0'
                                    END )     AS ID_GRUPO_CAMARA,
                                T_A.ZONE_NAME AS EVENT_TYPE2
                            FROM
                                T_ANALYTICS AS T_A
                            WHERE
                                1 = 1
                            AND T_A.EVENT_TYPE IN (15,
                                                   16) ) A2
                    WHERE
                        1 = 1
                        ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                    GROUP BY
                        A2.WEEK2,
                        A2.DATE2,
                        A2.ID_GRUPO_CAMARA,
                        A2.GRUPO_CAMARA,
                        A2.EVENT_TYPE2
                    ORDER BY
                        A2.WEEK2,
                        A2.DATE2,
                        A2.ID_GRUPO_CAMARA,
                        A2.GRUPO_CAMARA,
                        A2.EVENT_TYPE2
                ";
        return $sql;
    }
}