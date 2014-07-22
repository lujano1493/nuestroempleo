<?php
  echo $this->element('empresas/title');
?>
<div class="row">
  <div class="col-xs-12">
    <?php foreach ($membresias as $clase => $_ms): ?>
      <div class="m-clas">
        <h5 class="subtitle">
          <?php
            $firstItem = current($_ms);
            $isMembresia = $firstItem['membresia_clase'] === 'mbs';
            $element = 'empresas/carrito/membresia_promocion';
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
              <div class="col-xs-6">
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
  </div>
</div>