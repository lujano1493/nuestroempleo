<?php
  $mNombre = $membresia['membresia_nom'];
  $mCosto = $membresia['costo'];
  $mClase = $membresia['membresia_clase'];
  $mVigencia = $membresia['vigencia'];
  $detalles = $membresia['Detalles'];
  $mMembresia = strtolower(Inflector::slug($mNombre, '-'));
?>
<div class="paquete paquete-mbs" id="<?php echo 'membresia-' . $mMembresia; ?>">
  <div class="border">
    <div class="heading-icon">
      <i class="icon-file-text round-icon"></i>
    </div>
    <h5 class="text-center">
      <strong><?php echo $mNombre; ?></strong>
    </h5>
    <div class="paquete-body">
      <!-- <ul class="list-unstyled">
        <li><?php // echo __('%s días de Vigencia', $mVigencia); ?></li>
        <?php
          // foreach ($detalles as $kd => $vd) {
          //   $creditos = $vd['Detalle']['creditos_infinitos'] ? __('Ilimitadas') :  $vd['Detalle']['credito_num'];
          //   $servicio = $vd['Servicio']['servicio_nom'];
            ?>
              <li>
                <strong><?php // echo $creditos; ?></strong>
                <span><?php // echo $servicio; ?></span>
              </li>
            <?php
          // }
        ?>
      </ul> -->
      <p>
        <?php echo $membresia['membresia_desc']; ?>
      </p>
    </div>
    <div class="paquete-footer text-center">
      <?php
        echo $this->Html->link(__('Agregar al carrito'), array(
          'controller' => 'mis_productos',
          'action' => 'agregar_a_carrito',
          'id' => $membresia['membresia_cve']
        ), array(
          'class' => 'btn btn-sm btn-default update-cart pull-right',
          'icon' => 'shopping-cart',
          'data' => array(
            'component' => 'ajaxlink',
            //'action-role' => 'add-cart'
            'ajaxlink-target' => 'view:carrito-menu'
          )
        ));
      ?>
      <strong class="money block">
        <?php
          echo $this->Number->currency($mCosto);
        ?>
      </strong>
    </div>
  </div>
</div>