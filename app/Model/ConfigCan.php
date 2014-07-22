<?php 

App::import('Vendor','funciones');
class ConfigCan extends AppModel {
	public $name='ConfigCan';
	public $useTable = 'tconfigcan'; 
	public $primaryKey="configcan_cve";

	/*
		Configuracion de envio de correos automaticos
	 */
	 const OFERTAS=1;
	 const PUBLICIDAD=2;
	 const ARTICULOS=3;
	 const EVENTOS=4;
	 const MENSAJES_SMS=5;
	/**
	 * mentodos de contacto
	 */
	 const TELEFONO_FIJO=6;
	 const TELEFONO_MOVIL=7;
	 const CORREO=8;	

  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array(
/*  	"candidato_fecnac" => "to_char(Candidato.candidato_fecnac,'DD/MM/YYYY')" ,*/

  	);


	public function guardar_configuracion($id,$data){
		$this->begin();
		if(!$this->deleteAll(array('candidato_cve' => $id), false)) {	   
	    	  $this->rollback();
	    	  return array("error","No es posible guardar configuración.");   
	    }

	    if( array_key_exists("ConfigCan",$data)) {
	    	 $configcan=$data['ConfigCan'];

		    foreach ($configcan as $key => $value) {
		    	$data_save=$value;
		    	$data_save['candidato_cve']=$id;
		    	$this->create();
		    	if(!$this->save($data_save) ){
		    		 $this->rollback();
		    	  return array("error","No es posible ingresar configuración.",$this->validationErrors);   
		    	}
		    	
		    }
	    }

	  

	    $this->commit();
	    return array("ok","La nueva configuración fue guardada.");

	}


}

