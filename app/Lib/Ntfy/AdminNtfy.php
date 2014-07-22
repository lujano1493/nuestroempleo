<?php

/**
 * Clase de Notificaciones para Empresas
 */

App::uses('Ntfy', 'Lib/Ntfy');

class AdminNtfy extends Ntfy {

  public function send($event, $data = array()) {
    /**
     * Aquí se le puede dar formato a los datos ($data).
     */

    parent::send($event, $data);
  }
}