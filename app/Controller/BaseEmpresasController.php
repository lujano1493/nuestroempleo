<?php

App::uses('AppController', 'Controller');

class BaseEmpresasController extends AppController {
  public function beforeFilter() {
    parent::beforeFilter();

    $this->Auth->authError = 'Por favor inicia sesi&oacute;n en Empresas para acceder a esta secci&oacute;n.';
    $this->Auth->loginAction = '/empresas';

    $role = $this->Acceso->is();

    if ($role === 'candidato' ) {
      $this->redirect('/candidato');
    }

    /**
     * PROMO
     */
    if ($role === 'empresa') {
      $this->loadModel('Ticket');
      $ticket = $this->Ticket->checkTicket('PROMO_CIA_' . $this->Auth->user('Empresa.cia_cve'));

      if (!empty($ticket)) {
        //$this->Session->write('Auth.promo', true);
        $this->set('showPromo', true);

        $this->Ticket->delete($ticket['Ticket'][$this->Ticket->primaryKey]);
      }
    }

    /**
     * PROMO
     */
  }
}

