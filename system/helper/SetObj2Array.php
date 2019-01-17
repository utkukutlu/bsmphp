<?php
/**
 * User: utku
 * Date: 15.12.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class SetObj2Array {

    public static function convert($obj) {
        $o = array();
        $i = 0;
        foreach ($obj as $ob) {
            foreach ($ob as $key => $val) {
                $o[$i][$key] = $val;
            }
            $i++;
        }
        return $o;
    }

}