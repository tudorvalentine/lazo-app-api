<?php
require __DIR__ . '/const.php';

function crypt_tool($string_to_crypt)
{
    global $openssl_key;
    global $ciphering;
    global $options;
    global $iv_crypt;

    return openssl_encrypt(
        $string_to_crypt,
        $ciphering,
        $openssl_key,
        $options,
        $iv_crypt
    );
}

function decrypt_tool($string_to_decrypt)
{
    global $openssl_key;
    global $ciphering;
    global $options;
    global $iv_crypt;

    return openssl_decrypt(
        $string_to_decrypt,
        $ciphering,
        $openssl_key,
        $options,
        $iv_crypt
    );
}
