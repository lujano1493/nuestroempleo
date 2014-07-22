<?php 
  $formattedEvents = array();
  
  foreach ($eventos as $key => $value) {
    $ev = reset($value);
      $data= array(
      'id' => $ev['evento_cve'],
      'title' => $ev['evento_nombre'],
      'desc' => $ev['evento_resena'],
      'start' => $ev['evento_fecini'],
      'end' => $ev['evento_fecfin'],
      'start_f' =>  $this->Time->dt($ev['evento_fecini']) ,
      'end_f' =>  $this->Time->dt($ev['evento_fecfin']) ,
      'tipo_evento'=> $ev['tipo_nombre'],
      'dir' => $ev['evento_dir'],
      'calle' => $ev['evento_calle'],
      'cp' => $ev['evento_cp'],
      'estado' => $ev['est_nom'],
      'ciudad' => $ev['ciudad_nom'],
      'created' => $ev['created'],
      'modified' => $ev['modified'],
      'status' => $ev['evento_status'],
      'lat' => $ev['latitud'],
      'lng' => $ev['longitud'],
      'type' => $ev['evento_tipo'],
    );

    if($isAuthUser) {
        $extra_data=array(
                'cia' =>  $ev['cia_nombre'],
                'nombre' => $ev['nombre'],
                'telefono' => $ev['telefono'],
                'email' => $ev['email']

        );
      $data=array_merge($data,$extra_data);
    }

     $formattedEvents[] =$data;


  }

  $this->_results = $formattedEvents;
?>