<?php
/**
 * User: utku
 * Date: 14.09.2017
 * Web : http://www.utkukutlu.com
 */

define('BASE_DIR', '/');
define('ROOT_DIR', __DIR__);
define('APP_DIR', ROOT_DIR . '/app');
define('SYSTEM_DIR', ROOT_DIR . '/system');
define('PUBLIC_DIR', rtrim(BASE_DIR) . '/public');
define('UPLOAD_DIR', rtrim(ROOT_DIR) . '/public' . '/uploads');
define('LANG_DIR', APP_DIR . '/lang');
define('VERSION', '1.0b');


define('URL', 'http://localhost/'); // http://example.com | http://example.com/site
define('CACHE', false);
define('DEFAULT_LANG', 'tr');
define('ENVIRONMENT', 'development'); // production | development

define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "root");
define("MYSQL_PASS", "");
define("MYSQL_DB", "");

define('MONGO_HOST', '');
define('MONGO_PORT', '');
define('MONGO_USER', '');
define('MONGO_PASS', '');
define('MONGO_DB', '');