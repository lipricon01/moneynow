<?php


namespace app\services;


use yii\web\UnauthorizedHttpException;

class KeyService
{
    private static $public_key = "
-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6
zxqlVzz0wy2j4kQVUC4ZRZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQ==
-----END PUBLIC KEY-----
";

    public function checkKey($signature, $data)
    {
        $ok = openssl_verify(json_encode($data), base64_decode($signature), self::$public_key, OPENSSL_ALGO_SHA1);

        if ($ok == 1) {
            return true;
        } elseif ($ok == 0) {
            throw new UnauthorizedHttpException('Wrong signature');
        } else {
            throw new \Exception("ошибка: ".openssl_error_string());
        }
    }
}