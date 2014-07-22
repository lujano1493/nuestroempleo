<div class="container">







<?php 
	
		$url=$articulo['guid'];


			
			if($articulo['img_src']!==false ){
				$this->Html->meta(array("property"=>"og:image","content" =>$articulo['img_src']   ),null, array('inline' => false));
			}
?>
<iframe   src="<?=$url?>" width="100%" height="600px" frameborder="0" scrolling="auto" onload='javascript:resizeIframe(this);' marginheight="0" marginwidth="0" > 
	<p>Your browser does not support iframes.</p>
</iframe>



<?php 

		 $script=
		  'function resizeIframe(obj) {  	 			
				  obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";    	
		  }
		  ';
			$this->Html->scriptBlock($script,array("inline"=>false));


?>
</div>
