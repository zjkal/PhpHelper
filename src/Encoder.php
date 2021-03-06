<?php

namespace AlHepler;

/**
 * AL加密类(对称的字符串加密)
 * Class Encoder
 * @package AlHepler
 */
class Encoder
{

    /**
     * 加密
     * @param string $data 要加密的字符串
     * @param string $key 秘钥
     * @return string 加密后的字符串
     */
    public static function encode($data, $key = 'ykmaiz')
    {
        $data = strval($data);
        $key = strval($key);

        $a = array('l', 'i', 'a', 'n', 'g', 'x', 'f', 'e');
        $key = md5($key);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        $base64_str = base64_encode($str);
        $count = substr_count($base64_str, '=');
        $ret = $a[$count] . rtrim(str_replace('/', '_', str_replace('+', '-', $base64_str)), '=');
        return $ret;
    }

    /**
     * 解密
     * @param string $data 待解密的字符串
     * @param string $key 秘钥
     * @return string 解密后的字符串
     */
    public static function decode($data, $key = 'ykmaiz')
    {
        $data = strval($data);

        $a = array('l', 'i', 'a', 'n', 'g', 'x', 'f', 'e');

        $str2 = substr(str_replace('-', '+', str_replace('_', '/', $data)), 1);
        $count = substr($data, 0, 1);
        $fill = '';
        for ($i = 0; $i < array_search($count, $a); $i++) {
            $fill .= $fill . '=';
        }

        $key = md5($key);
        $x = 0;
        $data = base64_decode($str2 . $fill);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }

        return $str;
    }

}