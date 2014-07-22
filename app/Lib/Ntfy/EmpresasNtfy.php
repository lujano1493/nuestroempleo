<?php

/**
 * Clase de Notificaciones para Empresas
 */

App::uses('Ntfy', 'Lib/Ntfy');

class EmpresasNtfy extends Ntfy {

  public function send($event, $data = array()) {
    /**
     * Aquí se le puede dar formato a los datos ($data).
     */

    parent::send($event, $data);
  }
}