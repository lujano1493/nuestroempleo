<!DOCTYPE html>
<html>
  <head>
    <title>NuestroEmpleo: <?php echo $title_for_layout; ?></title>
    <?php
      echo $this->Html->meta('icon');
      echo $this->fetch('meta');
      echo $this->Html->css(array(
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400',
        // 'http://fonts.googleapis.com/css?family=Droid+Sans',
        // 'http://fonts.googleapis.com/css?family=Lobster'
      ));
      echo $this->AssetCompress->css('fonts.css');
      //echo $this->AssetCompress->css('main.css');
      echo $this->AssetCompress->css('admin.css');
      echo $this->fetch('css');
      echo $this->AssetCompress->includeCss();
      echo $this->Html->script('vendor/modernizr.custom.min');
    ?>
  </head>
  <body class="admin">
    <div id="wrapper">
      <?php
        echo $this->element('admin/header', array(
          'flash' => true
        ));
      ?>
      <div class="container" id="body-content">
        <?php
          echo $this->element('admin/sidebar_menu');
        ?>
        <div id="main-content" class="clearfix">
          <?php
            // echo $this->element('common/breadcrumb', array(
            //   'element' => 'empresas/credits'
            // ));
          ?>
          <div id="content" data-action-role="main-content" class="magic-container">
            <?php echo $this->fetch('content'); ?>
          </div>
        </div>
        <?php echo $this->element('empresas/footer'); ?>
      </div>
    </div>
    <?php
      echo $this->Html->script('socket.io', array(
        'namespace' => '/admin'
      ));

      echo $this->AssetCompress->script('jquery.js');
      echo $this->AssetCompress->script('plugins.emp.js');
      echo $this->AssetCompress->script('admin.js');
      echo $this->fetch('script');
      if ($ajaxanizeTables) {
        echo $this->AssetCompress->script('dynamic-tables.js');
      }

      echo $this->AssetCompress->includeJs();
      echo $this->Html->script("plugin.redes.sociales");
      // echo $this->AssetCompress->script('admin.js');
    ?>
  </body>
</html>