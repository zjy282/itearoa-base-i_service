<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 2018/11/25
 * Time: 下午6:59
 */


function hasCommonStr($a, $b){
    $start = ord("a");
    $end = ord("z");


    for($i = $start; $i <= $end; $i++){
        $needle = chr($i);
        if(strpos($a, $needle) !== false && strpos($a, $needle) !== false){
            var_dump($a, $$needle);
            return true;
        }
    }
    return false;
}


$result = hasCommonStr("hi", "bye");

var_dump($result);