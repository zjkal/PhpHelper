<?php
/**
 * AL加密测试类
 */

require '../vendor/autoload.php';

$str = 'a test string';
$str2 = \AlHepler\Encoder::encode($str);
$str3 = \AlHepler\Encoder::decode($str2);
echo $str2 . PHP_EOL;
echo $str3 . PHP_EOL;