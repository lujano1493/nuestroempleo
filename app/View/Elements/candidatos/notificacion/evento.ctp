<?php
  App::import("Vendor", array("funciones"));

	$ntfy = $data['Notificacion'];
	$from = $data['From'];
	$urlLink = $ntfy['notificacion_controlador'];
	$urlImg = '';
	if (!empty($from['cia_cve'])) {
		$urlImg = Funciones::check_image_cia($from['cia_cve']);
	}
	$title = $ntfy['notificacion_titulo'];
	$text = $ntfy['notificacion_texto'];
	$unreadClass = $ntfy['notificacion_leido'] == 0 ? 'unread' : '';
?>

<div class='ntfy <?php echo $unreadClass; ?>' data-id="<?= $ntfy['notificacion_cve'] ?>">
	<img src="<?= $urlImg ?>">
	<div class="ntfy-body">
		<?php
			echo $this->Html->link(__('%s (%s)', $from['nombre'], $from['email']), '#', array(
				'icon' => 'user',
			));
		?>
		<strong class="title"><?= $title ?></strong>
		<small><?= $text ?></small>
	</div>
	<div class="ntfy-footer">
		<?php
			echo $this->Html->link($this->Time->dt($ntfy['created']), $urlLink, array(
				'icon' => 'time',
				'class' => 'block ' . $unreadClass
			));
		?>
	</div>
</div>
