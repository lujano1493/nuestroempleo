<?php
  echo $this->element('admin/title');
?>

<ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Configuración', array(
        'admin' => $isAdmin,
        'controller' => 'config',
        'action' => 'index'
      ));
    ?>
  </li>
</ul>

<p class="well well-small info">
  Un catálogo es la lista de opciones que se muestra en algún formulario de <?php echo $this->element('common/logo', array('class' => 'small')); ?>. Sólo puedes cambiar el nombre y secuencia de las opciones de un catálogo. O crear uno nuevo.
</p>

<ul id='catalogo' data-component='catalog' class="nav nav-list">
  <?php foreach ($gpos as $key => $value): ?>
    <li>
      <a href="#" class='select-option'>
        <?php echo $key ?>
        <i class="icon-chevron-right"></i>
      </a>
      <div class="panel" data-key-name="<?= $key ?>">
        <a href="#" class="close"><i class="icon-remove"></i></a>
        <a href="#"><?php echo $key ?></a>
        <ol>
          <?php foreach ($value as $v): ?>
            <li>
              <div class="controls">
                <input type="text" value="<?= $v['opcion_texto'] ?>">
                <input type="text" value="<?= $v['opcion_valor'] ?>" readonly>
              </div>
            </li>
          <?php endforeach ?>
        </ol>
        <a href="#" class="btn btn-small btn-primary">Guardar</a>
      </div>
    </li>
  <?php endforeach ?>
  <li>
    <a href="#">
      <i class="icon-plus"></i>
      Nuevo Catalogo
    </a>
  </li>
</ul>