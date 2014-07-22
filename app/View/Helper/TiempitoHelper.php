<?php
/**
  *
  */
App::uses('TimeHelper', 'View/Helper');

/**
 *
 */
class TiempitoHelper extends TimeHelper {
  public function month($date = null, $printYear = true) {
    return $this->_engine->month($date, $printYear);
  }

  public function rango($startDate, $endDate, $type = 'months') {
    return $this->_engine->rango($startDate, $endDate, $type);
  }

  public function pretty($date = null) {
    return $this->_engine->pretty($date);
  }

  /**
   * Formato por default para fechas.
   * @return [type] [description]
   */
  public function d($date = null) {
    return $this->_engine->d($date);
  }

  /**
   * Formato por default para fechas y horas.
   * @return [type] [description]
   */
  public function dt($date = null) {
    return $this->_engine->dt($date);
  }

  public function isPast($dateString, $timezone = null) {
    return $this->_engine->isPast($dateString, $timezone);
  }
}
