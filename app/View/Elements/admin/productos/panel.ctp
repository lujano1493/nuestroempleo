<?php
  $mNombre = $membresia['membresia_nom'];
  $mCosto = $membresia['costo'];
  $mClase = $membresia['membresia_clase'];
  $mVigencia = $membresia['vigencia'];
  $detalles = $membresia['Detalles'];
  $idPanel = 'prod-' . Inflector::slug($mNombre, '-');
?>

<div class="panel panel-default">
  <a class="panel-heading collapsed block" data-toggle="collapse" data-parent="#<?php echo $idParentPanel; ?>" href="#<?php echo $idPanel; ?>">
    <span class="panel-title">
      <?php echo $mNombre; ?>
      <span class="pull-right">
        <?php echo $this->Number->currency($mCosto); ?>
      </span>
    </span>
  </a>
  <div id="<?php echo $idPanel; ?>" class="panel-collapse collapse">
    <div class="panel-body">
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
      <strong class="money">
        <?php
          echo $this->Number->currency($mCosto);
        ?>
      </strong>
    </div>
    <div class="panel-footer btn-actions">
      <?php
        $isUsed = (int)$membresia['usada'] === 1;

        echo $this->Html->link(__('Editar'), array(
          'admin' => $isAdmin,
          'controller' => 'productos',
          'action' => 'editar',
          'id' => $membresia['membresia_cve'],
          'slug' => Inflector::slug($mNombre, '-')
        ), array(
          'class' => 'btn btn-primary ' . ($isUsed ? 'disabled' : ''),
          'icon' => 'pencil',
          'disabled' => $isUsed ? 'disabled' : false
        ));
      ?>
    </div>
  </div>
</div>