<?php

App::uses('CakeRoute', 'Routing/Route');
App::import('Model', 'MicroSitio');
class MicrositioRoute extends CakeRoute {
  public function __construct($template, $defaults = array(), $options = array()) {
    $this->template = $template;
    $this->defaults = (array)$defaults;
    $this->options = (array)$options;
  }

  public function parse($url) {    
    if (empty($url)){
      return false;
    }
    $_url = parent::parse($url);  
    if (empty($_url) && empty($_url['compania']) ){
      return false;
    }

    $m=new MicroSitio();
    $result=$m->find("clientes",array("idCliente" => $_url['compania']));
    if (!empty($result)  ) {
      $_url['compania']=$result['MicroSitio'];
      return $_url;
    }

    return false;
  }
}