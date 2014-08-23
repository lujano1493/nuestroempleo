<?php

class X509Cert {
  public $publicKey = null;

  public $privateKey = null;

  public $password = null;

  public function __construct($publicKey, $privateKey, $password = null) {
    $this->publicKey = $publicKey;

    $this->privateKey = $privateKey;

    $this->password = $password;
  }

  /**
   * Obtiene el certificado completo (llave pública) en base 64.
   * @param  [type] $publicKey [description]
   * @return [type]            [description]
   */
  public function certificado($publicKey = null) {
    if (!$publicKey) {
      $publicKey = $this->publicKey;
    }

    $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($publicKey)));

    return $certificado;
  }

  /**
   * Cifra el string
   * @param  [type] $string     [description]
   * @param  [type] $privateKey [description]
   * @param  [type] $password   [description]
   * @return [type]             [description]
   */
  public function sello($string, $privateKey = null, $password = null) {
    $signature = '';

    if (!$password) {
      $password = $this->password;
    }

    $private = openssl_pkey_get_private($this->getPrivateKey($privateKey, true), $password);

    openssl_sign($string, $signature, $private);
    $sello = base64_encode($signature);

    return $sello;
  }

  public function getPrivateKey($privateKey = null, $complete = false) {
    if (!$privateKey) {
      $privateKey = $this->privateKey;
    }

    $content = file_get_contents($privateKey);

    return $complete ? $content :
      trim(preg_replace(array("/\n/", '/-----(END|BEGIN) PRIVATE KEY-----/'), array('', ''), $content));
  }

  private function hex2str($hex) {
    $str = '';
    $hex = preg_replace('/\s+/', '', $hex);
    for($i = 0; $i < strlen($hex); $i += 2) {
      $str .= chr(hexdec(substr($hex, $i, 2)));
    }

    return $str;
  }

  // private function str_baseconvert($str, $frombase = 10, $tobase = 16) {
  //   $str = trim($str);
  //   if (intval($frombase) != 10) {
  //     $len = strlen($str);
  //     $q = 0;
  //     for ($i=0; $i<$len; $i++) {
  //       $r = base_convert($str[$i], $frombase, 10);
  //       $q = bcadd(bcmul($q, $frombase), $r);
  //     }
  //   } else {
  //     $q = $str;
  //   }

  //   if (intval($tobase) != 10) {
  //     $s = '';
  //     while (bccomp($q, '0', 0) > 0) {
  //       $r = intval(bcmod($q, $tobase));
  //       $s = base_convert($r, 10, $tobase) . $s;
  //       $q = bcdiv($q, $tobase, 0);
  //     }
  //   } else {
  //     $s = $q;
  //   }
  //   return $s;
  // }

  // private function gmp_convert($num, $base_a = 10, $base_b = 16) {
  //   return gmp_strval(gmp_init($num, $base_a), $base_b);
  // }
}