<?php
/**
 * User: utku
 * Date: 21.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Curl {
    public $get;

    public $response = false;

    public function __construct($url, array $options = array()) {
        $this->get = curl_init($url);

        foreach ($options as $key => $val) {
            curl_setopt($this->get, $key, $val);
        }

        curl_setopt($this->get, CURLOPT_RETURNTRANSFER, true);
    }

    public function getResponse() {
        if ($this->response) {
            return $this->response;
        }

        $response = curl_exec($this->get);
        $error = curl_error($this->get);
        $errno = curl_errno($this->get);

        if (is_resource($this->get)) {
            curl_close($this->get);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $this->response = $response;
    }

    public function __toString() {
        return $this->getResponse();
    }


    public function getInfo() {
        return curl_getinfo($this->get, CURLINFO_HTTP_CODE);
    }
}