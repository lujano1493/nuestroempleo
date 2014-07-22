<?php

App::uses('AppModel', 'Model');

class EtiquetasOferta extends AppModel {
  public $name = 'EtiquetasOferta';
  
  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'etiquetaxoferta_cve';


  public $useTable = 'tetiquetasxofertas';
  
}