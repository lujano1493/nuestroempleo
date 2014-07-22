<header class="container-header">
  <div class="">
    <h1 class="title" data-role="title">
      <?php echo isset($title_for_layout) ? $title_for_layout : $this->name; ?>
      <?php //if (!empty($desc)): ?>
        <!-- <small><?php //echo $desc; ?></small> -->
      <?php //endif ?>
    </h1>
  </div>
</header>
<?php
  if (!isset($busqueda) || $busqueda !== false) {
    echo $this->element('empresas/candidatos/buscar', array(
      'busqueda' => !isset($busqueda) ? '' : $busqueda
    ));
  }
?>