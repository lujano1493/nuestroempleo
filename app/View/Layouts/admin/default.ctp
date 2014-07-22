<!DOCTYPE html>
<html>
  <head>
    <?php
      echo $this->AssetCompress->css('fonts.css');
      echo $this->AssetCompress->css('main.css');
      echo $this->AssetCompress->css('empresas.css');
    ?>
  </head>
  <body class="admin">
    <div id="wrapper">
      <?php echo $this->element('admin/header'); ?>
      <div id="body">
        <?php echo $this->Session->flash(); ?>
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="span12">
              <?php echo $this->fetch('content'); ?>
            </div>
          </div>
        </div>
      </div>
      <div id="footer"></div>
    </div>
    <?php
      echo $this->AssetCompress->script('jquery.js');
      echo $this->AssetCompress->script('plugins.js');
      echo $this->AssetCompress->script('main.js');
    ?>
  </body>
</html>
