<?php
/**
 * User: utku
 * Date: 15.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Mongo {
    public $db;

    public function __construct($host, $port, $dbname, $username, $password) {
        $database = [
            'host' => $host,
            'port' => $port,
            'user' => $username,
            'psw' => $password,
            'db' => $dbname
        ];
        $connect = "mongodb://{$database['user']}:{$database['psw']}@{$database['host']}:{$database['port']}/{$database['db']}";
        try {
            $mongo = new \MongoClient($connect, array("socketTimeoutMS" => "10000"));;
            $db = $mongo->selectDB($database['db']);
        } catch (MongoConnectionException $e) {
            die('Mongo Bağlantı kurulumunda sorun ile karşılaşıldı: ' . $e->getMessage());
        }
        $this->db = $db;
    }
}