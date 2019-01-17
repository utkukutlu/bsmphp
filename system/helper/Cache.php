<?php
/**
 * User: Utku
 * Date: 14.09.2017
 * Time: 22:57
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


use System\Core\Router;

class Cache {

    function init($url, $time = 10) {
        if (CACHE) {
            $cacheFile = "./Public/cache/" . md5($_SERVER['REQUEST_URI']) . ".html";
            if (file_exists($cacheFile) && (time() - $time < filemtime($cacheFile))) {
                include_once "$cacheFile";
                exit;
            } else {
                ob_start();
                new Router($url);
                $ch = fopen($cacheFile, 'w+');
                fwrite($ch, ob_get_contents());
                fclose($ch);
                ob_end_flush();
            }
        }
    }

    function clear() {
        $dir = PUBLIC_DIR . '/cache/';
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (!is_dir($file)) {
                        $file = $dir . $file;
                        unlink($file);
                    }
                }
                closedir($dh);
            }
        }
    }

}
