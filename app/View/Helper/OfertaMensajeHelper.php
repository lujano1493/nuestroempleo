<?php
/**
  *
  */
App::uses('AppHelper', 'View/Helper');

/**
 *
 */
class OfertaMensajeHelper extends AppHelper {

  public $helpers = array(
    'Time' => array('className' => 'Tiempito', 'engine' => 'Tiempito'),
  );


  	public function formatToJson($data=array()){

  		$results= array();

  		foreach ($data as  $v) {

  			$msj=$v['Mensaje'];
  			$info=$v['MensajeOferta'];
        $cia_cve=$v['Oferta']['cia_cve'];
        $tipo =$msj['emisor_tipo'];
        $is_ = $tipo==0 ? 'e' :'c';
        $foto= $this->getPhotoPath( $tipo==0 ? $cia_cve :$msj['emisor_cve'], $tipo==0 ? 'empresa' :'candidato');
        $foto= $v['Oferta']['oferta_privada'] == 1 && $tipo==0   ? "/img/oferta/img_oferta_priv.jpg"  :$foto;
  			$fs=array(
  							"id" => $msj['msj_cve'],
  							"mensaje" => $msj['msj_texto'],
  							"es_pregunta" => $tipo == 1,
  							"superior" => $info['msj_cvesup'],
  							"fecha" => $this->Time->dt($msj['created']),
  							"date" => $msj['created'] ,
                'foto' => $foto
  				);


  			$results[]=$fs;

  		}
  		return $results;

  	}

  public function getPhotoPath($id, $tipo = 'c') {
    App::uses('Usuario', 'Utility');

    return Usuario::getPhotoPath($id, $tipo);
  }



}
