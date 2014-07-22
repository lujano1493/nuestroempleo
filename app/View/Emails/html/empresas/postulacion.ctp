<tr>
    <td style="width:50%; text-align:left;">
      <?php
        echo $this->Html->image('assets/logo.jpg', array(
          'fullBase' => true,
          'width' => 210,
          'height' => 81,
          'url' => Router::url('/', true)
        ));
      ?>
	</td>
    <td style="width:50%;">
    	<p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px">Postulaciones</p>
    </td>
</tr>
<tr>
	<td colspan="2" style=" background-color:#49317b; height:3px;"></td>
</tr>

<tr>
	<td style="width:50%; vertical-align:top;">
		  <?=$this->Html->image("email/postulacion.jpg",
				    array(
				      "fullBase"=>true,
				      "width" => "381px",
				      "height" =>"194px"
				      ))?>
	</td>
	<td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
		Notificación de <br>Postulación de Candidatos
	</td>
</tr>

<tr>
	<td colspan="2" style=" background-color:#49317b; height:3px;"></td>
</tr>
<tr>
    <td colspan="2">
		<p style="text-align:center">Usted tiene
			<span style="color: #49317b;font-weight: bold;font-size: 16px;">
				<?=$num?>
			</span>
			 postulaciones para la vacante de
		</p>
		<p style="color: #49317b;font-weight: bold;font-size: 16px;text-align:center">
			<?=$nombre?>
		</p>
		<p style="text-align:center">
			Publicada el día
			<strong>
				<?=$publicado?>
			</strong>
		</p>
		<div style="text-align:center;background-color: #49317b;color: #fff;font-size: 14px;font-weight: bold;padding: 10px 0 10px 0">
			Detalles de los candidatos
		</div>

		
		
	</td>	
</tr>


<?php foreach ($postulantes as $i=> $v):
		$color= $i % 2 === 0 ? "#DDD":"#FFF";?>				
		<?=$this->element("email/postulacion_detalle",array("data" =>$v,"background"=> $color))?>
<?php endforeach;?>



<tr>
	<td colspan="2">
		<p style="text-align:center">
			Entre al portal de Nuestro Empleo para ver los detalles de cada postulación.
			<br>
			<br>
			Gracias por su preferencia.
		</p>
		<br>
		<br>
	</td>

</tr>