<?php
  echo $this->element('empresas/title');
?>
<?php 
  echo $this->Form->create('Carpeta', array(
    'class' => 'form-inline no-bordered container',
    'data-component' => 'elastic-input'
  ));
?>
  <fieldset>
    <div class="row-fluid">
      <div class="span6 offset3">
        <?php 
          echo $this->Form->input('carpeta_nombre', array(
            'label' => 'Nombre de la carpeta',
            'placeholder' => 'Ingresa el nombre de la carpeta'
          ));
        ?>
      </div>
    </div>
    <?php if (!empty($carpetas)): ?>
      <div class="row-fluid">
        <div class="span6 offset3">
          <?php 
            echo $this->Form->input('carpeta_cvesup', array(
              'label' => 'Subfolder:',
              'empty' => true,
              'options' => $carpetas
            ));
          ?>
        </div>
      </div>  
    <?php endif; ?>
    <div class="row-fluid">
      <div class="span6 offset3">
        <?php 
          echo $this->Form->input('tipo_cve', array(
            'label' => 'Tipo de Carpeta',
            'placeholder' => 'Ingresa el nombre de la carpeta',
            'options' => $tipos/*array(
              'Quiero organizar mis candidatos', 'Quiero organizar mis ofertas'
            )*/
          ));
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?php 
          echo $this->Form->submit('Aceptar', array(
            'class' => 'btn btn-primary btn-large',
            //'disabled' => true,
            'div' => false
          ));
        ?>
      </div>
    </div>
  </fieldset>
<?php
  echo $this->Form->end();
?>