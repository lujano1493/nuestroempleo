 <span>

 		<?=$this->Html->link ("{{=it.puesto}}",array(
			            "controller" => "postulacionesCan",
			            "action" => "oferta_detalles",
			            "id" => "{{=it.idOferta}}"
			          ), array(
			            "data-toggle" => "modal-ajax",
			            "data-target"=> "#oferta_detalles01",
			            "data-component" => "tooltip",
			            "data-placement" => "top",
			            "title" => "Ver detalles de la oferta"

			          ) ) ?>	
 	</a>
 </span>