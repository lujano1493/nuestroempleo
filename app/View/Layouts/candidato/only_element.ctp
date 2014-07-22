<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title_for_layout; ?></title>
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->charset();
			echo $this->Html->css(array('bootstrap', 'jquery-ui' ,'main','validation/screen'));
			echo $this->Html->css(array('candidatos/publicidad/espacio_pu'));
			echo $this->fetch('meta');			
			echo $this->Html->script('modernizr.custom.min');
		?>
	</head>
	<body>
		<div class="wrapper">
			<div class="container">
				<div class="row-fluid no-top" id="main-content">
					<div class="span12">
						<?php echo $this->fetch('content'); ?>
					</div>
				</div>
			</div>
		</div>		
		<?php 
			echo $this->Html->script(array('jquery.min', 'jquery-ui-1.9.2.custom', 'bootstrap/alert'));
			echo $this->fetch('script'); 
			echo $this->fetch('css');
		?>
	</body>
</html>