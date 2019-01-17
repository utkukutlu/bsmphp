<?php
/**
 * User: utku
 * Date: 10.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\core;

use system\helper\Mysql;

class BaseModel {
    private $mysql;

    protected function mysql() {
        return $this->mysql = new Mysql(MYSQL_HOST, MYSQL_DB, MYSQL_USER, MYSQL_PASS);
    }
}