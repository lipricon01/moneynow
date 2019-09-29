<?php
namespace app\helpers;

class KeyHelper
{
    public static function getKey()
    {
        $salt = 'TAinT3D';
        $password = 'raNKBanD4g3';

        return md5($password).$salt;
    }
}
