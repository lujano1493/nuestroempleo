<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Usuario', 'Utility');

/**
  * Helper personalizado para los inputs de nuestro empleo.
  */
class CandidatoHelper extends AppHelper {
  public $helpers = array(
    'Time' => array('className' => 'Tiempito', 'engine' => 'Tiempito'),
  );

  public function formatToJson($data, $options = array(), $mergeData = array()) {
    $results = array();
    $alias = isset($options['alias']) ? $options['alias'] : 'CandidatoEmpresa';

    foreach ($data as $key => $value) {
      $can = empty($alias) ? $value : $value[$alias];
      $id = (int)$can['candidato_cve'];
      $isAcquired = !empty($value['Empresa']) && (int)$value['Empresa']['adquirido'] === 1;

      $c = array(
        'id' => $id,
        'adquirido' => $isAcquired
      );

      if ($isAcquired && isset($value['Atributos']['favorito']) && (int)$value['Atributos']['favorito'] === 1) {
        $c['favorito'] = true;
      }

      $nombre = $can['candidato_nom'] . ($isAcquired
        ? ' ' . $can['candidato_pat'] . ' ' . $can['candidato_mat']
        : '');

      $direccion = $isAcquired ? implode(', ', array(
        //$value['Direccion']['colonia'],
        $can['ciudad_nom'],//$value['Direccion']['ciudad'],
        $can['est_nom'],//$value['Direccion']['estado'],
        $can['pais_nom'],//$value['Direccion']['pais'],
        $can['cp_cp'],//$value['Direccion']['cp']
      )) : implode(', ', array(
        $can['est_nom'], //$value['Direccion']['estado'],
        $can['pais_nom'], //$value['Direccion']['pais'],
      ));

      $c['datos'] = array(
        'nombre'=> ucwords(strtolower($nombre)),
        'edad' => $can['candidato_edad'] . ' años',
        'telefono' => $isAcquired ? $can['candidato_movil'] : 'N/D',
        'email' => $isAcquired ? $can['cc_email'] : 'N/D',
        'edo_civil' => $isAcquired ? $can['candidato_edocivil'] : 'N/D',
        'ubicacion' => $direccion
      );

      $c['foto'] = $can['foto_url'];
      $c['perfil'] = $can['candidato_perfil'];
      $c['sueldo'] = array(
        'orden' => str_pad($can['sueldo_cve'], 2, "0", STR_PAD_LEFT),
        'cant' => $can['explab_sueldod'] ?: ''
      );

      $c['slug'] = Inflector::slug($can['candidato_perfil'] . '-' . $id, '-');
      if ($can['explab_empresa']) {
        $c['trabajos'][] = array(
          'empresa' => $can['explab_empresa'],
          'puesto' => $can['explab_puesto'],
          'periodo' => $this->Time->month($can['explab_fecini']) . ' - ' . (!$can['explab_fecfin'] ? 'Actual' : $this->Time->month($can['explab_fecfin'])),
        );
      }


      // foreach ($value['ExpeLaboral'] as $i => $expe) {
      //   if ($i === $_limit) break;
      //   $c['trabajos'][] = array(
      //     'empresa' => $expe['empresa'],
      //     'puesto' => $expe['puesto'],
      //     'periodo' => $this->Time->month($expe['inicio']) . ' - ' . ($expe['actual'] === 'S' ? 'Actual' : $this->Time->month($expe['fin'])),
      //   );
      // }

      // foreach ($value['Experiencia'] as $i => $experiencia) {
      //   if ($i === $_limit) break;
      //   $c['experiencia'][] = array(
      //     'area' => $experiencia['area'],
      //     'tiempo' => $experiencia['tiempo']
      //   );
      // }

      if ($can['ec_institucion']) {
        $c['estudios'][] = array(
          'institucion' => $can['ec_institucion'],
          'carrera' => !empty($can['cespe_nom']) ? $can['cespe_nom'] : null,
          //'periodo' => $this->Time->month($can['ec_fecini']) . ($can['ec_fecfin'] ? ' - ' . $this->Time->month($can['ec_fecfin']) : ''),
        );
      }


      // foreach ($value['Estudios'] as $i => $estudio) {
      //   if ($i === $_limit) break;
      //   $c['estudios'][] = array(
      //     'institucion' => $estudio['instituto'],
      //     'periodo' => $this->Time->month($estudio['inicio']) . ($estudio['fin'] ? ' - ' . $this->Time->month($estudio['fin']) : ''),
      //   );
      // }

      foreach ($value['Carpetas'] as $carpeta) {
        $c['carpetas'][] = array(
          'id' => (int)$carpeta['carpeta_cve'],
          'nombre' => $carpeta['carpeta_nombre'],
          'slug' => Inflector::slug($carpeta['carpeta_nombre'], '-') . '-' . $carpeta['carpeta_cve']
        );
      }

      if(isset($value['Postulacion']) && !empty($value['Postulacion'])  ){
        $v=$value['Postulacion'];
        $c['postulacion']= array(
          'fecha' => array(
            'val'=> $v['created'],
            'str'=> $this->Time->dt( $v['created'] )
            )
        );
      }

      $results[] = $c + $mergeData;
    }

    return $results;
  }

  public function getPhotoPath($id) {
    return Usuario::getPhotoPath($id);
  }
}
