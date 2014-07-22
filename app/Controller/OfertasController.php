<?php

App::uses('AppController', 'Controller');

class OfertasController extends AppController {

	public $name = 'Ofertas';

	public $components = array('Acceso');

	public function beforeFilter() {
		parent::beforeFilter();

	  $allowActions = array('ver');
	  $this->Auth->allow($allowActions);
	}

	public function ver($id = null) {
		$userRole = $this->Acceso->is();
		$redirect = '/';

		if ($userRole === 'candidato') {
			$redirect = 'PostulacionesCan/index';
		} elseif ($userRole === 'empresa') {
			$redirect = array(
				'controller' => 'mis_ofertas',
				'action' => 'index'
			);
		}

		if ($id == null) {
			$this->error('No es posible realizar acción.');
			$this->redirect($redirect);
			return;
		}

		$tipo= $this->Acceso->is();
		 $denuncia_previa=true;
		 $denuncia_=ClassRegistry::init("Reportar");
		 if($tipo!=='guest'){
		 	$idUser=$tipo==='candidato' ? $this->Auth->user('candidato_cve'):$this->Auth->user('cu_cve');
		 	$denuncia_previa =   $denuncia_->verifica_status($id,$idUser);			
		 	$num=$denuncia_->numeroDenuncias($id);
             if($num > 0){
                    $this->warning(__("Esta oferta fue denunciada."));
             }
		 }
		
		$this->loadModel('Oferta');
		$oferta = $this->Oferta->find('oferta', array(
			'idOferta' => $id
		));
		
		// $param_query=array();
		// $conditions=array();
		$title_layout=$oferta['Oferta']['puesto_nom'];
        $description_layout=$oferta['Oferta']['oferta_resumen'];
		$this->set(compact('oferta','title_layout','description_layout','denuncia_previa'));

		if ($userRole === 'empresa' || $userRole=='admin') {
      $this->render('/MisOfertas/ver');
    } else {
      $this->render('/PostulacionesCan/oferta_detalles');
    }
	}

}