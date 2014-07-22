<div class="tabla_destacadas span6" >
	<div class="row">
		  {{? !it.privada  }}
          	<img src="{{=it.src}}" class="img-polaroid span1">
         {{??}}
            <img  src="/img/oferta/img_oferta_priv.jpg"  class="img-polaroid span1" >
         {{?}}
		<div class="pull-right"> 
		 	<p>Publicada:
                 <?=$this->Html->link ("{{=it.fecha}} ",array(
                              "controller" => "busquedaOferta",
                              "?" => "publicacion={{=it.fecha}}"
                            ), array(                

                            ) ) ?>    
            </p>
		</div>
	</div>
	<div class="row">

		   <?=$this->Html->link ("{{=it.puesto}}",array(
                      "controller" => "postulacionesCan",
                      "action" => "oferta_detalles",
                      "id" => "{{=it.id}}"
                    ), array(
                      "class"=> "strong ajax",
                      "data-toggle" =>"modal-ajax",
                      "data-target" =>"#oferta_detalles01"

                    ) ) ?>        		
		<p>            {{=it.ciudad}}   , {{=it.estado}}</p>
		<p>
			<i class=" icon-hand-right"></i>&nbsp;{{=it.sueldo}}
		</p>
		<p>
			 {{=it.resumen}}                        
			<br>
			   <?=$this->Html->link ("Ver mas",array(
                        "controller" => "postulacionesCan",
                        "action" => "oferta_detalles",
                        "id" => "{{=it.id}}"
                      ), array(
                        "class"=> "strong ajax",
                        "data-toggle" =>"modal-ajax",
                        "data-target" =>"#oferta_detalles01"

                      ) ) ?>         
		</p>
	</div> 
</div>