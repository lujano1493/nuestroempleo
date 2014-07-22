<?php 
class AreaInt extends AppModel {
	public $name='AreaInt';
	public $useTable = 'tareas'; 
	public $primaryKey="area_cve";
	public $displayField ="area_nom";

  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array();







public function lista(){

    return $this->find("list",array (
                'order'=> "cespe_nom asc"
                )  );

}






}