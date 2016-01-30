<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require_once BASEPATH . '../application/third_party/nusoap/lib/nusoap.php';

class Helper_File {

    static public function files_identical($fn1, $fn2, array $exclude = []) {

        if (filetype($fn1) !== filetype($fn2))
            return FALSE;

        /* if (filesize($fn1) !== filesize($fn2))
          return FALSE; */

        if (!$fp1 = @fopen($fn1, 'r'))
            return FALSE;

        if (!$fp2 = @fopen($fn2, 'r')) {
            fclose($fp1);
            return FALSE;
        }

        $same = TRUE;
        $count = 1;

        while (($bufer1 = fgets($fp1, 4096)) !== false && ($bufer2 = fgets($fp2, 4096)) !== false) {

            if (!in_array($count, $exclude)) {
                if ($bufer1 !== $bufer2) {
                    $same = FALSE;
                    break;
                }
            }

            $count++;
        }

        fclose($fp1);
        fclose($fp2);

        return $same;
    }

}
