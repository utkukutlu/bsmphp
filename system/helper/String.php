<?php
/**
 * User: utku
 * Date: 14.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class String {
    public static function upper($string) {
        return strtoupper($string);
    }

    public static function lower($string) {
        return strtolower($string);
    }

    public static function firstup($string) {
        return ucfirst($string);
    }

    public static function capitalize($string) {
        return ucwords($string);
    }

    public static function replace($string, $bef, $af) {
        return str_replace($bef, $af, $string);
    }

    public static function shorten($string, $length = 50) {
        return mb_substr($string, 0, $length, "UTF-8");
    }

    public static function stripslashes($string) {
        return stripslashes($string);
    }

}