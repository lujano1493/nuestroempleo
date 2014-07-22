<div class="articulos_interes">
	<div class="pull-left notas_semblaza left span12" style="margin-left: 10px;margin-bottom:20px;">
<div class="notas_semblaza_tit">
	<img src="{{=it.src}}" class="img-circle"> 

				 <?=$this->Html->link (" {{=it.title}}",array(
			            "controller" => "articulos",
			            "action" => "destacados",
			            "id" => "{{=it.id}}"
			          ), array(
			            "style" => "color:black",
			            "target"=> "_blank"

			          ) ) ?>				
</div>
	<p style="text-align:justify">
		{{=it.descrip}}

 		<?=$this->Html->link (" Leer más",array(
			            "controller" => "articulos",
			            "action" => "destacados",
			            "id" => "{{=it.id}}"
			          ), array(
			            "target"=> "_blank"

			          ) ) ?>	
	</p>
		
</div>
</div>
