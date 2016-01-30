<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$sql = "
            SELECT
            DATE2,
            (
                CASE
                WHEN (T1.CAMERA BETWEEN 34 AND 35) THEN
                    'SILO 2'
                WHEN (T1.CAMERA BETWEEN 36 AND 37) THEN
                    'SILO 1'
                WHEN (T1.CAMERA=32) THEN
                    'Sala VIP Rut. Orenses'
                WHEN (T1.CAMERA BETWEEN 44 AND 45) THEN
                    'SILO 4'
                WHEN (T1.CAMERA BETWEEN 46 AND 47) THEN
                    'SILO 3'
                WHEN (T1.CAMERA=41) THEN
                    'Sala VIP FBI'
                ELSE
                    'NO FOUND'
                END
            ) AS G_CAMARA,
            EVENT_TYPE2,
            SUM(TOTAL_COUNT)
        FROM
            (
                SELECT
                    A2.WEEK2 AS WEEK2,
                    A2.DATE2 AS DATE2,
                    --A2.TIME2 AS TIME2,
                    A2.HOUR2 || ':00:00' AS HOUR2,
                    A2.MONTH2 AS MONTH2,
                    (
                        CASE
                        WHEN (A2.MONTH2 = '1') THEN
                            'ENERO'
                        WHEN (A2.MONTH2 = '2') THEN
                            'FEBRERO'
                        WHEN (A2.MONTH2 = '3') THEN
                            'MARZO'
                        WHEN (A2.MONTH2 = '4') THEN
                            'ABRIL'
                        WHEN (A2.MONTH2 = '5') THEN
                            'MAYO'
                        WHEN (A2.MONTH2 = '6') THEN
                            'JUNIO'
                        WHEN (A2.MONTH2 = '7') THEN
                            'JULIO'
                        WHEN (A2.MONTH2 = '8') THEN
                            'AGOSTO'
                        WHEN (A2.MONTH2 = '9') THEN
                            'SEPTIEMBRE'
                        WHEN (A2.MONTH2 = '10') THEN
                            'OCTUBRE'
                        WHEN (A2.MONTH2 = '11') THEN
                            'NOVIEMBRE'
                        WHEN (A2.MONTH2 = '12') THEN
                            'DICIEMBRE'
                        ELSE
                            'NO DEFINIDO'
                        END
                    ) AS L_MONTH2,
                    A2.ID_GRUPO_CAMARA AS ID_GRUPO,
                    A2.GRUPO_CAMARA AS GRUPO_CAMARA,
                    A2.EVENT_TYPE2 AS EVENT_TYPE2,
                    A2.CAMERA AS CAMERA,
                    COUNT (A2.CAMERA) AS TOTAL_COUNT
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
                                EXTRACT (MONTH FROM T_A.START_DATE)
                            ) AS MONTH2,
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
                                    AND T_A.CAMERA = 33
                                ) THEN
                                    'BAÑOS 1er. PISO'
                                WHEN (T_A.CAMERA BETWEEN 34 AND 37) THEN
                                    'TORNIQUETE 1er. PISO'
                                WHEN (T_A.CAMERA = 32) THEN
                                    'SALA VIP ORENSES'
                                WHEN (T_A.CAMERA BETWEEN 38 AND 39) THEN
                                    'ASCENSORES 2do. PISO'
                                WHEN (
                                    (T_A.CAMERA = 40)
                                    AND (T_A.CAMERA BETWEEN 42 AND 43)
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
                                    AND T_A.CAMERA = 33
                                ) THEN
                                    '12'
                                WHEN (T_A.CAMERA BETWEEN 34 AND 37) THEN
                                    '13'
                                WHEN (T_A.CAMERA = 32) THEN
                                    '14'
                                WHEN (T_A.CAMERA BETWEEN 38 AND 39) THEN
                                    '15'
                                WHEN (
                                    (T_A.CAMERA = 40)
                                    AND (T_A.CAMERA BETWEEN 42 AND 43)
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
                        AND T_A.ZONE_NAME IN ('ENTRADA','SALIDA')
                    ) A2
                WHERE
                    1 = 1
                AND (
                    A2.ID_GRUPO_CAMARA = '17'
                    OR A2.ID_GRUPO_CAMARA = '18'
                    OR A2.ID_GRUPO_CAMARA = '13'
                    OR A2.ID_GRUPO_CAMARA = '14'
                )
                AND (
                    A2.START_DATE BETWEEN '2015-01-01 00:00:00'
                    AND '2015-01-01 23:59:59'
                )
                GROUP BY
                    A2.GRUPO_CAMARA,
                    A2.ID_GRUPO_CAMARA,
                    A2.EVENT_TYPE2,
                    A2.WEEK2,
                    A2.DATE2,
                    A2.MONTH2,
                    --A2.TIME2,
                    A2.HOUR2,
                    A2.CAMERA
                ORDER BY
                    A2.CAMERA,
                    A2.EVENT_TYPE2,
                    A2.GRUPO_CAMARA,
                    A2.WEEK2,
                    A2.DATE2,
                    A2.MONTH2,
                    --A2.TIME2,
                    A2.HOUR2
            ) AS T1
            GROUP BY 
            DATE2,
            G_CAMARA,
            EVENT_TYPE2
        ";