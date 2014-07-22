<div class="row">
  <h1><?php echo __('Conoce nuestros planes'); ?></h1>
  <div class="btn-actions text-center">
    <?php
      $referer = $this->Session->read('App.referer') ?: '/mi_espacio';
      echo $this->Html->link('Regresar', $referer, array(
        'class' => 'btn btn-default',
        'icon' => 'arrow-left'
      ));
    ?>
  </div>
</div>