<?php
  App::uses('Usuario', 'Utility');

  $totales = $notificaciones['totales'];
  $notificaciones = $notificaciones['results'];

  $items = array();

  foreach ($notificaciones as $key => $value) {
    $ntfy = $value['Notificacion'];
    $from = $value['From'];

    $route=$ntfy['notificacion_controlador'];
    $route= !empty($micrositio) ? "/{$micrositio[name]}$route":  $route;
    $n = array(
      'data' => array(
        'id' => $ntfy['notificacion_cve'],
        'title' => $ntfy['notificacion_titulo'],
        'body' => $ntfy['notificacion_texto']
      ),
      'meta' => array(
        'type' => $ntfy['tipo'],
        'created' => $this->Time->dt($ntfy['created']),
        'route' =>  $route,
        'isNew' => false,
        'icon' => $ntfy['icon'],
        'clazz' => $ntfy['clazz'],
        'unread' => !(bool)$ntfy['notificacion_leido'],
        // 'tmpl' => ''
      ),
      'from' => array(
        'logo' => Usuario::getPhotoPath($from['cia_cve'], 'empresa'),
        'email' => $from['email'],
        'name' => $from['nombre'],
      )
    );
    $items[]=$n;
  }

  $this->_results = compact('totales', 'items');

?>