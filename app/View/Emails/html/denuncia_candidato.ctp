<tr>
	<td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
</tr>
<tr>
	<td style="width:50%; vertical-align:top;">

		 <?=$this->Html->image("email/invitacion.jpg",
		    array(
		      "fullBase"=>true, 
		      "width" => "381",
		      "height" =>"190"
		      ))?>

	</td>
	<td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
		¡Tu currículum<br>ha sido reportado!
	</td>
</tr>
<tr>
	<td colspan="2" style="background-color:#2f72cb; height:3px;"></td>
</tr>


<tr>
	<td colspan="2" style="text-align: center;" >
		<p style="font-weight: bold;text-align: center;">Estimado: <?=$candidato['Candidato']['nombre_']?>  </p>
		<p style="text-align: center;">
			<span class="destacar">Tu Currículum ha sido reportado</span> 
			por una empresa debido a  que ha encontrado anomalías en tu perfil.<br><br></p>
		<p  style="text-align: left;padding: 15px 15px 15px 15px;background-color: #ddd;">
			En  los siguientes días un Ejecutivo de Verificación revisará tu información para corroborar el reporte, de incurrir en una falta, tu Currículum será eliminado de la base de datos. Si no existe ninguna anomalía, tu perfil permanecerá visible para las empresas, por favor revisa tu información lo antes posible.</p>
			<br>
		<p style="text-align: center;">
			Para mayor información escríbanos a 
			<a  style="color: #2f72cb;text-decoration: none;font-weight: bold;"href="mailto:contacto.ne@nuestroempleo.com.mx">
				contacto.ne@nuestroempleo.com.mx
			</a> 
			o comunícate con nosotros al 01-800-849-24-87<br><br>
			El equipo de Nuestro Empleo agradece tu preferencia.<br>
			<strong>DEPARTAMENTO DE VERIFICACIÓN</strong>
		</p>
	</td>
</tr>