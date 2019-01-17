<?php
/**
 * User: utku
 * Date: 21.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Lang {

    public static function getLang($lang = DEFAULT_LANG) {
        $file = fopen(LANG_DIR . "/langs.json", "r") or die("langs.json Dil Dosyası Bulunamadı");
        $content = fread($file, filesize(LANG_DIR . "/langs.json"));
        fclose($file);
        $content = json_decode($content);


        foreach ($content as $item) {
            if ($item->code == $lang) {
                $langFile = $item->file;
            }
        }


        $file = fopen(LANG_DIR . "/$langFile", "r") or die($langFile . " Dil Dosyası Bulunamadı");
        $langContent = fread($file, filesize(LANG_DIR . "/$langFile"));
        fclose($file);

        return json_decode($langContent)->lang;
    }

    public static function getLangInfo($lang = DEFAULT_LANG) {
        $file = fopen(LANG_DIR . "/langs.json", "r") or die("langs.json Dil Dosyası Bulunamadı");
        $content = fread($file, filesize(LANG_DIR . "/langs.json"));
        fclose($file);
        $content = json_decode($content);


        return $content->{$lang};
    }

    public static function getList() {
        $file = fopen(LANG_DIR . "/langs.json", "r") or die("langs.json Dil Dosyası Bulunamadı");
        $content = fread($file, filesize(LANG_DIR . "/langs.json"));
        fclose($file);
        $content = json_decode($content);


        return $content;
    }


}