<?php
/**
  *
  */
App::uses('AppHelper', 'View/Helper');

/**
 * Helper para la creación de JSON para amchart.
 */
class GrafitoHelper extends AppHelper {

  /**
   * Helpers
   * @var array
   */
  public $helpers = array('Html', 'Session');

  /**
   * Opciones por default.
   * @var array
   */
  protected $defaults = array(
    'export' => true
  );

  protected $colors = array(
    '#FF6600',
    '#0099FF',
  );

  public function color() {
    return $this->colors[0];
  }

  /**
   * Gráfica tipo serial.
   * @param  array  $data       Datos.
   * @param  array  $options    Opciones
   * @param  array  $rawOptions Opciones específicas.
   * @return array              Array de opciones.
   */
  public function serial($data, $options = array(), $rawOptions = array()) {
    $serialOptions = $this->_serialOptions($options);
    $commonOptions = $this->_getOptions($data, $options);

    return array_merge($serialOptions, $commonOptions, $rawOptions);
  }

  /**
   * Gráfica tipo pie.
   * @param  array  $data       Datos.
   * @param  array  $options    Opciones
   * @param  array  $rawOptions Opciones específicas.
   * @return array              Array de opciones.
   */
  public function pie($data, $options = array(), $rawOptions = array()) {
    $pieOptions = $this->_pieOptions($options);
    $commonOptions = $this->_getOptions($data, $options);

    return array_merge($pieOptions, $commonOptions, $rawOptions);
  }

  /**
   * Genera las opciones para las gráficas tipo serial.
   * @param  [type] $options [description]
   * @return [type]          [description]
   */
  private function _serialOptions($options) {
    $opts = array(
      'type' => 'serial',
    );

    return $opts;
  }

  /**
   * Genera las opciones para las gráficas tipo serial.
   * @param  [type] $options [description]
   * @return [type]          [description]
   */
  private function _pieOptions($options) {
    $opts = array(
      'type' => 'pie',
    );

    if (!empty($options['ballon'])) {
      $opts['ballonText'] = $options['ballon'];
    }

    return $opts;
  }

  /**
   * Opciones comunes entre gráficas.
   * @param  [type] $data    [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  protected function _getOptions($data, $options = array()) {
    $opts = array(
      'angle' => 20,
      'dataProvider' => $data,
      'depth3D' => 10,
      'startEffect'=> 'elastic',
      'startDuration' => 1,
    );

    $options = array_merge($this->defaults, $options);

    if (!empty($options['export'])) {
      $opts['exportConfig'] = $this->_export();
    }

    if (!empty($options['legend'])) {
      $opts['legend'] = array(
        'position' => $options['legend'],
        'markerType' => 'circle'
      );
    }

    if (!empty($options['title'])) {
      $opts['titles'] = $this->_setTitles($options['title']);
    }

    return $opts;
  }

  protected function _setTitles($titles) {
    $formattedTitles = array();

    if (!is_array($titles)) {
      $titles = (array)$titles;
    }

    foreach ($titles as $key => $value) {
      $formattedTitles[] = array(
        'text' => $value,
        'size' => 18 - $key,
        'color' => '#000000',
        'alpha' => 20,
        'bold' => true
      );
    }

    return $formattedTitles;
  }

  /**
   * Configuración para la exportación.
   * @return [type] [description]
   */
  protected function _export() {
    // 'exportConfig'
    return array(
      'menuTop' => '21px',
      'menuBottom' => 'auto',
      'menuRight' => '21px',
      'backgroundColor' => '#efefef',
      'menuItemStyle' => array(
        'backgroundColor' => '#EFEFEF',
        'rollOverBackgroundColor' => '#DDDDDD'
      ),
      'menuItems'=> array(
        array(
          'textAlign'=> 'center',
          'icon' => 'http://www.amcharts.com/lib/3/images/export.png',
          'title' => __('Exportar'),
          'items' => array(
            array(
              'title' => 'JPG',
              'format' => 'jpg'
            ), array(
              'title' => 'PNG',
              'format' => 'png'
            ), array(
              'title' => 'SVG',
              'format' => 'svg'
            )
          )
        )
      )
    );
  }
}
