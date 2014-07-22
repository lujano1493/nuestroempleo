<h2><?php echo $name; ?></h2>
<p class="error">
	<!-- <strong><?php //echo __d('cake', 'Error'); ?>: </strong> -->
	<?php
    printf(
		  __d('cake', 'Sesión expirada: %s. Vuelve a iniciar sesión.'), "<strong>'{$url}'</strong>"
    );
  ?>
</p>
