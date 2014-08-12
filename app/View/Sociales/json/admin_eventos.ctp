
<?php 

  $results=array();


  foreach ($compartirse as $k) {
    $evento=$k['Evento'];
    $usuario=$k['Reclutador'];
    $empresa=$k['Empresa'];
    $results[]=array(
        'id' => $evento['evento_cve'],
        'tipoCompartir' =>  'evento',
        'nombre' => $evento['evento_nombre'],
        'descripcion' => $evento['evento_resena'],
        'direccion' => $evento['evento_dir'],
        'ciudad' => $evento['ciudad_nom'],
        'estado' => $evento['est_nom'],
        'tipo' => $evento['tipo_nombre'],
        'empresa' => $empresa['cia_nombre'],
        'liga' => $evento['evento_link'],
        'fecha_inicio' => array(
              'val' =>$evento['evento_fecini'],
              'str' =>$this->Time->d($evento['evento_fecini']) 
          ),
        'fecha_fin' => array(
              'val' =>$evento['evento_fecfin'],
              'str' =>$this->Time->d($evento['evento_fecfin']) 
          ),
        'veces_compartidas' => (int)$evento['compartido'],
        'compartir' => array(
                'facebook' => (int)$evento['compartido_facebook'],
                'twitter' => (int)$evento['compartido_twitter'],
                'linkedin'=> (int)$evento['compartido_linkedin']
          )

      );
  }

  $this->_results=$results;

?>