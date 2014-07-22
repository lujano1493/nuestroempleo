<?php

App::uses('RedisEngine', 'Cache/Engine');

/**
 * Redis storage engine for cache.
 *
 * @package       Cake.Cache.Engine
 */
class RedisJSONEngine extends RedisEngine {

  /**
   * Write data for key into cache.
   *
   * @param string $key Identifier for the data
   * @param mixed $value Data to be cached
   * @param integer $duration How long to cache the data, in seconds
   * @return boolean True if the data was successfully cached, false on failure
   */
  public function write($key, $value, $duration) {
    if ($duration === 0) {
      return $this->_Redis->set($key, $value);
    }

    return $this->_Redis->setex($key, $duration, $value);
  }

  /**
   * Read a key from the cache
   *
   * @param string $key Identifier for the data
   * @return mixed The cached data, or false if the data doesn't exist, has expired, or if there was an error fetching it
   */
  public function read($key) {
    $value = $this->_Redis->get($key);
    if (ctype_digit($value)) {
      $value = (int)$value;
    }
    return $value;
  }
}
