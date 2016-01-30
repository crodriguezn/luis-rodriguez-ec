<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * SQL = Camaras en General
 * $dateBegin string 'date()'
 * $dateEnd string 'date()'
 */

class Camera_General_SQL
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
                    (
                        CASE
                            WHEN (A2.CAMERA = 1)
                            THEN 'P1-1'
                            WHEN (A2.CAMERA = 2)
                            THEN 'P1-2'
                            WHEN (A2.CAMERA = 3)
                            THEN 'P1-3'
                            WHEN (A2.CAMERA = 4)
                            THEN 'P1-4'
                            WHEN (A2.CAMERA = 5)
                            THEN 'P2-1'
                            WHEN (A2.CAMERA = 6)
                            THEN 'P2-2'
                            WHEN (A2.CAMERA = 7)
                            THEN 'P2-3'
                            WHEN (A2.CAMERA = 8)
                            THEN 'P2-4'
                            WHEN (A2.CAMERA = 9)
                            THEN 'P3-1'
                            WHEN (A2.CAMERA = 10)
                            THEN 'P3-2'
                            WHEN (A2.CAMERA = 11)
                            THEN 'PA-1'
                            WHEN (A2.CAMERA = 12)
                            THEN 'PA-2'
                            WHEN (A2.CAMERA = 13)
                            THEN 'PB-1'
                            WHEN (A2.CAMERA = 14)
                            THEN 'PB-2'
                            WHEN (A2.CAMERA = 15)
                            THEN 'PC-1'
                            WHEN (A2.CAMERA = 16)
                            THEN 'PC-2'
                            WHEN (A2.CAMERA = 17)
                            THEN 'PC-1'
                            WHEN (A2.CAMERA = 18)
                            THEN 'PC-2'
                            WHEN (A2.CAMERA = 19)
                            THEN 'PC-3'
                            WHEN (A2.CAMERA = 20)
                            THEN 'PC-4'
                            WHEN (A2.CAMERA = 21)
                            THEN 'APB-A'
                            WHEN (A2.CAMERA = 22)
                            THEN 'APB-B'
                            WHEN (A2.CAMERA = 23)
                            THEN 'BPB-A'
                            WHEN (A2.CAMERA = 24)
                            THEN 'BPB-B'
                            WHEN (A2.CAMERA = 25)
                            THEN 'EPB-A'
                            WHEN (A2.CAMERA = 26)
                            THEN 'EP1-A'
                            WHEN (A2.CAMERA = 27)
                            THEN 'EPB-B'
                            WHEN (A2.CAMERA = 28)
                            THEN 'EP1-B'
                            WHEN (A2.CAMERA = 29)
                            THEN 'AP1-A'
                            WHEN (A2.CAMERA = 30)
                            THEN 'AP1-B'
                            WHEN (A2.CAMERA = 31)
                            THEN 'BP1-A(MIXTO)'
                            WHEN (A2.CAMERA = 32)
                            THEN 'SALA VIP ORENSES'
                            WHEN (A2.CAMERA = 33)
                            THEN 'BP1-BH'
                            WHEN (A2.CAMERA = 34)
                            THEN 'S2-1'
                            WHEN (A2.CAMERA = 35)
                            THEN 'S2-2'
                            WHEN (A2.CAMERA = 36)
                            THEN 'S1-1'
                            WHEN (A2.CAMERA = 37)
                            THEN 'S1-2'
                            WHEN (A2.CAMERA = 38)
                            THEN 'AP2-A'
                            WHEN (A2.CAMERA = 39)
                            THEN 'AP2-B'
                            WHEN (A2.CAMERA = 40)
                            THEN 'BP2-AM'
                            WHEN (A2.CAMERA = 41)
                            THEN 'SALA VIP FBI'
                            WHEN (A2.CAMERA = 42)
                            THEN 'BP2-BM'
                            WHEN (A2.CAMERA = 43)
                            THEN 'BP2-BH'
                            WHEN (A2.CAMERA = 44)
                            THEN 'S4-1'
                            WHEN (A2.CAMERA = 45)
                            THEN 'S4-2'
                            WHEN (A2.CAMERA = 46)
                            THEN 'S3-1'
                            WHEN (A2.CAMERA = 47)
                            THEN 'S4-2'
                            ELSE 'INDEFINIDA'
                        END )         AS name_camera,
                    A2.CAMERA         AS camera,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*,
                            ( EXTRACT (WEEK FROM T_A.START_DATE) ) AS WEEK2,
                            CAST (T_A.START_DATE AS DATE)          AS DATE2,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 1 AND 4)
                                    THEN 'PARQUEOS PUBLICOS PUERTA #1'
                                    WHEN (T_A.CAMERA BETWEEN 5 AND 8)
                                    THEN 'LLEGADA DE BUSES PUERTA #2'
                                    WHEN (T_A.CAMERA BETWEEN 9 AND 10)
                                    THEN 'LLEGADA TAXIS PUERTA #3'
                                    WHEN (T_A.CAMERA BETWEEN 11 AND 12)
                                    THEN 'ARRIBOS PUERTA A'
                                    WHEN (T_A.CAMERA BETWEEN 13 AND 14)
                                    THEN 'ARRIBOS PUERTA B'
                                    WHEN (T_A.CAMERA BETWEEN 15 AND 16)
                                    THEN 'ARRIBOS PUERTA C'
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
                                        OR  T_A.CAMERA = 33 )
                                    THEN 'BAÑOS 1er. PISO'
                                    WHEN (T_A.CAMERA BETWEEN 34 AND 37)
                                    THEN 'TORNIQUETE 1er. PISO'
                                    WHEN (T_A.CAMERA = 32)
                                    THEN 'V.I.P ORENSES'
                                    WHEN (T_A.CAMERA BETWEEN 38 AND 39)
                                    THEN 'ASCENSORES 2do. PISO'
                                    WHEN ( T_A.CAMERA = 40
                                        OR  (T_A.CAMERA BETWEEN 42 AND 43) )
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
                                        OR  T_A.CAMERA = 33 )
                                    THEN '021'
                                    WHEN (T_A.CAMERA BETWEEN 34 AND 37)
                                    THEN '022'
                                    WHEN (T_A.CAMERA = 32)
                                    THEN '023'
                                    WHEN (T_A.CAMERA BETWEEN 38 AND 39)
                                    THEN '024'
                                    WHEN ( T_A.CAMERA = 40
                                        OR  (T_A.CAMERA BETWEEN 42 AND 43) )
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
                    A2.EVENT_TYPE2,
                    A2.CAMERA
                ORDER BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.CAMERA,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.EVENT_TYPE2";

        return $sql;
    }

}
