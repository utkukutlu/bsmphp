<?php
/**
 * User: utku
 * Date: 14.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Redirect {
    public static function go($url, $time = 0) {
        if ($time == 0) {
            header("Location: {$url} ");
        } else {
            header("Refresh: {$time} ;url={$url}");
        }
    }
}