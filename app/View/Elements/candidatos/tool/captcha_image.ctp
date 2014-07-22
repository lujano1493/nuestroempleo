


<div class="captcha-image">

	<div class="area-captcha" data-component="visualcaptcha">				
	<?php 
    if ($status) {
      $this->VisualCaptcha->show(); 
    } else {
      $this->VisualCaptcha->only_show();
    }
	?>  
	</div>


	<p>
		<span class="btn_color btn-link refresh-captcha-image">
			<i class=" icon-refresh"> </i> Refresca 
		</span>

	</p>


</div>
