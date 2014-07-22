<?=$this->Html->link("<i class=\"icon-remove\"></i>&nbsp; <span>Quitar Postulación</span>",array(
		"controller" => "postulacionesCan",
		"action" => "quitar",
		"id" => "{{=it.id}}"
	),array(
		"data-component" => "ajaxlink",
		"class" => "btn btn-danger btn-large",
		"escape" => false
	))?>