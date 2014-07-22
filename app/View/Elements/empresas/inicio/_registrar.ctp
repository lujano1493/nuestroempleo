
<div class="wrapper form">
<?php echo $this->Session->flash(); ?>
<?php
	echo $this->Form->create('Empresa',	array(
		'class' => 'clearfix form-inline no-bordered',
    'data-component' => 'elastic-input ajaxform',
    'id' => 'empresa-registrar',
		'url' => array('controller' => 'empresas', 'action' => 'registrar'),
    //'novalidate' => true
	));
?>
	<fieldset>
	  <legend>Registro de Empresas</legend>
	  <div class="row-fluid">
	  	<div class="span4">
	  		<?php echo $this->Form->input('Empresa.cia_nombre', array(
	  			'icon' => 'briefcase',
	      	'placeholder' => 'Nombre de tu Empresa',
	      	'required' => true
	     		));
	  		?>
	  	</div>
	  	<div class="span4">
	  		<?php echo $this->Form->input('Empresa.cia_rfc', array(
	  			'label' => false,
	      	'placeholder' => 'RFC',
	      	'required' => true
	     		));
	  		?>
	  	</div>
	  	<div class="span4">
	  		<?php echo $this->Form->input('Empresa.cia_tel', array(
	  			'icon' => 'phone',
	      	'placeholder' => 'Teléfono de la Empresa',
	      	'required' => false
	     		));
	  		?>
	  	</div>
	  </div>
    <div class="row-fluid">
      <div class="span4">
        <?php echo $this->Form->input('UsuarioEmpresa.cu_sesion', array(
          'icon' => 'envelope',
          'placeholder' => 'Correo Electrónico',
          'required' => true,
          'type' => 'email'
        )); ?>
      </div>
      <div class="span4">
        <?php
          echo $this->Form->input('Empresa.giro_suggest', array(
            'label' => false,
            'id' => 'giros'
          ));
          echo $this->Form->input('Empresa.giro_cve', array(
            'label' => false,
            'placeholder' => 'Giro de la Empresa',
            'type' => 'hidden',
          ));
        ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('Empresa.cp', array(
          // 'data-component' => 'sourcito',
          'data-source-name' => 'codigo_postal',
          'icon' => 'map-marker',
          'max' => '99999',
          'min' => '0',
          'pattern' => '[0-9]*',
          'placeholder' => 'Código Postal',
          'required' => true,
          'type' => 'number'
        )); ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <?php echo $this->Form->input('Empresa.estado', array(
          'data-json-name' => 'estado',
          'icon' => 'map-marker',
          'placeholder' => 'Estado',
          'disabled' => true
        )); ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('Empresa.ciudad', array(
          'data-json-name' => 'municipio',
          'icon' => 'map-marker',
          'placeholder' => 'Ciudad',
          'disabled' => true
        )); ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('Empresa.colonia', array(
          'data-json-name' => 'colonias',
          'empty' => '↑ Primero escriba el Código Postal',
          'icon' => 'map-marker',
          'placeholder' => 'Colonia',
          'required' => true,
          'type' => 'select'
        )); ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <?php echo $this->Form->input('UsuarioEmpresaContacto.nombre', array(
          'icon' => 'user',
          'placeholder' => 'Nombre(s)',
          'required' => true
        )); ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('UsuarioEmpresaContacto.ape_paterno', array(
          'label' => false,
          'placeholder' => 'Apellido Paterno',
          'required' => true
        )); ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('UsuarioEmpresaContacto.ape_materno', array(
          'label' => false,
          'placeholder' => 'Apellido Materno',
          'required' => false
        )); ?>
      </div>
    </div>
	  <div class="row-fluid">
	  	<div class="span6 offset6">
	  		<?php
          if (!$isAdmin) {
            echo $this->Html->image('/uploads/refresh_captcha', array('alt' => 'catpcha'));
            echo $this->Form->input('UsuarioEmpresa.captcha', array(
              'label' => false,
              'placeholder' => 'CAPTCHA',
              'required' => true
            ));
            echo $this->Form->input('terminos', array(
              'label' => 'Acepto términos y condiciones.',
              'required' => true,
              'hiddenField' => false,
              'type' => 'checkbox'
            ));
          }
          echo $this->Form->submit('Crear mi cuenta', array(
            'class' => 'btn btn-primary btn-large pull-right',
            'div' => false
          ));
				?>
	  	</div>
	  </div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
