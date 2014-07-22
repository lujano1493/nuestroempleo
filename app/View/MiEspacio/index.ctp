<?php
  echo $this->element('empresas/title', array(
    'busqueda' => false
  ));
?>
<div class="">
  <h3 class="search-title">Bienvenido</h3>
  <br>
  <?php echo $this->element('empresas/candidatos/buscar'); ?>
  <?php echo $this->element('empresas/stats'); ?>
  <?php echo $this->element('empresas/candidatos/last_updates'); ?>
  <?php echo $this->element('empresas/servicios/slides'); ?>
  <!-- <div class="row">
    <?php echo $this->element('empresas/banners'); ?>
  </div> -->
</div>