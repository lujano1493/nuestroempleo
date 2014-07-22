<?php

App::uses('CacheSession', 'Model/Datasource/Session');
App::uses('CakeSessionHandlerInterface', 'Model/Datasource/Session');

class RedisSession extends CacheSession implements CakeSessionHandlerInterface {
  public $cacheKey;

  protected function serialize($hash = array()) {
    $str = '';
    $hash = (array)$hash;
    foreach($hash as $key=>$value) {
      $str .= $key . '|' . serialize($value);
    }
    return $str;
  }

  protected function unserialize($str) {
    // The regex to get the keys
    $regex = '/([^;\}\|]+)\|/';

    // Get all the keys
    $matches = array();
    preg_match_all($regex, $str, $matches);
    $keys = $matches[1];

    // Split out all the serialized values
    $serialized_values = preg_split($regex, $str);

    // Unserialize all the values
    $values = array();
    foreach($serialized_values as $val) {
      if(!empty($val)) $values[] = unserialize($val);
    }

    return array_combine($keys, $values);
  }

  public function __construct() {
    $this->cacheKey = Configure::read('Session.handler.cache');
  }

  // read data from the session.
  public function read($id) {
    if($data = parent::read("sessions/$id")) {
      $results = json_decode($data, true);
      return $this->serialize($results);
    }

    return '';
  }

  /**
   * Write the session data, convert to json before storing
   * @param string $id The SESSID to save
   * @param string $data The data to store, already serialized by PHP
   * @return boolean True if memcached was able to write the session data
   */
  public function write($id, $data) {
    $data = $this->unserialize($data);
    $data['lastAccess'] = time();
    $data['cookie'] = array(
      'originalMaxAge' => session_cache_expire(), // * 60000,
      'expires' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', session_cache_expire() * 60 + time()),
      'httpOnly' => true,
      'path' => '/'
    );

    return parent::write("sessions/$id", json_encode($data));
  }

  // destroy a session.
  public function destroy($id) {
    return parent::destroy("sessions/$id");
  }

  // removes expired sessions.
  public function gc($expires = null) {
    return parent::gc($expires);
  }
}