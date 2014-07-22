<tr>
    <td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
</tr>
<tr>
    <td style="width:50%; vertical-align:top;">

	<?=$this->Html->image("email/invitacion.jpg",
    array(
      "fullBase"=>true, 
      "width" => "381px",
      "height" =>"194px"
      ))?>  
	<td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">Cuenta Desactivada<br> de Candidato</td>
</tr>      


<tr>
	<td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
</tr>


<tr>
    <td colspan="2">
    	<p  style="text-align:center;font-weight:bold">
    		Estimado: <?=$usuario?>
    	</p>
		<p style="text-align:center">
			Has desactivado tu cuenta en Nuestro Empleo, tus datos ya no podrán ser vistos por las empresas reclutadoras, si deseas recuperar tu perfil, sigue estos pasos:
		</p>
		<div  height="125px"  style="width:100%;margin:10px;text-align:center">
			<div class="" style="background-color:#ddd;padding:10px;margin:15px;width:25%;display:inline-block">
			<span>

				<?=$this->Html->image("email/sesion.png",
			    	array(
				      "fullBase"=>true, 
				      "width" => "60px",
				      "height" =>"45px"
				      ))?>			
			</span>
			<p  style="font-weight:bold">1. Inicia Sesión con tu usuario y contraseña.
			</p>
			</div>
			<div class=""  height="125px"  style="background-color:#ddd;padding:10px;margin:15px;width:25%;display:inline-block;">
				<span>
					<?=$this->Html->image("email/mi_cuenta.png",
				    	array(
					      "fullBase"=>true, 
					      "width" => "60px",
					      "height" =>"45px"
					      ))?>			
				</span>
				<p  style="font-weight:bold">2. Ingresa al módulo <br>"Mi cuenta".
				</p>
			</div>
			<div class="" height="125px"  style="background-color:#ddd;padding:10px;margin:15px;width:25%;display:inline-block">
				<p style="background-color: #2f72cb;padding: 3px;color: #FFF;font-weight: bold;font-size: 16px">Activar mi cuenta</p>
				<p  style="font-weight:bold">3. Da clic en el botón<br> "Activar cuenta".
				</p>
			</div>
			
		</div>
	
  		<p style="text-align:center">Recuerda mantener tu información actualizada.</p>
  		<p style="text-align:center">El equipo de Nuestro Empleo agradece tu preferencia</p>
  	</td>
</tr>