<?php

App::uses('Helper', 'View');

App::import('Vendor',array(
                            'visualcaptcha/visualcaptcha' 
                          ));

class VisualCaptchaHelper extends Helper {



  private $visualcaptcha=null;




  public function __construct(View $View, $settings = array()) {
    parent::__construct($View,$settings);
    $this->visualcaptcha=new Captcha();

  }

	public function show(){
    $this->visualcaptcha->show();


  }


    public function only_show(){
    $this->visualcaptcha->only_show();


  }

    public function init_value(){
       $this->visualcaptcha->init_value();

  }


   public function getImageFilePath( $i, $getRetina = false ){
       return $this->visualcaptcha->getImageFilePath($i,$getRetina);

  }

}
