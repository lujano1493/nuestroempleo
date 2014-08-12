<?php

class CFDI {
  public static function create($type, $data, $emisor) {
    $className = 'CFDI' . $type;

    App::uses($className, 'Lib/CFDI/Templates');
    if (!class_exists($className)) {
      throw new CakeException(__d('cake_dev', 'CFDI class "%s" was not found.', $className));
    }

    return (new $className())
      ->init()
      ->generate($data, $emisor);
  }
}