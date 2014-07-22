<tr>
	<td colspan="2" style=" background-color:#2f72cb; height:3px;">  
	</td>
</tr>
<tr> 
	<td style="width:50%; vertical-align:top;">

		<?=$this->Html->image("email/pw_foto.jpg",
			array(
				  "fullBase"=>true, 
			      "height" => "194px",
			      "width" => "381px"
				))?>
	</td>

	<td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
		Tu contraseña ha<br>sido cambiada
	</td>
</tr>
<tr>
	<td colspan="2" style=" background-color:#2f72cb; height:3px;">  
	</td>
</tr>

<tr>
	<td colspan="2" style="text-align:center">
		<p class="usuario" style="text-align:right; padding-right:10px;font-weight: bold;">Enviado:  <?php echo date("Y-m-d H:i:s"); ?></p>
		<p>Hemos recibido una solicitud para cambiar tu contraseña, de no ser así, por favor ignora este mensaje.</p>		
		<p>Por favor da clic en el siguiente enlace para continuar con el procedimiento:						
		</p>
		<p>
			<?php
			$newPasswordLink = $this->Html->url('/tickets/' . $hash, true);
			echo $this->Html->link($newPasswordLink, $newPasswordLink,array("style" =>"color:#15c"));
			?>
		</p>
	</td>
</tr>

