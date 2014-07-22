<style>
	body {
	  	background-color:#e8e4e3;
	    text-align: center;
	    font-family: 'Open Sans', Helvetica, Arial, sans-serif;
	    /*color: #888;*/
	    font-size: 13px; color:#4e4f53;
	}
	a {
		color:#2f72cb; 
		text-decoration:none;
		font-weight:bold;
	}	  
</style>
<?php 
			$url=Router::fullBaseUrl();
?>    
 
<tr>
      <td colspan="2">
      	<p style=" font-weight:bold; font-size:24px;color:#2f72cb; text-align:center;">
			 Hola <?=$data['usuario']['CandidatoUsuario']['nombre']?> <br> ¿Aún no has actualizado tu perfil?  <br>
      		¡Deja que Nuestro Empleo haga todo por ti!
      	</p>
      </td>
</tr>
<tr>
	<td style="background-image:url(<?=$url?>/img/email/fondo.jpg); background-repeat:repeat;text-align:center">
			<img src="<?=$url?>/img/email/cv_img.png" width="350" height="400" style="margin-top:20px;text-align:center;">
	</td>
	<td style="background-image:url(<?=$url?>/img/email/fondo.jpg); background-repeat:repeat;text-align:center">
		<p style="font-size:16px;font-weight:bold;padding:0 10px 0 10px;text-align:center">
			Actualiza tus datos para tener más oportunidades de empleo, así tu perfil será más atractivo para los reclutadores. 
			<br> <br>
				Nuestro Empleo te da una plantilla de CV para que la imprimas
		</p>
		<p style=" font-size:16px;font-weight:bold;">
			    <?=$this->Html->link("¡Llenar la plantilla ahora!",array(
			        'controller' => 'candidato',
			        'action' => 'iniciar_sesion',
		        	$data['usuario']['CandidatoUsuario']['keycode'],          
		        'full_base' => true  
		      ),array(
		        "class"=>"btn_color btn-large",
		        'style' => 'color:#2f72cb;text-decoration:none;font-weight:bold;'
		         )  )  ?> 
  		</p>
	</td>
</tr>
<tr>
	<td style="background-image:url(<?=$url?>/img/email/fondo.jpg); background-repeat:repeat;">
		<!-- <p style="background-color:#2f72cb;padding:3px;color:#FFF;font-weight:bold;font-size:16px;">Tus datos:</p>
		<p><strong>Usuario:</strong> XXXXXXXXX</p>
		<p><strong>Contraseña:</strong> XX00XXXXXX00X</p> -->
	</td>
  	<td style="background-image:url(<?=$url?>/img/email/fondo.jpg); background-repeat:repeat;">  	
  		<div>
  			<a href="https://www.facebook.com/NuestroEmpleo" > <img src="<?=$url?>/img/email/facebook.jpg" width="43" height="43"> </a>
  			<a href="https://plus.google.com/111610607829310871158/posts" > <img src="<?=$url?>/img/email/gmas.jpg" width="43" height="43"></a>
  			<a href="http://mx.linkedin.com/company/nuestro-empleo" > <img src="<?=$url?>/img/email/in.jpg" width="43" height="43"> </a>
  			<a href="https://twitter.com/NuestroEmpleo" > <img src="<?=$url?>/img/email/twitter.jpg" width="43" height="43"> </a>
  		</div>
  	</td>
</tr>