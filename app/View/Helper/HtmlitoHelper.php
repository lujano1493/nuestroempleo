<?php

App::uses('HtmlHelper', 'View/Helper');

/**
  * Helper personalizado para los inputs de nuestro empleo.
  */
final class HtmlitoHelper extends HtmlHelper {
  public $helpers = array('Js');

  public function script($url, $options = array()) {
    if ($url === 'socket.io') {
      if (!Configure::read('socket_io.available')) {
        return '';
      }
      $_url = Configure::read('socket_io.url');
      $baseUrl = $_url['host'] . (isset($_url['port']) && is_numeric($_url['port']) ? ':' . $_url['port'] : '');

      $url = $baseUrl . $_url['path'];
      $baseUrl .= (!empty($options['namespace']) ? $options['namespace'] : '');
      unset($options['namespace']);

      $script = '<script type="text/javascript">window.ioServer = "' . $baseUrl . '";</script>';

      return parent::script($url, $options) . $script;
    }

    if ($url === 'plugin.redes.sociales') {
      if (!Configure::read('sociales.available')) {
        return '';
      }
      $config = Configure::read('sociales.config');
      $path = $config['path'];
      $url = array();
      $script = "";
      foreach ($config['plugins'] as  $value) {
        $url[] = $path . $value;
        if ($value === 'facebook') {
          Configure::load('facebook');
          $a = Configure::read('Facebook');
          $script = '<script type="text/javascript">window.api_facebook_id = "' . $a['appId'] . '";</script>';
          $script .= '<script type="text/javascript">window.api_facebook_locate = "' . $a['locale'] . '";</script>';
        }
      }
      return   $script.parent::script($url, $options);



    }

    return parent::script($url, $options);
  }

  public function browser() {
    return $this->_View->element('common/browser');
  }


  public function url ($url = null, $full = false){
    if(isset($this->params['compania'] ) && is_array($url) ){        
        $url['compania'] =$this->params['compania']['name'];
    }
    return parent::url($url,$full);


  }

  public function link($title, $url = null, $options = array(), $confirmMessage = false) {
    $tags = '';

    if (isset($options['icon'])) {
      $title = $this->addIcons($title, $options['icon']);
      $options['escape'] = false;
      unset($options['icon']);
    }

    if (isset($options['tags'])) {
      $options['escape'] = false;
      $tags = $this->tags($options['tags']);
      unset($options['tags']);
    }

    return parent::link((string)$title . $tags, $url, $options, $confirmMessage);
  }

  /**
   * Genera un link con el título entre span.
   * @param  [type]  $title          [description]
   * @param  [type]  $url            [description]
   * @param  array   $options        [description]
   * @param  boolean $confirmMessage [description]
   * @return [type]                  [description]
   */
  public function spanLink($title, $url = null, $options = array(), $confirmMessage = false) {
    $span = array(
      'span', $title, isset($options['spanOptions']) ? $options['spanOptions'] : array()
    );
    $options['escape'] = false;

    if (isset($options['tags'])) {
      $tags = (array)$options['tags'];
      array_unshift($tags, $span);
      $options['tags'] = $tags;
    } else {
      $options['tags'] = $span;
    }

    unset($options['spanOptions']);

    return $this->link('', $url, $options, $confirmMessage);
  }

  public function back($text = null, $options = array()) {
    if (!$text) {
      $text = __('Regresar');
    }

    $url = $this->_View->viewVars['_referer'];

    return $this->link($text, $url, array_merge(array(
      'class' => 'btn btn-default btn-sm',
      'data-close' => true,
      'icon' => 'arrow-left',
    ), $options));
  }

  public function here($text = null) {
    $url = $this->url('/', true);
    if (!$text) {
      $text = $url;
    }

    return $this->link($text, $url, array());
  }

  /**
   * Genera una serie de elementos HTML.
   *
   * @param  array  $tags Array de etiquetas.
   * @return [type]       [description]
   */
  public function tags($tags = array()) {
    $_tags = array();

    if (isset($tags[0]) && !is_array($tags[0])) {
      $tags = array($tags);
    }

    foreach ($tags as $tag) {
      $_tags[] = call_user_func_array(array($this, 'tag'), $tag);
    }

    return implode('', $_tags);
  }

  /**
   * Genera el tag con el ícono. Se puede agregar un ícono antes y después.
   * @param  [type] $title [description]
   * @param  string $icon  [description]
   * @return [type]        [description]
   */
  public function addIcons($title, $icons = '') {
    if (!is_array($icons)) {
      $icons = array(
        'before' => $icons
      );
    }

    $iconizedArray = array(
      isset($icons['before']) ? '<i class="icon-' . $icons['before'] . '"></i>' : '',
      $title,
      isset($icons['after']) ? '<i class="icon-' . $icons['after'] . '"></i>' : '',
    );

    return implode('', $iconizedArray);
  }

  /**
   * Si existe el parámetro de 'data', los transformará como atributo.
   *
   * @param array $options Array of options.
   * @param array $exclude Array of options to be excluded, the options here will not be part of the return.
   * @param string $insertBefore String to be inserted before options.
   * @param string $insertAfter String to be inserted after options.
   * @return string Composed attributes.
   */
  protected function _parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
    if (is_string($options)) {
      $options = array(
        'class' => $options
      );
    }

    if (isset($options['data']) && ($data = $options['data'])) {
      if (is_string($data)) {
        // Si es string, lo agrega como valor truthy.
        $options['data-' . $data] = true;
      } elseif (is_array($data)) {
        // Itera sobre cada llave del array.
        foreach ($data as $key => $value) {
          $options['data-' . $key] = $value;
        }
      }
      unset($options['data']);
    }

    return parent::_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
  }

  public function create_options_fecha_publicacion(){
        $dias=array();

        $dia_time=(1*24*60*60);


        for ($inicio=0;$inicio<30;$inicio++ ) {

          $time =  time() -  ($inicio*$dia_time);

          $formato_fecha= date('d',$time)."/" .date("m",$time)."/".date("Y",$time);
          $label_fecha= "Hace ".$inicio." dias";

          $label_fecha= $inicio == 0 ? "Hoy": ($inicio== 1 ? "Ayer" :$label_fecha );

          $dias[$formato_fecha]= $label_fecha;


        }
        return $dias;

  }


  public function formato_fecha_publicacion_code($fecha=null ){
      if(!$fecha){
          return null;

      }
      $actual=time();

      $tiempo=strtotime($fecha);


      $str="";
      $result=  floor(  ($actual-$tiempo) / ((1*24*60*60)) );
      if($result==0){
          $str="Hoy";
      }
      else if ($result==1){
          $str="Ayer";
      }

      else{
          $str="Hace ".$result." dias";
      }
       return  $str ;

  }




   public function formato_fecha_publicacion_decode($str=null ){
      if(!$str){
          return null;

      }
      $dia=(1*24*60*60);


        $time=time();

        if($str=="Hoy" ){
            return date("m/d/Y");

        }
        else if ($str=="Ayer"){

            return date("m/d/Y",   $time -$dia  );
        }

        else if (preg_match("/(Hace [0-9]+)/", $str, $matches)  ) {

              $p= explode("Hace",$matches[0]);
              $dias_menos= $p[1];


              return date("m/d/Y",   $time - ($dia * $dias_menos) );


        }

        return null;



  }


}
