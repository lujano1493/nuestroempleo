<?php
  $totales = $notificaciones['totales'];
  $notificaciones = $notificaciones['results'];

  $items = array();

  foreach ($notificaciones as $key => $value) {
    $ntfy = $value['Notificacion'];
    $from = $value['From'];

    $n = array(
      'data' => array(
        'id' => $ntfy['notificacion_cve'],
        'title' => $ntfy['notificacion_titulo'],
        'body' => $ntfy['notificacion_texto']
      ),
      'meta' => array(
        'type' => $ntfy['tipo'],
        'created' => $this->Time->dt($ntfy['created']),
        'route' => $ntfy['notificacion_controlador'],
        'isNew' => false,
        'icon' => $ntfy['icon'],
        'clazz' => $ntfy['clazz'],
        'unread' => !(bool)$ntfy['notificacion_leido'],
      ),
      'from' => array(
        'logo' => $this->Candidato->getPhotoPath($from['id']),
        'email' => $from['email'],
        'name' => $from['nombre'],
      )
    );

    $items[] = $n;
  }

  $this->_results = compact('totales', 'items');
?>