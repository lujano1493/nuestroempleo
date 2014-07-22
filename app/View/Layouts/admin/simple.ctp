<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>::Nuestro Empleo:: Tu espacio laboral en internet</title>
  <meta http-equiv="X-UA-Compatible" content="IE=8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Nuesto Empleo es un espacio laboral en internet que te ayudará a conseguir contactos laborales confiables.">
  <meta name="subject" content="Tu espacio laboral en internet"/>
  <meta name="keywords" content="Empleo, red laboral, bolsa de trabajo, trabajo, nuestro empleo."/>
  <!-- CSS -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
  <?php
    echo $this->AssetCompress->css('admin.css');
    echo $this->AssetCompress->css('admin_index.css');
  ?>
  <!--[if lte IE 8]>
  <link rel="stylesheet" type="text/css" href="assets/css/ie8.css" />
  <![endif]-->

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Favicon and touch icons -->
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>
  <?php echo $this->fetch('content'); ?>
</body>
</html>
