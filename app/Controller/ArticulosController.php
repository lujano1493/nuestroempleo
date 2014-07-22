<?php

App::import('controller', 'BaseCandidato');
class ArticulosController extends BaseCandidatoController {
	
	public $name="Articulos";
  public $uses=array("WPPost");

	function index(){
		
	}


	public function destacados($id=null){



		  $articulo =   $this->WPPost->articulos_detalles($id);
		  $title_layout=$articulo['title'];
		  $description_layout=$articulo['content_text'];
		  $this->set(compact('articulo','title_layout','description_layout'));

	}
	
	

  public function beforeFilter() {
    parent::beforeFilter();

    /**
      * Acciones que no necesitan autenticación.
      */
    $this->Auth->allow();
  }
	

}