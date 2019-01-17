<?php
/**
 * User: utku
 * Date: 14.09.2017
 * Web : http://www.utkukutlu.com
 */

function load($dir) {

    $namespaces = array(
        'app\\' => 'app',
        'system\\' => 'system',
    );

    foreach ($namespaces as $namespace => $classpaths) {
        if (!is_array($classpaths)) {
            $classpaths = array($classpaths);
        }
        spl_autoload_register(function ($classname) use ($namespace, $classpaths, $dir) {
            if (preg_match("#^" . preg_quote($namespace) . "#", $classname)) {
                $classname = str_replace($namespace, "", $classname);
                $filename = preg_replace("#\\\\#", "/", $classname) . ".php";
                foreach ($classpaths as $classpath) {
                    $fullpath = $dir . "/" . $classpath . "/$filename";
                    if (file_exists($fullpath)) {
                        include_once $fullpath;
                    }
                }
            }
        });
    }
}

load(__DIR__);

