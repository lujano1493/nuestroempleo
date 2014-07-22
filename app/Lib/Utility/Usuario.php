<?php

class Usuario {
  public static function getPhotoPath($id, $type = 'candidato') {
    if ($type === 'candidato' || $type === 'c') {
      $defaultImgPath = '/img/candidatos/default.jpg';
      $imgPath = '/documentos/candidatos/' . $id . '/foto.jpg';
    } else {
      $defaultImgPath = '/img/no-logo.jpg';
      $imgPath = '/documentos/empresas/' . $id . '/logo.jpg';
    }

    if (file_exists(WWW_ROOT . $imgPath)) {
      return $imgPath;
    }

    return $defaultImgPath;
  }
}