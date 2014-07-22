<h2><?php echo $name; ?></h2>
<p class="error">
	<?php
    printf(
		  __d('cake', 'No tienes permisos para acceder a esta dirección: %s.'), "<strong>'{$url}'</strong>"
    );
  ?>
</p>
