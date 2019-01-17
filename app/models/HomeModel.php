<?php
/**
 * User: utku
 * Date: 03.01.2019
 * Web : http://www.utkukutlu.com
 */

namespace app\model;


use system\core\BaseModel;

class HomeModel extends BaseModel {

    private $db;

    public function __construct() {
        $this->db = $this->mysql();
    }

}