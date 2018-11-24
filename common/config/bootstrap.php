<?php
use Symfony\Component\VarDumper\VarDumper;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');




if (!function_exists('dd')) {
    function dd($var)
    {
        foreach (func_get_args() as $var) {
            VarDumper::dump($var);
        }
        exit;
    }
}