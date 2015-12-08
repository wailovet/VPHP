<?php
namespace V;

class Route
{
    public static function post($callback,$isExit = true)
    {
        if($_POST){
            $callback();
            if($isExit){
                exit;
            }
        }
    }
}