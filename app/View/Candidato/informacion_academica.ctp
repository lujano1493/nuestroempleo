<?php echo $this->html->css(array('jquery-ui','validation/screen'));  ?>
<div class="span9">
	<?php echo $this->element('menu_candidato'); ?>	
	<?php echo $this->form->create('DirPersona',array('id' => 'form_dir_persona',
	'url' => array('controller' => 'candidatos', 'action' => 'domicilio_actual'),'class'=>'sliding clearfix'));?>
	<?php echo $this->Session->flash(); ?>

	<fieldset>
				
    </fieldset>
	 
</div>
<?php $this->Html->script(array (
									'jquery.validate',
									'jquery-ui-1.9.2.custom',
									'configurar',
									'candidatos/academica'
								), array('inline' => false)); ?>