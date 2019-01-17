<?php
/**
 * User: utku
 * Date: 10.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\core;

class Router {

    private $url;
    private $error404 = true;

    public function __construct($url) {
        $this->url = $url;
        $this->run();
    }

    private function run() {
        $classArr = explode('/', $this->url);
        $f = ROOT_DIR . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers';
        foreach ($classArr AS $c) {
            $f .= '/' . $c;
            $rFileName = $this->fileExists($f . '.php');

            if (file_exists($rFileName)) {

                $this->error404 = false;

                $className = str_replace(ROOT_DIR, '', $rFileName);

                $fun = str_replace(ROOT_DIR, '', $f);
                $fun = preg_replace('/^\/app\/controllers/si', '', $fun);
                $fun = trim($fun, '/');
                $fun = str_replace($fun, '', $this->url);
                $fun = trim($fun, '/');
                $fun = explode('/', $fun);

                $className = str_replace('/', '\\', $className);
                $className = str_replace('.php', '', $className);
                $className = trim($className, '\\');

                $annotations = $this->getAnnotations($className, $fun[0]);


                $allowAll = false;
                $requestMethod = false;

                if ($this->in_array_key('allowAll', $annotations) != -1 && $this->get_array_value('allowAll', 'true', $annotations)) {
                    $allowAll = true;
                }

                if ($this->in_array_key('method', $annotations) != -1 && $this->get_array_value('method', $_SERVER['REQUEST_METHOD'], $annotations)) {
                    $requestMethod = true;
                }

                if (!$allowAll && !$requestMethod) {
                    $this->error404();
                    die();
                }

                call_user_func_array(array(new $className, $fun[0]), array_slice($fun, 1));
                exit();

            }


        }
        if ($this->error404) {
            $this->error404();
        }
    }

    private function get_array_value($key, $value, $arr) {

        if ($this->in_array_key($key, $arr) == -1) {
            return false;
        }

        if (strtolower($arr[$this->in_array_key($key, $arr)]['value']) == strtolower($value)) {
            return true;
        }
        return false;
    }

    private function in_array_key($val, $arr) {
        foreach ($arr AS $index => $item) {
            if (strtolower($item['key']) == strtolower($val)) {
                return $index;
            }
        }
        return -1;
    }

    protected function error404() {
        die('404');
    }

    private function fileExists($fileName, $caseSensitive = false) {

        if (file_exists($fileName)) {
            return $fileName;
        }
        if ($caseSensitive) return false;

        $directoryName = dirname($fileName);
        $fileArray = glob($directoryName . '/*', GLOB_NOSORT);
        $fileNameLowerCase = strtolower($fileName);
        foreach ($fileArray as $file) {
            if (strtolower($file) == $fileNameLowerCase) {
                return $file;
            }
        }
        return false;
    }

    private function getAnnotations($class, $method = '') {
        if ($class == '') {
            echo 'class empty';
            return false;
        }
        $rc = new \ReflectionClass($class);
        if ($method != '') {
            $dc = $rc->getMethod($method)->getDocComment();
        } else {
            $dc = $rc->getDocComment();
        }

        preg_match_all('#@(.*?)\n#s', $dc, $annons);
        $annotations = array();
        foreach ($annons[1] AS $annotation) {
            preg_replace_callback('/^\s*(\w+)\s+(.*?)$/si', function ($match) use (&$annotations) {
                $annotations[] = array(
                    'key' => $match[1],
                    'value' => $match[2]
                );
            }, $annotation);
        }
        if (is_array($annotations) && count($annotations) > 0) {
            return $annotations;
        } else {
            return array();
        }
    }

}