<?php

App::uses('Helper', 'View');

class AppHelper extends Helper {
  /**
   * domI(), sobreescribe la función fuente para generar el id de los elementos
   * html.
   *
   * Si la petición se hace con magicload, necesitamos que los id sean diferentes.
   * Esto se hace agregando un timestamp.
   *
   * POR AHORA NO ES NECESARIA, se tiene que mejorar.
   */
  // public function domId($options = null, $id = 'id') {
  //   $domId = parent::domId($options, $id);

  //   if (!empty($options) && $this->request->header('No-Layout')) {
  //     if (is_array($domId) && isset($domId[$id])) {
  //       $domId[$id] .= time();
  //     } elseif (is_string($domId)) {
  //       $domId .= time();
  //     }
  //   }

  //   return $domId;
  // }
}
