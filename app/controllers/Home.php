<?php
/**
 * User: utku
 * Date: 03.01.2019
 * Web : http://www.utkukutlu.com
 */


namespace app\controllers;

use system\core\BaseController;

class Home extends BaseController {

    /**
     * @method GET
     */
    function index() {
        $this->view('home', 'template/temp1');
    }

    /**
     * @method POST
     */
    function test() {
        echo 'post';
    }


}