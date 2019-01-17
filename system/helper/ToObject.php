<?php
/**
 * User: utku
 * Date: 15.12.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class ToObject {

    public static function convert($arr) {
        if (is_array($arr)) {
            $arr = (object)$arr;
            $arr = json_encode($arr);
            $arr = json_decode($arr);
        } else {
            $arr = iterator_to_array($arr);
            $arr = SetObj2Array::convert($arr);
            $arr = (object)$arr;
//        $arr = $this->SetArray2Obj($arr);
            $arr = json_encode($arr);
            $arr = json_decode($arr);
        }
        return $arr;
    }

}