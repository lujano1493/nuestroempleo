<?php
  echo $this->element('admin/title');
?>

<div class="row">
  <div class="col-xs-12">
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Nuevo Producto'), array(
          'admin' => $isAdmin,
          'controller' => 'productos',
          'action' => 'nuevo'
        ), array(
          'class' => 'btn btn-success',
          'icon' => 'ok'
        ));
      ?>
    </div>
  </div>
</div>
<div class="catalogo-productos">
  <?php foreach ($membresias as $clase => $_ms): ?>
    <div class="m-clas">
      <h5 class="subtitle">
        <?php
          $firstItem = current($_ms);
          $element = /*$firstItem['membresia_clase'] === 'mbs' ? 'admin/productos/membresia' :*/ 'admin/productos/panel';
          echo $this->Html->tag('i', '', array(
            'class' => 'icon-' . $firstItem['membresia_clase']
          )) . $clase;
          $idPanel = 'accordion-' . $firstItem['membresia_clase'];
        ?>
      </h5>
      <div class="panel-group" id="<?php echo $idPanel; ?>">
        <?php foreach ($_ms as $k => $v) { ?>
          <!-- <div class="panel panel-default"> -->
            <?php
              echo $this->element($element, array(
                'membresia' => $v, //['Membresia']
                'idParentPanel' => $idPanel
              ));
            ?>
          <!-- </div> -->
        <?php } ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>