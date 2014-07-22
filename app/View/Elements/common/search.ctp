<?php
  echo $this->Form->create(false, array(
    'url' => array('controller' => 'busqueda', 'action' => 'index', 'ext' => 'json'),
    'type' => 'get',
    'class' => 'search form-inline',
    'id' => 'search-form'
  ));
?>
  <?php
    $submitBtn = $this->Form->submit(' ', array(
      'class' => 'hide',
      'id' => 'submit',
      'div' => false,
      'before' => '<label for="submit"><i class="icon-search"></i></label>'
    ));

    echo $this->Form->input('q', array(
      'after' => $submitBtn,
      'div' => 'input text clearfix',
      'id' => 'query',
      'label' => false,
      'placeholder' => 'Ingresa lo que deseas buscar',
      'type' => 'search'
    ));
  ?>
  <div class="input link">
    <?php
      echo $this->Html->link('Búsqueda Avanzada', array(
        'controller' => 'busqueda'
      ));
    ?>
  </div>
<?php echo $this->Form->end(); ?>