<h2><?php echo $errorMessage; ?></h2>
<p class="error">
	<!-- <strong><?php //echo __d('cake', 'Error'); ?>: </strong> -->
	<?php
    printf(
		  __d('cake', 'The requested JSON address %s was not found on this server.'), "<strong>'{$url}'</strong>"
	 );
  ?>
</p>
