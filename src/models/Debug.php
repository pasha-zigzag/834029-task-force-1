<?php


namespace taskforce\models;


class Debug
{
    public static function dd($data, $die = 1)
    {
        echo '<pre>'.print_r($data, 1).'</pre>';
        if($die) die;
    }
}