<?php
/**
 * User: utku
 * Date: 10.09.2017
 * Web : http://www.utkukutlu.com
 */

include_once 'config.php';
include_once 'autoload.php';

if (ENVIRONMENT == 'development') {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

$url = trim(@$_GET["url"], "/");

new \system\core\Router($url);
