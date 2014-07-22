<?php 
  $formattedEvents = array();
  
  foreach ($eventos as $key => $value) {
    $ev = $value['Evento'];
    $status = (int)$ev['evento_status'];

    $formattedEvents[] = array(
      'id' => (int)$ev['evento_cve'],
      'title' => $ev['evento_nombre'],
      'desc' => $ev['evento_resena'],
      'start' => $ev['evento_fecini'],
      'end' => $ev['evento_fecfin'],
      'editable' => strtotime($ev['evento_fecini']) > time(),
      'inicio' => $status ? $this->Time->dt($ev['evento_fecini']) : 'Cancelado',
      'fin' => $status ? $this->Time->dt($ev['evento_fecfin']) : 'Cancelado',
      'dir' => $ev['evento_dir'],
      'calle' => $ev['evento_calle'],
      'type' => (int)$ev['evento_tipo'],
      'tipo' => $ev['tipo_nombre'],
      'cp' => $ev['evento_cp'],
      'created' => $ev['created'],
      'modified' => $ev['modified'],
      'status' => $status,
      'lat' => $ev['latitud'],
      'lng' => $ev['longitud'],
      'usuario' => $value['Reclutador']
    );
  }
  $this->_results = $formattedEvents;
?>