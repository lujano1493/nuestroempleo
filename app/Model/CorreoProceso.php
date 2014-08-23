<?php 
class CorreoProceso extends AppModel {
	public $name='CorreoProceso';
	public $useTable = 'tcorreoscandidato'; 
	public $primaryKey='correo_cve';	

  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array();

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
  }


  public function getIdProceso(){
     $rs= $this->find("first",array(
      "fields" => array("(nvl(max(proceso_cve),0)+1) {$this->alias}__proceso")
      )
     );
    return  empty($rs) ? false: $rs[$this->alias]['proceso'];
  }




}