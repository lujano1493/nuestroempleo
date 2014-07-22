<?php
  echo $this->element('empresas/title');
?>

<div class="row">
  <div class="col-xs-12">
    <h5 class="subtitle">
      <?php echo __('Instrucciones'); ?>
    </h5>
    <p>Comprar en nuestra Tienda en Línea es muy sencillo, únicamente debes seguir estos pasos:</p>
    <ol>
      <li>Selecciona uno de nuestros productos y da clic en Agregar al carrito.</li>
      <li>Una vez agregados los productos que deseas, ve al Carrito de Compras desde el menú lateral o bien, desde el ícono que aparece en el menú superior derecho.</li>
      <li>Revisa los productos que has elegido y haz modificaciones si es necesario.</li>
      <li>Una vez que tengas el producto que deseas, elige un  Método de pago.</li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Conoce nuestras Membresías Promocionales'), array(
          'controller' => 'mis_productos',
          'action' => 'promociones'
        ), array(
          'class' => 'btn btn-primary btn-lg'
        ));
      ?>
    </div>
  </div>
</div>
<div class="catalogo">
  <?php if (empty($membresias)): ?>
    <?php
      echo $this->element('common/alert', array(
        'class' => 'alert-info',
        'message' => __('Felicidades. Ya adquiriste todos nuestros productos.')
      ));
    ?>
  <?php else: ?>
    <?php foreach ($membresias as $clase => $_ms): ?>
      <div class="m-clas">
        <h5 class="subtitle">
          <?php
            $firstItem = current($_ms);
            $isMembresia = $firstItem['membresia_clase'] === 'mbs';
            $element = $isMembresia ? 'empresas/carrito/membresia' : 'empresas/carrito/panel';
            echo $this->Html->tag('i', '', array(
              'class' => 'icon-' . $firstItem['membresia_clase']
            )) . $clase;
          ?>
        </h5>
        <?php
          $chunks = array_chunk($_ms, 2);
          foreach ($chunks as $key => $value) {
        ?>
          <div class="row">
            <?php foreach ($value as $k => $v) { ?>
              <div class="<?php echo $isMembresia ? 'col-xs-12' : 'col-xs-6'; ?>">
                <?php
                  echo $this->element($element, array(
                    'membresia' => $v //['Membresia']
                  ));
                ?>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>