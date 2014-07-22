<?php

App::uses('Hash', 'Utility');

class Utils {
  public static function toJSONIntArray(array $data, $path = '{n}.id') {
    return json_encode(
      array_map('intval', Hash::extract($data, $path))
    );
  }

  public static function toJSONArray(array $data, $path = '{n}.id') {
    return json_encode(Hash::extract($data, $path));
  }

  public static function toJSONObjectArray(array $data, array $paths) {
    $results = array();
    $array = array();
    foreach ($paths as $key => $value) {
      $results[] = self::convertToNamedArray(Hash::extract($data, $value), $key);
    }

    foreach ($results as $key => $value) {
      foreach ($value as $k => $v) {
        if (empty($array[$k])) {
          $array[$k] = array();
        }
        $array[$k] = array_merge($array[$k], $v);
      } 
    }

    return json_encode($array);
  }

  private static function convertToNamedArray(array $data, $name = null) {
    $array = array();
    foreach ($data as $key) {
      $array[] = array(
        $name => $key
      );
    }

    return $array;
  }
}