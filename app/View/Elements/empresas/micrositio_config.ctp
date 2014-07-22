<?php
  echo $this->Form->create('MicroSitio', array(
    'class' => 'form-inline no-lock',
    'url' => array(
      'controller' => 'mi_espacio',
      'action' => 'micrositio'
    )
  ));
?>
  <fieldset>
    <legend class="subtitle">
      <i class="icon-file-text"></i><?php echo __('Agrega una breve reseña acerca de tu Empresa'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('MicroSitio.cia_descrip', array(
            'class' => 'form-control input-sm input-block-level',
            'data-component' => 'wysihtml5-editor',
            // 'data-target-name' => 'oferta-desc',
            // 'placeholder' => __('Agregue las características de su oferta.'),
            'style' => 'height: 250px;',
            'type' => 'textarea',
            'label' => false
          ));
        ?>
      </div>
    </div>
    <div class="btn-actions text-right">
      <?php
        echo $this->Html->link(__('Aceptar'), '#', array(
          'class' => 'btn btn-success',
          'data-submit' => true
        ));
      ?>
    </div>
  </fieldset>
<?php echo $this->Form->end(); ?>
<?php
  $this->AssetCompress->css('editor.css', array(
    'inline' => false,
    'id' => 'editor-css-url'
  ));

  $this->AssetCompress->script('editor.js', array(
    'inline' => false
  ));
?>

