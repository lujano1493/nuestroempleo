<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">  
  </td>
</tr>
<tr>
    <td style="width:50%; vertical-align:top;">

		<?=$this->Html->image("email/solicitud_encuesta.jpg",
		array(
			    "fullBase"=>true, 
			    "height" => "194px",
			    "width" => "381px"
			))?>
    </td>
	<td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
		¡Agradecemos tu<br>participación!
	</td>
</tr>
<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">  
  </td>
</tr>
<tr>
	<td colspan="2" >
		<p style="text-align:left; padding-left:10px;">
			Estimado(a): <strong><?=$data['nombre_referencia']?></strong>
			
		</p>

		<p style="text-align:justify; padding:10px;">
			Hacemos de su conocimiento que 
			<strong><?=$data['nombre_']?></strong>
			 se encuentra en un proceso de selección de personal,
			  nos ha proporcionado sus datos y solicitamos su colaboración para completar la siguiente:

		</p>
		<p style="text-align:center">
			
			<strong  style="color: #2f72cb;font-weight: bold;font-size: 16px;">
				ENCUESTA DE VERIFICACIÓN DE REFERENCIAS
			</strong>
		</p>

		<p style="text-align:justify; padding:10px;">
		El resultado de esta encuesta, 
		será visualizado por reclutadores interesados en el perfil del candidato en cuestión. 
		El llenado de la encuesta no le llevará más de 5 minutos.<br>Gracias.

		</p>
		<p></p>
		<div style="text-align:center;color:#FFF">
			<p style="padding:15px;width:100px;display:inline">

					<?=$this->Html->link("Ir a la Encuesta",
					array(	
							'controller' => 'EncuestaRef',
							'action' => 'check',
							$data['keycode'],
							$data['refcan_cve'],
							'full_base' => true  ),
							array(
									"style" =>"color:#2f72cb;font-weight:bold" 
						)  )  ?> 
				
			</p>		
		</div>

		<p></p>
			


	</td>
</tr>