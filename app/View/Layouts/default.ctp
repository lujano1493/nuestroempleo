<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>


  <head>


  <meta charset="utf-8">
    <title> <?=$title_layout?>  </title>
  <!--[if IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
  <![endif]-->

    <!--[if IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=9">
  <![endif]-->


  <!--[if IE 10]>
    <meta http-equiv="X-UA-Compatible" content="IE=10">
  <![endif]-->
   <?php
        $base_url=Router::url('/', true);
        $url=$base_url.$this->params->url;
        echo $this->fetch('meta');
  ?>

  <meta property="og:title" content="<?=$title_layout?>" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?=$url?>" />
  <meta property="og:image" content="<?=$base_url?>img/logo.png" />
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:image:width" content="900" />
  <meta property="og:image:height" content="600" />
  <meta property="og:description" content="<?=$description_layout?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?=$description_layout?>">
  <meta name="subject" content="Tu red laboral">
  <meta name="keywords" content="Empleo, red laboral, bolsa de trabajo, trabajo, nuestro empleo.">
  <meta http-equiv="content-type" content="text/html;charset=UTF-8">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">




        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">

                   <!-- hojas de estilos aleatorias-->
                <!--link rel="stylesheet" href="" type="text/css">
            <script type="text/javascript">
            num=4;
            rnd = Math.ceil(Math.random()*num);
            document.getElementsByTagName('link')[0].href = 'assets/css/style'+rnd+'.css';
            </script-->


        <?php
             echo $this->Html->meta('icon');
              echo $this->Html->charset();
             echo $this->AssetCompress->css('fonts.css');
              echo $this->AssetCompress->css('main.css');
              echo $this->AssetCompress->includeCss();
            echo $this->element("candidatos/agregar_estilo");
            echo $this->Html->script('vendor/modernizr.custom.min');
        ?>




    </head>
<body>
  <!-- Header -->
  <div id="out_container" class="boxed">
    <?=$this->element("inicio/modal_registrar") ?>
    <?=$this->element("inicio/header") ?>
    <!-- Empieza contenido -->
    <div class="contenido">
      <?php
        echo $this->Session->flash();
        echo $this->Session->flash('auth', array(
          'params' => array('class' => 'warning'),
          'element' => 'common/alert'
        ));
      ?>
      <?=$this->fetch("content")?>

      <?php

      echo $this->element("inicio/ofertas_destacadas");
      if(empty($micrositio)){
        echo $this->element("inicio/nuestros_clientes");

      }
      ?>
      <div style="margin-top:30px"></div>
      <?=$this->element("inicio/footer")?>




    </div>
  </div>

  <?php
      echo $this->Template->insert(array(
        'modaloferta',
      ), null, array(
        'viewPath' => 'BusquedaOferta'
      ));

        echo $this->Template->insert(array(
        'can-mensaje',
        'can-evento',
        'can-notificacion'
      ), null, array(
        'viewPath' => 'Notificaciones'
      ));
    ?>


  <!-- Javascript -->



  <?php
  echo $this->AssetCompress->script('jquery.js');
  echo $this->AssetCompress->script('plugins.js');
  echo $this->AssetCompress->script('tables.js');
  echo $this->AssetCompress->includeJs();
  echo $this->fetch('script');
  echo $this->fetch('css');

  echo $this->Html->script("plugin.redes.sociales");
  ?>


</body>

</html>

