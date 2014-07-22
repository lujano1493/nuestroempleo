<?php

App::uses('BaseEventListener', 'Event');

class CreditosListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Component.Creditos.updated' => 'sendNtfy'
    );
  }

  public function sendNtfy(CakeEvent $event) {
    $this->send('users.update-session', $event->data);
  }

  public function format($data = array()) {

  }
}