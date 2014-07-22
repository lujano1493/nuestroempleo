<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Usuario', 'Utility');

/**
  * Helper personalizado para los inputs de nuestro empleo.
  */
class DenunciaHelper extends AppHelper {
  public $helpers = array(
    'Time' => array('className' => 'Tiempito', 'engine' => 'Tiempito'),
  );
/**
 * funcion para generar formato json de las denuncias realizadas
 * @param  array  $denuncias contiene la relacion de ofertas y candidatos denunciados
 * @return [type]            regresa un arreglo con el formato json de cada denuncia
 */
  public function formatToJson($denuncias=array()) {
    $_options=array("candidatos"=>array(),"ofertas" => array());
    $denuncias=array_merge($_options,$denuncias);
    extract($denuncias);
    $results = array();
    $statuses = array(
      'Reportado',
      'En Revisión',
      'Aceptado',
      'Declinado'
    );

  foreach ($candidatos as $k => $_d) {
    $d = $_d['Denuncia'];
    $u = $_d['Denunciado'];
    $denunciantes=array();
    $status=0;
    $created=null;
    foreach ($d as $_k => $__d) {
      $usu=$__d['Usuario'];
      $status=(int)$__d['status_cve'];
      $created=$__d['created'];
      $telefono= !empty($usu['tel']) ? __('%s ext: %s', $usu['tel'], $usu['tel_ext'] ?: 'N/D')  : 'N/D';
      $denunciantes[]=array(
        'motivo' => array(
            'value' => (int)$__d['motivo_cve'],
            'text' => $__d['motivo']
          ),
          'detalles' => $__d['detalles'] ?: __('Sin detalles'),        
          'created' => array(
            'str' => $this->Time->dt($__d['created']),
            'val' => $__d['created']
          ),            
        "nombre" => $usu['nombre'],
        "correo" => $usu['correo'],
        "telefono" => $telefono
      );    
    }
    $id = (int)$u['id'];
    $denuncia = array(
      'tipo' => array(
        'val' => 'cv',
        'str' => 'Candidato',
      ),
      'id' => $id,
      'nombre' => $u['nombre'],
      'tipo' => array(
        'val' => 'cv',
        'str' => 'Candidato',
      ),
      'denunciante' => $denunciantes,
      'slug' => Inflector::slug('perfil', '-') . '-' .$id,    
      'status' => array(
        'val' => $status,
        'text' => $statuses[$status]
      ),
      'denunciado' => $u['denunciado'],
      'created' => array(
        'str' => $this->Time->dt($created),
        'val' => $created
      )
    );
    $results[] = $denuncia;
  }

  foreach ($ofertas as $k => $_d) {
    $d = $_d['Denunciado'];
    $u= $_d['Denuncia'];
    $id = (int)$d['id'];
    $denunciantes=array();
    $status=0;
    $created=null;
    foreach ($u as $_k => $__d) {
      $usu=$__d['Usuario'];
      $status=(int)$__d['status_cve'];
      $created=$__d['created'];
      $denunciantes[]=array(
        'motivo' => array(
            'value' => (int)$__d['causa_cve'],
            'text' => $__d['motivo']
          ),
          'detalles' => $__d['detalles'] ?: __('Sin detalles'),        
          'created' => array(
            'str' => $this->Time->dt($__d['created']),
            'val' => $__d['created']
          ),            
        "nombre" => $usu['nombre'],
        "correo" => $usu['correo'],
        "telefono" => __(  $usu['telefono'] ?: 'N/D')
      );    
    }
    $denuncia = array(
      'id' => $id,
      'nombre' => $d['nombre'],
      'tipo' => array(
        'val' => 'oferta',
        'str' => 'Oferta'
      ),
      'denunciante' =>$denunciantes,
      'slug' => Inflector::slug($d['nombre'] . '-' . $d['id'], '-'),     
      'status' => array(
        'val' => (int)$status,
        'text' => $statuses[(int)$status]
      ),
      'denunciado' => $d['denunciado'],
      'created' => array(
        'str' => $this->Time->dt($created),
        'val' => $created
      )
    );

    $results[] = $denuncia;
  }
    
    return $results;
  }

}
