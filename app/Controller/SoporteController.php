<?php

class SoporteController extends AppController {

  public $name = 'Soporte';

  public $components = array(
    'Emailer'
  );

  public function admin_index() {
    $title_for_layout = __('Soporte Técnico');

    $this->set(compact('title_for_layout'));
  }

}