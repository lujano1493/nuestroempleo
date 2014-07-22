<?php
/**
  *
  */
App::uses('CakeTime', 'Utility');

/**
 *
 */
class Tiempito extends CakeTime {
  private static $defaultDateFormat = 'd/m/Y';
  private static $defaultDatetimeFormat = 'd/m/Y,  g:i a';

  public static function month($date = null, $printYear = true) {
    if (!$date) $date = time();

    if (is_numeric($date) && $date <= 12) {
      $year = is_numeric($printYear) ? $printYear : date('Y');
      $date = (new DateTime())->setDate($year, $date, 1);
    }

    return ucfirst(self::i18nFormat($date, '%B' . ($printYear ? ' %Y' : '')));
  }

  public static function rango($startDate, $endDate, $type = 'months') {
    $strStartDate = self::month($startDate);
    $strEndDate = $endDate ? self::month($endDate) : 'Actual';

    return $strStartDate . ' - ' . $strEndDate;
  }

  public static function pretty($date = null) {
    if (!$date) $date = time();

    return self::i18nFormat($date, '%#d de %B %Y');
  }

  /**
   * Formato por default para fechas.
   * @return [type] [description]
   */
  public static function d($date = null) {
    if (!$date) $date = time();

    return self::format(self::$defaultDateFormat, $date);
  }

  /**
   * Formato por default para fechas y horas.
   * @return [type] [description]
   */
  public static function dt($date = null) {
    if (!$date) $date = time();

    return self::format(self::$defaultDatetimeFormat, $date);
  }
}
