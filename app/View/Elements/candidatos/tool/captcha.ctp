<div class='row-fluid captcha' >
	<div class="span3 offset3 image_" >
		<div > 	&nbsp; </div>
		<img width="165px" height="50px" class='image_captcha'  src="<?php echo $this->webroot?>Uploads/refresh_captcha"/>
		<a href="#" class='refresh_image_captcha'>  <i class="icon-refresh" style="font-size:22px"></i>   </a>
	</div>
	<div>
		
	</div>
	<div class="span2" >
		<label for="codigo" >Escribe el C&oacute;digo </label> 
		<input type="text" class="input-small" value="" maxlength="5" size="5" id="codigo01"  name="data[Candidato][codigo]" data-rule-remote="/Uploads/validate_captcha" data-msg-remote="código de verificación no válido" data-rule-required="true" data-msg-required="Ingresa código de verificación" />
	</div>				
</div>

