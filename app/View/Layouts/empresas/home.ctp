<!DOCTYPE html>
<html>
  <head>
    <title>NuestroEmpleo: <?php echo $title_for_layout; ?></title>
    <?php
      echo $this->Html->meta('icon');
      echo $this->fetch('meta');
      echo $this->Html->css(array(
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400',
        //'http://fonts.googleapis.com/css?family=Droid+Sans',
        //'http://fonts.googleapis.com/css?family=Lobster'
      ));
      echo $this->AssetCompress->css('fonts.css');
      echo $this->AssetCompress->css('empresas.css');
      echo $this->AssetCompress->css('editor.css', array(
        'id' => 'editor-css-url'
      ));
      echo $this->fetch('css');
      echo $this->AssetCompress->includeCss();
      echo $this->Html->script('vendor/modernizr.custom.min');
    ?>
  </head>
  <?php
    $basePerfil = (!empty($authUser['Perfil']['base_perfil_str'])
      ? $authUser['Perfil']['base_perfil_str'] : 'basic') . '-membership ' .
      ($authUser['Perfil']['is_promo'] ? strtolower($authUser['Perfil']['membresia']) : '');
  ?>
  <body class="<?php echo $basePerfil; ?>">
    <?php echo $this->Html->browser(); ?>
    <div id="wrapper">
      <?php
        echo $this->element('empresas/header', array(
          'flash' => true
        ));
      ?>
      <div class="container" id="body-content">
        <?php
          echo $this->element('empresas/sidebar/menu');
          $_mainContentClass = !empty($_mainContentClass) ? $_mainContentClass : '';
        ?>
        <div id="main-content" class="clearfix <?php echo $_mainContentClass; ?>">
          <div id="content" data-action-role="main-content" class="magic-container">
            <?php echo $this->fetch('content'); ?>
          </div>
        </div>
        <?php echo $this->element('empresas/footer'); ?>
      </div>
    </div>
    <?php
      if ($this->Acceso->has('mis_eventos')) {
        echo $this->element('empresas/nuevo_evento');
      }

      if ($this->Acceso->checkRole('admin')) {
        echo $this->element('empresas/subir_logo');
      }

      echo $this->element('empresas/nueva_carpeta');

      /**
       * PROMO
       */

      if (!empty($showPromo)) {
        echo $this->element('empresas/promo');
      }

      /**
       * PROMO
       */

      echo $this->Html->script('socket.io', array(
        'namespace' => '/empresas'
      ));

      echo $this->AssetCompress->script('jquery.js');
      echo $this->AssetCompress->script('plugins.emp.js');
      echo $this->AssetCompress->script('editor.js');
      echo $this->fetch('script');
      if (($this->params['controller'] == 'candidatos' && $this->params['action'] == 'index')) {
        echo $this->AssetCompress->script('tables.js');
      } else {
        echo $this->AssetCompress->script('dynamic-tables.js');
      }

      echo $this->AssetCompress->includeJs();
      echo $this->AssetCompress->script('main.js');

      echo $this->Template->insert(array(
        'emp-notificaciones'
      ), null, array(
        'viewPath' => 'Notificaciones'
      ));
    ?>
  </body>
</html>