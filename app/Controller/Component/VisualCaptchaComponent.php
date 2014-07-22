<?php
App::uses('Component', 'Controller');


App::import('Vendor',array(
                            'visualcaptcha/visualcaptcha' 
                          ));


class VisualCaptchaComponent extends Component {

  private $visualcaptcha=null;

  public function show(){
    $this->visualcaptcha->show();


  }

  public function init_value(){
    $this->visualcaptcha->init_value();

  }


  public function isValid(){
    return $this->visualcaptcha->isValid();

  }
  public function getImageFilePath( $i, $getRetina = false ){
       return $this->visualcaptcha->getImageFilePath($i,$getRetina);

  }
    
  public function __construct(ComponentCollection $collection, $settings = array()) {
      parent::__construct($collection,$settings);  
    $this->visualcaptcha=   new Captcha();

  }





}