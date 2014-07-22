<?php
  $this->set('noValidationErrors', true);

  	$results=array();
  	$info=$data['data'];




    foreach ($info as $key => $value) {
      $can = $value['CandidatoB'];
      $id = (int)$can['candidato_cve'];
       $isAcquired = (int)$value['Empresa']['adquirido'] === 1;

      $c = array(
        'id' => $id,
        'adquirido' => $isAcquired
      );

      if ($isAcquired && (int)$value['Atributos']['favorito'] === 1) {
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



      if ($can['ec_institucion']) {
        $c['estudios'][] = array(
          'institucion' => $can['ec_institucion'],
          'carrera' => $can['cespe_nom'],
          //'periodo' => $this->Time->month($can['ec_fecini']) . ($can['ec_fecfin'] ? ' - ' . $this->Time->month($can['ec_fecfin']) : ''),
        );
      }




      foreach ($value['Carpetas'] as $carpeta) {
        $c['carpetas'][] = array(
          'id' => (int)$carpeta['carpeta_cve'],
          'nombre' => $carpeta['carpeta_nombre'],
          'slug' => Inflector::slug($carpeta['carpeta_nombre'], '-') . '-' . $carpeta['carpeta_cve']
        );
      }

      $results[] = $c;
    }






  	unset($data['data']);
  	$results= array_merge(array( "data" =>$results ),   array("paginate"=>$data) );
  	$this->_results = $results;

  //$this->_results = $this->Candidato->formatToJson($candidatos);
?>