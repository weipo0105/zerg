<?php
namespace app\api\service;

class Token
{
    public static function generateToken()
    {
        //32个字符组成蚁族随机字符串
        $randChars = getRandChar(32);

        //用三组字符串，进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }
}