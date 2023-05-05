<?php

class encrypt_money {
    static $_encrypt_method = "AES-256-CBC";
    static $_secret_key = 'SSO_MONEY';
    static $_secret_iv = '21032566';
  
    static function encode($string) {
      $output = false;
      $key = hash('sha256', self::$_secret_key);
      // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
      $iv = substr(hash('sha256', self::$_secret_iv), 0, 16);
      $output = openssl_encrypt($string, self::$_encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
      return $output;
    }
    
    static function decode($string) {
      $output = false;
      $key = hash('sha256', self::$_secret_key);
      // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
      $iv = substr(hash('sha256', self::$_secret_iv), 0, 16);
      $output = openssl_decrypt(base64_decode($string), self::$_encrypt_method, $key, 0, $iv);
      return $output;
    }
  
  }
