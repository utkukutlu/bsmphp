<?php
/**
 * User: utku
 * Date: 14.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Session {

    public static function init() {
        @session_start();
    }

    public static function set($key, $value) {

        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        if (isset($key)) {
            return @$_SESSION[$key];
        }
    }

    public static function destroy() {
        session_destroy();
    }

    public static function getAll() {
        return $_SESSION;
    }

    public static function isSupport() {
        return $_SERVER['REMOTE_ADDR'] === '';
    }

}