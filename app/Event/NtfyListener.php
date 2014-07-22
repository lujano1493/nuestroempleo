<?php

App::uses('BaseEventListener', 'Event');

class NtfyListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Component.Ntfy.send' => 'sendNtfy'
    );
  }

  public function sendNtfy(CakeEvent $event) {
    $this->send($event->data['event'], $event->data['data'], $event->data['namespace']);
  }

  public function format($data = array()) {

  }
}