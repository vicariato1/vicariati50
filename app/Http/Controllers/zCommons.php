<?php

class CommonsP extends Controller {

    public function convData($dataDDMMYYYY) {
        $anno = substr($dataDDMMYYYY, 6, 4);
        $mese = substr($dataDDMMYYYY, 3, 2);
        $giorno = substr($dataDDMMYYYY, 0, 2);
        return $anno . '-' . $mese . '-' . $giorno;
    }

    public static function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
