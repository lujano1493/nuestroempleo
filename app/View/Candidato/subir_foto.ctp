	
	<?php echo $this->form->create('Candidato',array('type' => 'file'));?> 	
		<?php echo $this->form->input('filename', array('type' => 'file')); ?> 
        <?php echo $this->form->input('dir',array('type'=>'hidden')); ?>
                <?php echo $this->form->end('subir'); ?>