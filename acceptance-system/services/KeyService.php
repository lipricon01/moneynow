<?php


namespace app\services;


class KeyService
{
    //bad
    const KEY = 'c652406c3648f12f5f6df77c82b6d97dTAinT3D';

    public function checkKey(string $key)
    {
        if ($key === self::KEY) {
            return true;
        }

        return false;
    }
}