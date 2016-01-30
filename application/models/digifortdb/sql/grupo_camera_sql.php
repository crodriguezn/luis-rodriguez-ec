<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * SQL = Camaras en General
 * $dateBegin string 'date()'
 * $dateEnd string 'date()'
 */

class Grupo_Camera_SQL
{
    static public function access_terminal($dateEnd, $dateBegin = NULL)
    {
        $sql = "
                SELECT
                    A2.WEEK2             AS week,
                    A2.DATE2             AS r_date,
                    A2.HOUR2 || ':00:00' AS r_hour,
                    A2.ID_GRUPO_CAMARA   AS id_group_camera,
                    A2.GRUPO_CAMARA      AS group_camera,
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
                        END )         AS camera,
                    A2.EVENT_TYPE2    AS event,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*,
                            ( EXTRACT (WEEK FROM T_A.START_DATE) )                   AS WEEK2,
                            CAST (T_A.START_DATE AS DATE)                            AS DATE2,
                            SUBSTRING ( CAST (T_A.START_DATE AS TIME) FROM 1 FOR 2 ) AS HOUR2,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 1 AND 4)
                                    THEN 'PARQUEO PUBLICO PUERTA #1'
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
                                    ELSE 'NO DEFINIDO'
                                END ) AS GRUPO_CAMARA,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 1 AND 4)
                                    THEN '1'
                                    WHEN (T_A.CAMERA BETWEEN 5 AND 8)
                                    THEN '2'
                                    WHEN (T_A.CAMERA BETWEEN 9 AND 10)
                                    THEN '3'
                                    WHEN (T_A.CAMERA BETWEEN 11 AND 12)
                                    THEN '4'
                                    WHEN (T_A.CAMERA BETWEEN 13 AND 14)
                                    THEN '5'
                                    WHEN (T_A.CAMERA BETWEEN 15 AND 16)
                                    THEN '6'
                                    ELSE '0'
                                END )     AS ID_GRUPO_CAMARA,
                            T_A.ZONE_NAME AS EVENT_TYPE2
                        FROM
                            T_ANALYTICS AS T_A
                        WHERE
                            1 = 1
                        AND T_A.ZONE_NAME IN ('ENTRADA', 'SALIDA') ) A2
                WHERE
                    1 = 1
                ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                AND A2.ID_GRUPO_CAMARA BETWEEN '1' AND '6'
                GROUP BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2
                ORDER BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2";
        return $sql;
    }
    
    static public function banios($dateEnd, $dateBegin = NULL)
    {
        $sql = "
                SELECT
                    A2.WEEK2             AS week,
                    A2.DATE2             AS r_date,
                    A2.HOUR2 || ':00:00' AS r_hour,
                    A2.ID_GRUPO_CAMARA   AS id_group_camera,
                    A2.GRUPO_CAMARA      AS group_camera,
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
                        END )         AS camera,
                    A2.EVENT_TYPE2    AS event,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*,
                            ( EXTRACT (WEEK FROM T_A.START_DATE) )                   AS WEEK2,
                            CAST (T_A.START_DATE AS DATE)                            AS DATE2,
                            SUBSTRING ( CAST (T_A.START_DATE AS TIME) FROM 1 FOR 2 ) AS HOUR2,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 23 AND 24)
                                    THEN 'BAÑOS PB ZONA A - B'
                                    WHEN ( T_A.CAMERA = 31
                                        OR  T_A.CAMERA = 33 )
                                    THEN 'BAÑOS 1er. PISO'
                                    WHEN ( (T_A.CAMERA = 40)
                                        OR  (T_A.CAMERA BETWEEN 42 AND 43) )
                                    THEN 'BAÑOS 2do. PISO'
                                    ELSE 'NO DEFINIDO'
                                END ) AS GRUPO_CAMARA,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 23 AND 24)
                                    THEN '1'
                                    WHEN ( T_A.CAMERA = 31
                                        OR  T_A.CAMERA = 33 )
                                    THEN '2'
                                    WHEN ( (T_A.CAMERA = 40)
                                        OR  (T_A.CAMERA BETWEEN 42 AND 43) )
                                    THEN '3'
                                    ELSE 'NO DEFINIDO'
                                END )     AS ID_GRUPO_CAMARA,
                            T_A.ZONE_NAME AS EVENT_TYPE2
                        FROM
                            T_ANALYTICS AS T_A
                        WHERE
                            1 = 1
                        AND T_A.ZONE_NAME IN ('ENTRADA', 'SALIDA') ) A2
                WHERE
                    1 = 1
                ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                AND A2.ID_GRUPO_CAMARA BETWEEN '1' AND '3'
                GROUP BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2
                ORDER BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2";
        return $sql;
    }
    
    static public function patio_comida($dateEnd, $dateBegin = NULL)
    {
        $sql = "
                SELECT
                    A2.WEEK2             AS week,
                    A2.DATE2             AS r_date,
                    A2.HOUR2 || ':00:00' AS r_hour,
                    A2.ID_GRUPO_CAMARA   AS id_group_camera,
                    A2.GRUPO_CAMARA      AS group_camera,
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
                        END )         AS camera,
                    A2.EVENT_TYPE2    AS event,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*,
                            ( EXTRACT (WEEK FROM T_A.START_DATE) )                   AS WEEK2,
                            CAST (T_A.START_DATE AS DATE)                            AS DATE2,
                            SUBSTRING ( CAST (T_A.START_DATE AS TIME) FROM 1 FOR 2 ) AS HOUR2,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 17 AND 20)
                                    THEN 'PATIO DE COMIDAS'
                                    ELSE 'NO DEFINIDO'
                                END ) AS GRUPO_CAMARA,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 17 AND 20)
                                    THEN '1'
                                    ELSE 'NO DEFINIDO'
                                END )     AS ID_GRUPO_CAMARA,
                            T_A.ZONE_NAME AS EVENT_TYPE2
                        FROM
                            T_ANALYTICS AS T_A
                        WHERE
                            1 = 1
                        AND T_A.ZONE_NAME IN ('ENTRADA', 'SALIDA') ) A2
                WHERE
                    1 = 1
                ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                AND A2.ID_GRUPO_CAMARA = '1'
                GROUP BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2
                ORDER BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2";
        return $sql;
    }
    
    static public function escaleras_ascensores($dateEnd, $dateBegin = NULL)
    {
        $sql = "
                SELECT
                    A2.WEEK2             AS week,
                    A2.DATE2             AS r_date,
                    A2.HOUR2 || ':00:00' AS r_hour,
                    A2.ID_GRUPO_CAMARA   AS id_group_camera,
                    A2.GRUPO_CAMARA      AS group_camera,
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
                        END )         AS camera,
                    A2.EVENT_TYPE2    AS event,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*,
                            ( EXTRACT (WEEK FROM T_A.START_DATE) )                   AS WEEK2,
                            CAST (T_A.START_DATE AS DATE)                            AS DATE2,
                            SUBSTRING ( CAST (T_A.START_DATE AS TIME) FROM 1 FOR 2 ) AS HOUR2,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 21 AND 22)
                                    THEN 'ASCENSORES PB'
                                    WHEN (T_A.CAMERA BETWEEN 25 AND 28)
                                    THEN 'ESCALERAS ELECTRICAS'
                                    WHEN (T_A.CAMERA BETWEEN 29 AND 30)
                                    THEN 'ASCENSORES 1er. PISO'
                                    WHEN (T_A.CAMERA BETWEEN 38 AND 39)
                                    THEN 'ASCENSORES 2do. PISO'
                                    ELSE 'NO DEFINIDO'
                                END ) AS GRUPO_CAMARA,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 21 AND 22)
                                    THEN '1'
                                    WHEN (T_A.CAMERA BETWEEN 25 AND 28)
                                    THEN '2'
                                    WHEN (T_A.CAMERA BETWEEN 29 AND 30)
                                    THEN '3'
                                    WHEN (T_A.CAMERA BETWEEN 38 AND 39)
                                    THEN '4'
                                    ELSE '0'
                                END )     AS ID_GRUPO_CAMARA,
                            T_A.ZONE_NAME AS EVENT_TYPE2
                        FROM
                            T_ANALYTICS AS T_A
                        WHERE
                            1 = 1
                        AND T_A.ZONE_NAME IN ('ENTRADA', 'SALIDA') ) A2
                WHERE
                    1 = 1
                ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                AND A2.ID_GRUPO_CAMARA BETWEEN '1' AND '4'
                GROUP BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2
                ORDER BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2";
        return $sql;
    }
    
    static public function torniquetes($dateEnd, $dateBegin = NULL) 
    {
        $sql = "
                SELECT
                    A2.WEEK2             AS week,
                    A2.DATE2             AS r_date,
                    A2.HOUR2 || ':00:00' AS r_hour,
                    A2.ID_GRUPO_CAMARA   AS id_group_camera,
                    A2.GRUPO_CAMARA      AS group_camera,
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
                        END )         AS camera,
                    A2.EVENT_TYPE2    AS event,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*,
                            ( EXTRACT (WEEK FROM T_A.START_DATE) )                   AS WEEK2,
                            CAST (T_A.START_DATE AS DATE)                            AS DATE2,
                            SUBSTRING ( CAST (T_A.START_DATE AS TIME) FROM 1 FOR 2 ) AS HOUR2,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 34 AND 37)
                                    THEN 'TORNIQUETE 1er. PISO'
                                    WHEN (T_A.CAMERA BETWEEN 44 AND 47)
                                    THEN 'TORNIQUETES 2do. PISO'
                                    WHEN (T_A.CAMERA = 32)
                                    THEN 'V.I.P ORENSES'
                                    WHEN (T_A.CAMERA = 41)
                                    THEN 'V.I.P FBI'
                                    ELSE 'NO DEFINIDO'
                                END ) AS GRUPO_CAMARA,
                            (
                                CASE
                                    WHEN (T_A.CAMERA BETWEEN 34 AND 37)
                                    THEN '1'
                                    WHEN (T_A.CAMERA BETWEEN 44 AND 47)
                                    THEN '2'
                                    WHEN (T_A.CAMERA = 32)
                                    THEN '3'
                                    WHEN (T_A.CAMERA = 41)
                                    THEN '4'
                                    ELSE '0'
                                END )     AS ID_GRUPO_CAMARA,
                            T_A.ZONE_NAME AS EVENT_TYPE2
                        FROM
                            T_ANALYTICS AS T_A
                        WHERE
                            1 = 1
                        AND T_A.ZONE_NAME IN ('ENTRADA',
                                              'SALIDA') ) A2
                WHERE
                    1 = 1
                ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                AND A2.ID_GRUPO_CAMARA BETWEEN '1' AND '4'
                GROUP BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2
                ORDER BY
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.ID_GRUPO_CAMARA,
                    A2.GRUPO_CAMARA,
                    A2.CAMERA,
                    A2.EVENT_TYPE2";
        
    }

    static public function sql($dateEnd, $dateBegin = NULL)
    {
        $sql ="
                SELECT
                    A2.WEEK2 AS week,
                    A2.DATE2 AS r_date,
                    A2.HOUR2 || ':00:00' AS r_hour,
                    A2.ID_GRUPO_CAMARA AS id_group_camera,
                    A2.GRUPO_CAMARA AS group_camera,
                    A2.EVENT_TYPE2 AS event,
                    (
                        CASE
                        WHEN (A2.CAMERA = 1) THEN
                            'P1-1'
                        WHEN (A2.CAMERA = 2) THEN
                            'P1-2'
                        WHEN (A2.CAMERA = 3) THEN
                            'P1-3'
                        WHEN (A2.CAMERA = 4) THEN
                            'P1-4'
                        WHEN (A2.CAMERA = 5) THEN
                            'P2-1'
                        WHEN (A2.CAMERA = 6) THEN
                            'P2-2'
                        WHEN (A2.CAMERA = 7) THEN
                            'P2-3'
                        WHEN (A2.CAMERA = 8) THEN
                            'P2-4'
                        WHEN (A2.CAMERA = 9) THEN
                            'P3-1'
                        WHEN (A2.CAMERA = 10) THEN
                            'P3-2'
                        WHEN (A2.CAMERA = 11) THEN
                            'PA-1'
                        WHEN (A2.CAMERA = 12) THEN
                            'PA-2'
                        WHEN (A2.CAMERA = 13) THEN
                            'PB-1'
                        WHEN (A2.CAMERA = 14) THEN
                            'PB-2'
                        WHEN (A2.CAMERA = 15) THEN
                            'PC-1'
                        WHEN (A2.CAMERA = 16) THEN
                            'PC-2'
                        WHEN (A2.CAMERA = 17) THEN
                            'PC-1'
                        WHEN (A2.CAMERA = 18) THEN
                            'PC-2'
                        WHEN (A2.CAMERA = 19) THEN
                            'PC-3'
                        WHEN (A2.CAMERA = 20) THEN
                            'PC-4'
                        WHEN (A2.CAMERA = 21) THEN
                            'APB-A'
                        WHEN (A2.CAMERA = 22) THEN
                            'APB-B'
                        WHEN (A2.CAMERA = 23) THEN
                            'BPB-A'
                        WHEN (A2.CAMERA = 24) THEN
                            'BPB-B'
                        WHEN (A2.CAMERA = 25) THEN
                            'EPB-A'
                        WHEN (A2.CAMERA = 26) THEN
                            'EP1-A'
                        WHEN (A2.CAMERA = 27) THEN
                            'EPB-B'
                        WHEN (A2.CAMERA = 28) THEN
                            'EP1-B'
                        WHEN (A2.CAMERA = 29) THEN
                            'AP1-A'
                        WHEN (A2.CAMERA = 30) THEN
                            'AP1-B'
                        WHEN (A2.CAMERA = 31) THEN
                            'BP1-A(MIXTO)'
                        WHEN (A2.CAMERA = 32) THEN
                            'SALA VIP ORENSES'
                        WHEN (A2.CAMERA = 33) THEN
                            'BP1-BH'
                        WHEN (A2.CAMERA = 34) THEN
                            'S2-1'
                        WHEN (A2.CAMERA = 35) THEN
                            'S2-2'
                        WHEN (A2.CAMERA = 36) THEN
                            'S1-1'
                        WHEN (A2.CAMERA = 37) THEN
                            'S1-2'
                        WHEN (A2.CAMERA = 38) THEN
                            'AP2-A'
                        WHEN (A2.CAMERA = 39) THEN
                            'AP2-B'
                        WHEN (A2.CAMERA = 40) THEN
                            'BP2-AM'
                        WHEN (A2.CAMERA = 41) THEN
                            'SALA VIP FBI'
                        WHEN (A2.CAMERA = 42) THEN
                            'BP2-BM'
                        WHEN (A2.CAMERA = 43) THEN
                            'BP2-BH'
                        WHEN (A2.CAMERA = 44) THEN
                            'S4-1'
                        WHEN (A2.CAMERA = 45) THEN
                            'S4-2'
                        WHEN (A2.CAMERA = 46) THEN
                            'S3-1'
                        WHEN (A2.CAMERA = 47) THEN
                            'S4-2'
                        ELSE
                            'INDEFINIDA'
                        END
                    ) AS camera,
                    COUNT (A2.CAMERA) AS total
                FROM
                    (
                        SELECT
                            T_A.*, (
                                EXTRACT (WEEK FROM T_A.START_DATE)
                            ) AS WEEK2,
                            CAST (T_A.START_DATE AS DATE) AS DATE2,
                            CAST (T_A.START_DATE AS TIME) AS TIME2,
                            SUBSTRING (
                                CAST (T_A.START_DATE AS TIME)
                                FROM
                                    1 FOR 2
                            ) AS HOUR2,
                            (
                                CASE
                                WHEN (T_A.CAMERA BETWEEN 1 AND 4) THEN
                                    'PARQUEOS PUBLICOS PUERTA N.1'
                                WHEN (T_A.CAMERA BETWEEN 5 AND 8) THEN
                                    'PARQUEOS PUBLICOS PUERTA N.2'
                                WHEN (T_A.CAMERA BETWEEN 9 AND 10) THEN
                                    'LLEGADA TAXIS PUERTA N.3'
                                WHEN (T_A.CAMERA BETWEEN 11 AND 12) THEN
                                    'ARRIBOS PUERTA A'
                                WHEN (T_A.CAMERA BETWEEN 13 AND 14) THEN
                                    'ARRIBOS PUERTA B'
                                WHEN (T_A.CAMERA BETWEEN 15 AND 16) THEN
                                    'ARRIBOS PUERTA C'
                                WHEN (T_A.CAMERA BETWEEN 17 AND 20) THEN
                                    'PATIO DE COMIDAS'
                                WHEN (T_A.CAMERA BETWEEN 21 AND 22) THEN
                                    'ASCENSORES PB'
                                WHEN (T_A.CAMERA BETWEEN 23 AND 24) THEN
                                    'BAÑOS PB ZONA A - B'
                                WHEN (T_A.CAMERA BETWEEN 25 AND 28) THEN
                                    'ESCALERAS ELECTRICAS'
                                WHEN (T_A.CAMERA BETWEEN 29 AND 30) THEN
                                    'ASCENSORES 1er. PISO'
                                WHEN (
                                    T_A.CAMERA = 31
                                    OR T_A.CAMERA = 33
                                ) THEN
                                    'BAÑOS 1er. PISO'
                                WHEN (T_A.CAMERA BETWEEN 34 AND 37) THEN
                                    'TORNIQUETE 1er. PISO'
                                WHEN (T_A.CAMERA = 32) THEN
                                    'SALA VIP ORENSES'
                                WHEN (T_A.CAMERA BETWEEN 38 AND 39) THEN
                                    'ASCENSORES 2do. PISO'
                                WHEN (
                                    T_A.CAMERA = 40
                                    OR (T_A.CAMERA BETWEEN 42 AND 43)
                                ) THEN
                                    'BAÑOS 2do.  PISO'
                                WHEN (T_A.CAMERA BETWEEN 44 AND 47) THEN
                                    'TORNIQUETES 2do. PISO'
                                WHEN (T_A.CAMERA = 41) THEN
                                    'SALA VIP FBI'
                                ELSE
                                    'NO DEFINIDO'
                                END
                            ) AS GRUPO_CAMARA,
                            (
                                CASE
                                WHEN (T_A.CAMERA BETWEEN 1 AND 4) THEN
                                    '1'
                                WHEN (T_A.CAMERA BETWEEN 5 AND 8) THEN
                                    '2'
                                WHEN (T_A.CAMERA BETWEEN 9 AND 10) THEN
                                    '3'
                                WHEN (T_A.CAMERA BETWEEN 11 AND 12) THEN
                                    '4'
                                WHEN (T_A.CAMERA BETWEEN 13 AND 14) THEN
                                    '5'
                                WHEN (T_A.CAMERA BETWEEN 15 AND 16) THEN
                                    '6'
                                WHEN (T_A.CAMERA BETWEEN 17 AND 20) THEN
                                    '7'
                                WHEN (T_A.CAMERA BETWEEN 21 AND 22) THEN
                                    '8'
                                WHEN (T_A.CAMERA BETWEEN 23 AND 24) THEN
                                    '9'
                                WHEN (T_A.CAMERA BETWEEN 25 AND 28) THEN
                                    '10'
                                WHEN (T_A.CAMERA BETWEEN 29 AND 30) THEN
                                    '11'
                                WHEN (
                                    T_A.CAMERA = 31
                                    OR T_A.CAMERA = 33
                                ) THEN
                                    '12'
                                WHEN (T_A.CAMERA BETWEEN 34 AND 37) THEN
                                    '13'
                                WHEN (T_A.CAMERA = 32) THEN
                                    '14'
                                WHEN (T_A.CAMERA BETWEEN 38 AND 39) THEN
                                    '15'
                                WHEN (
                                    T_A.CAMERA = 40
                                    OR (T_A.CAMERA BETWEEN 42 AND 43)
                                ) THEN
                                    '16'
                                WHEN (T_A.CAMERA BETWEEN 44 AND 47) THEN
                                    '17'
                                WHEN (T_A.CAMERA = 41) THEN
                                    '18'
                                ELSE
                                    '0'
                                END
                            ) AS ID_GRUPO_CAMARA,
                            T_A.ZONE_NAME AS EVENT_TYPE2
                        FROM
                            T_ANALYTICS AS T_A
                        WHERE
                            1 = 1
                        AND T_A.ZONE_NAME IN ('ENTRADA', 'SALIDA')
                    ) A2
                WHERE
                    1 = 1
                    ".(empty($dateBegin) ? 'AND A2.START_DATE < \''.$dateEnd.'\'' :'AND A2.START_DATE BETWEEN \''.$dateBegin.'\' AND \''.$dateEnd.'\'')."
                GROUP BY
                    A2.GRUPO_CAMARA,
                    A2.ID_GRUPO_CAMARA,
                    A2.EVENT_TYPE2,
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2,
                    A2.CAMERA
                ORDER BY
                    A2.CAMERA,
                    A2.EVENT_TYPE2,
                    A2.GRUPO_CAMARA,
                    A2.WEEK2,
                    A2.DATE2,
                    A2.HOUR2";
        return $sql;
    }
}