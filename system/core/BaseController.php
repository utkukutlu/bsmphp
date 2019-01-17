<?php
/**
 * User: utku
 * Date: 10.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\core;


class BaseController {

    private $viewFile, $templateFile, $vars, $viewDirectory;

    public function __construct() {
        $this->viewDirectory = ROOT_DIR . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }


    protected function view($view, $template, $vars = array()) {

        $this->viewFile = $this->viewDirectory . $view . '.view.php';
        $this->templateFile = $this->viewDirectory . $template . '.view.php';
        $this->vars = $vars;

        if (file_exists($this->viewFile) && file_exists($this->templateFile)) {

            $viewContent = file_get_contents($this->viewFile);
            $templateContent = file_get_contents($this->templateFile);


            preg_match_all('/\{{\$(\w+)\}}/si', $viewContent, $matches);
            foreach ($matches[1] as $i => $match) {
                $viewContent = str_replace($matches[0][$i], $$match, $viewContent);
            }

            preg_match_all('/\{{\$(\w+)\}}/si', $templateContent, $matches);
            foreach ($matches[1] as $i => $match) {
                $templateContent = str_replace($matches[0][$i], $$match, $templateContent);
            }

            preg_match_all('/{section(.*?)}([\s\S]*?){\/section}/im', $viewContent, $regs);

            for ($i = 0; $i < count($regs[0]); $i++) {
                $secName = $regs[1][$i];
                $val = $regs[2][$i];
                preg_match_all('/{section' . $secName . '}/i', $templateContent, $matches);
                $templateContent = str_replace($matches[0][0], $val, $templateContent);

                $templateContent = str_replace($regs[0][$i], "", $templateContent);
            }


            preg_match_all('/\{{\$(\w+)\}}/si', $templateContent, $matches);
            foreach ($matches[1] as $i => $match) {
                $templateContent = str_replace($matches[0][$i], $$match, $templateContent);
            }
            preg_match_all('/\{{\$(\w+)\.(\w+)\}}/si', $templateContent, $matches);
            foreach ($matches[1] as $i => $match) {
                $key = $matches[2][$i];
                $dizi = $$match;
                $templateContent = str_replace($matches[0][$i], $dizi[$key], $templateContent);
            }

            eval('?>' . $templateContent);


        } else {
            echo 'error: view not found';
            trigger_error('view not found', E_USER_NOTICE);
            exit();
        }

    }

}