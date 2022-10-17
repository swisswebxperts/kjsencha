<?php

namespace KJSencha\Util;

class DeveloperDebug
{
    public static function dd($variable){
        echo '<pre>';
        die(var_dump($variable));
        echo '</pre>';
    }
}