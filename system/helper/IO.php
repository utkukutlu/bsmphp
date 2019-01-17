<?php
/**
 * User: utku
 * Date: 13.04.2018
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class IO {

    public function getFiles($dir) {
        $files = array_diff(scandir($dir), array('..', '.'));
        $r = array();
        foreach ($files AS $file) {
            if (is_file($dir . DIRECTORY_SEPARATOR . $file)) {
                array_push($r, $file);
            }
        }
        return $r;
    }

    public function getFileType($file) {
        if (is_file($file) && file_exists($file)) {
            return strtolower(pathinfo(basename($file), PATHINFO_EXTENSION));
        }
    }

    public function getFileSize($file) {
        return filesize($file);
    }


    public function getFolderSize($dir, $type = false, $inDır = false) {
        $size = -1;
        $files = array_diff(scandir($dir), array('..', '.'));
        foreach ($files AS $file) {
            $file = $dir . "/" . $file;
            if ($type !== false) {
                if (is_file($file) && strlen(array_search(strtolower(pathinfo(basename($file), PATHINFO_EXTENSION)), $type)) === 0) {
                    continue;
                }
            }
            if (is_file($file)) {
                $size += filesize($file);
            }
        }
        return $size;
    }

}
