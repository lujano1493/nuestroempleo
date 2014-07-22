<!DOCTYPE html>
<html lang="en">
<head>
  <title>::Nuestro Empleo:: Tu Espacio Laboral en Internet </title>
  <!--[if IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
  <![endif]-->
  <!--[if IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=9">
  <![endif]-->
  <!--[if IE 10]>
    <meta http-equiv="X-UA-Compatible" content="IE=10">
  <![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Nuesto Empleo es una red laboral que te ayudará a conseguir contactos laborales confiables.">
  <meta name="subject" content="Tu red laboral"/>
  <meta name="keywords" content="Empleo, red laboral, bolsa de trabajo, trabajo, nuestro empleo."/>
  <?php
    echo $this->Html->meta('icon');
    echo $this->Html->charset();
    echo $this->AssetCompress->css('fonts.css');
    echo $this->AssetCompress->css('main.css');
    echo $this->fetch('css');
    echo $this->AssetCompress->includeCss();
    echo $this->fetch('meta');
    echo $this->Html->script('vendor/modernizr.custom.min');
    echo $this->element("candidatos/agregar_estilo");
  ?>
  <link rel="shortcut icon" href="/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
  <style type="text/css">
  /*<![CDATA[*/
  .esthela {
    float:left;
    width:450px;
    height:100%;
    background-image:url(img/contact.png); background-repeat:no-repeat;
    display:block;
    right: -400px;
    padding:0;
    position:fixed;
    top:0px;
    z-index:1002;
  }
  /*]]>*/
  </style>
</head>
<body>
  <!-- Header -->
  <div id="out_container" class="boxed">
    <?php echo $this->element("empresas/inicio/header"); ?>
    <!-- Empieza contenido -->
    <div class="contenido">
      <?php
        echo $this->Session->flash();
        echo $this->Session->flash('auth', array(
          'params' => array('class' => 'warning'),
          'element' => 'common/alert'
        ));
      ?>
      <?php
        echo $this->fetch('content');
        //echo $this->element("inicio/nuestros_clientes");
        echo $this->element("inicio/footer");
      ?>
    </div>
  </div>
    <!-- Javascript -->
  <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <?php
    echo $this->AssetCompress->script('jquery.js');
    echo $this->AssetCompress->script('plugins.js');
    echo $this->AssetCompress->includeJs();
    echo $this->fetch('script');
    echo $this->Html->script("app/candidatos/focus_elements");
    echo $this->Html->script("plugin.redes.sociales");
  ?>
  <!-- <script type="text/javascript" >
    $(document).ready(function () {
      'use strict';
      $.getJSON('/info/giros.json').done(function (data) {
        $('#giros').magicSuggest({
          emptyText: 'Selecciona el giro de tu empresa.',
          allowFreeEntries: false,
          data: data,
          maxSelection: 1,
          width: 300,
          'element_extra': function (index, value) {
            $('#EmpresaGiroCve').val(value.id);
            return $();
          },
          maxSelectionRenderer: function(v) {
            return '';
          },
        });
      });
    });
  </script> -->
</body>
</html>

