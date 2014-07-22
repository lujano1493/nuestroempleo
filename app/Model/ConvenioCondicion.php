<?php

App::uses('AppModel', 'Model');

class ConvenioCondicion extends AppModel {

  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * tabla
   * @var string
   */
  public $useTable = 'tconveniocondiciones';

  /**
   * Llave primaria
   * @var string
   */
  public $primaryKey = 'conveniocondicion_cve';
}