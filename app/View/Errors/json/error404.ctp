<h2><?php echo $name; ?></h2>
<p class="error">
	<?php
    printf(
		  __d('cake', 'La url %s no existe. Verifica si es correcta.'), "<strong>'{$url}'</strong>"
    );
  ?>
</p>
