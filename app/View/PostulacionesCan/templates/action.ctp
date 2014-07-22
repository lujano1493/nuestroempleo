 <div class="btn-group">

 	<?=$this->Html->link('<label class="btn btn-danger"><i class="icon-trash"></i></label>',array(
 		"controller" => "postulacionesCan",
 		"action" => "eliminar",
 		"id" => "{{=it.id}}"
 	),array(
 	"escape" => false,
 	"data-component" => "tooltip ajaxlink",
 	"title" => "Eliminar postulación",
 	"data-action-role"=> "delete") )?>
 
 <?=$this->Html->link('<label class="btn btn-info"><i class="icon-file-text"></i></label>',array(
 		"controller" => "postulacionesCan",
 		"action" => "oferta_detalles",
 		"id" => "{{=it.idOferta}}"
 	),array(
 	"escape" => false,
 	"data-toggle" => "modal-ajax",
 	"data-target" => "#oferta_detalles01",
 	"data-component" => "tooltip",
 	"title"=> "Ver detalles de la oferta",
 	"data-placement" => "top"

 	) )?>


  
  </div>
