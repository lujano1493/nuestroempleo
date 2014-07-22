

<?php if ($action == 'change_select'):  ?>
	<?php if ($select_object == 'municipio'):  ?>
		<?php foreach ($municipios as $key => $value): ?>
			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
		<?php endforeach; ?>
	<?php endif ?>
<?php endif ?>