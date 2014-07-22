<?php

App::uses('AppHelper', 'View/Helper');
App::import("Vendor",array( "funciones" ));
/**
  * Helper para obtner el formato en ofertas buscadas.
  */
 class OfertasBHelper extends AppHelper {
  public $helpers = array('Html'=> array('className' =>"Htmlito" ));
  public function formatToJson($data, $options = array()) {
      $results=array();

      if($data['data'] ===false){
          return $results;
      }      
       foreach ($data['data'] as $k => $v) {          
          $cia_cve=$v['OfertaB']['cia_cve'];
          $ruta_img=Funciones::check_image_cia($cia_cve);
          $bene_arr= array();//Oferta::prestaciones_str($v['OfertaB']['oferta_prestaciones']);
          $str_bene=Funciones::lista_str($bene_arr);
          $status=$v['OfertaB']['oferta_status'];
          $oferta = array(
            'id' =>$v['OfertaB']['oferta_cve'],
            "puesto" => $v['OfertaB']['puesto_nom'],
            'empresa'=> $v['OfertaB']['cia_nom'],
            'ciudad' => $v['OfertaB']['ciudad_nom'],
            'estado' => $v['OfertaB']['est_nom'],
            'sueldo' => $v['OfertaB']['oferta_sueldo'],
            'fecha' =>  $this->Html->formato_fecha_publicacion_code($v['OfertaB']['publicacion']) ,
            'resumen' =>  Funciones::truncate_str($v['OfertaB']['oferta_resumen'],200) ,
            'has_bene' => !empty($bene_arr),
            'class_extra' =>  ($status == 1 ? '': ( $status==2 ?'tabla_destacadas' :  'destacadas_ofertas_perfil'   )  ),
            'recomendada' =>  ($status ==2),
            'distinguida' => ( $status ==3),
            'privada'  =>  ($v['OfertaB']['oferta_privada'] == 1 ),
            'beneficios' => $str_bene,
            'src' => $ruta_img
          );

          $results[] = $oferta;
        }

        return $results;

  }
}
