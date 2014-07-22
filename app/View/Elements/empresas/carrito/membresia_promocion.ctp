<?php
  $mNombre = $membresia['membresia_nom'];
  $mCosto = $membresia['costo'];
  $mClase = $membresia['membresia_clase'];
  $mVigencia = $membresia['vigencia'];
  $detalles = $membresia['Detalles'];
  $mMembresia = strtolower(Inflector::slug($mNombre, '-'));
?>
<div class="paquete paquete-mbs" id="<?php echo 'membresia-' . $mMembresia; ?>">
  <?php
    echo $this->Html->link(__('Adquirir'), array(
      'controller' => 'mis_productos',
      'action' => 'promociones',
      'id' => $membresia['membresia_cve'],
      'slug' => Inflector::slug($membresia['membresia_nom'], '-')
    ), array(
      'class' => 'btn btn-lg btn-success pull-right',
      'icon' => 'ok',
      'data' => array(
        'component' => 'ajaxlink',
      )
    ));
  ?>
  <div class="border" style="margin-top:0;">
    <h5 class="text-center">
      <strong><?php echo $mNombre; ?></strong>
    </h5>
    <div class="paquete-body">
      <?php echo $membresia['membresia_desc']; ?>
    </div>
  </div>
</div>