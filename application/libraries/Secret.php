<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Secret{
    const SecretAESKey  = 'port_12345_qoskdmcnzogwo10fj3-ak';

    // AES 암호화
    function aes_encrypt($string){
        $key = self::SecretAESKey;

        $secret_solt    = substr($key, 0, 20);
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $key);
        $iv = substr(hash('sha256', $secret_solt), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, true, $iv);
        return base64_encode($output);
    }

    // AES 복호화
    function aes_decrypt($string){
        $key = self::SecretAESKey;

        $secret_solt    = substr($key, 0, 20);
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $key);
        $iv = substr(hash('sha256', $secret_solt), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, true, $iv);
        return $output;
    }
}