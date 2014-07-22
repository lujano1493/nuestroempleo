<?php
App::import("Vendor","funciones");
class BaseCandidatoController extends AppController {
	public $name='BaseCandidato';

	 public function beforeFilter() {
		parent::beforeFilter();




		 $role = $this->Acceso->is();
		 $authUser=$this->user;
		  /**
		     * noficiaciones
		     */
		    
		  /*pra candidatos candidatos*/
	    if(!empty($this->user)){
	      if (!$this->Acceso->isPrimera($role, $this->action)) {
	        $this->info(__('Completa tu Perfil General para poder utilizar el Portal, los campos marcados con (*) son obligatorios.'));
	        $this->redirect(array(
	          'controller' => 'candidato',
	          'action' => 'primera'
	        ));
	      }
	    }

		if($role==='empresa' ){
			$this->redirect("/mi_espacio");
		}


	}


}

