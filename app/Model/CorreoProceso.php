<?php 
class CorreoProceso extends AppModel {
	public $name='CorreoProceso';
	public $useTable = 'tcorreoscandidato'; 
	public $primaryKey=null;	

  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array();

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
  }




}