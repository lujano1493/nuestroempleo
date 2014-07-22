<?php 
class categoria extends AppModel {
	public $name='categoria';
	public $useTable = 'tcategorias'; 
	public $primaryKey="categoria_cve";
	public $displayField ="categoria_nom";

  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array();
public function lista(){

    return $this->find("list",array (
                'order'=> "categoria_nom asc"
                )  );

}






}