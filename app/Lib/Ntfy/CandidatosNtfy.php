<?php

/**
 * Clase de Notificaciones para Candidatos.
 */

App::uses('Ntfy', 'Lib/Ntfy');

class CandidatosNtfy extends Ntfy {

  public function send($event, $data = array()) {
    /**
     * Aquí se le puede dar formato a los datos ($data).
     */

    parent::send($event, $data);
  }
}