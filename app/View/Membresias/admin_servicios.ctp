<?php
  echo $this->element('admin/title');
?>
<ul class='unstyled inline-list'>
  <?php if (!empty($servicios) && count($servicios) > 0): ?>
    <?php
      foreach ($servicios as $servicio):
        $s = $servicio['Servicio'];
    ?>
      <li>
        <?php echo $s['servicio_nom']; ?> - $<?php echo $s['servicio_precio']; ?>
      </li>
    <?php endforeach ?>
  <?php else: ?>
    <li><span>No cuentas con ningún servicio</span></li>
  <?php endif; ?>
  <li>
    <?php
      echo $this->Form->create('Servicio', array(
        'class' => 'form-inline',
        //'data-component' => 'ajaxform'
      ));
      ?>
      <div class="input-append">
        <?php
          echo $this->Form->input('Servicio.servicio_nom', array(
            'div' => false,
            'label' => false,
            'placeholder' => 'Agrega un nuevo servicio'
          ));
          echo $this->Form->input('Servicio.servicio_precio', array(
            'div' => false,
            'label' => false,
            'placeholder' => 'Precio Unitario'
          ));
          echo $this->Form->input('Servicio.identificador', array(
            'div' => false,
            'label' => false,
            'placeholder' => 'Alias'
          ));
          echo $this->Form->submit('Aceptar', array(
            'div' => false,
            'class' => 'btn'
          ));
        ?>
      </div>
      <?php
      echo $this->Form->end();
    ?>
  </li>
</ul>