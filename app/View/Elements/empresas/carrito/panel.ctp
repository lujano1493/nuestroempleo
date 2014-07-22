<?php
  $mNombre = $membresia['membresia_nom'];
  $mCosto = $membresia['costo'];
  $mClase = $membresia['membresia_clase'];
  $mVigencia = $membresia['vigencia'];
  $detalles = $membresia['Detalles'];
?>
<div class="carrito-panel panel <?php echo 'panel-' . $mClase; ?>">
  <div class="panel-heading">
    <h5 class="text-center"><?php echo $mNombre; ?></h5>
  </div>
  <div class="panel-body">
    <strong class="money pull-right">
      <?php
        echo $this->Number->currency($mCosto);
      ?>
    </strong>
    <ul class="list-unstyled">
      <li><?php echo __('%s días de Vigencia', $mVigencia); ?></li>
      <?php
        foreach ($detalles as $kd => $vd) {
          $creditos = $vd['Detalle']['creditos_infinitos'] ? __('Ilimitadas') :  $vd['Detalle']['credito_num'];
          $servicio = $vd['Servicio']['servicio_nom'];
          ?>
            <li><?php echo $creditos . ' '. $servicio; ?></li>
          <?php
        }
      ?>
    </ul>
  </div>
  <div class="panel-footer text-right">
    <?php
      echo $this->Html->link(__('Agregar al carrito'), array(
        'controller' => 'mis_productos',
        'action' => 'agregar_a_carrito',
        'id' => $membresia['membresia_cve']
      ), array(
        'class' => 'btn btn-sm update-cart',
        'icon' => 'shopping-cart',
        'data' => array(
          'component' => 'ajaxlink',
          // 'action-role' => 'add-cart',
          'ajaxlink-target' => 'view:carrito-menu'
        )
      ));
    ?>
  </div>
</div>