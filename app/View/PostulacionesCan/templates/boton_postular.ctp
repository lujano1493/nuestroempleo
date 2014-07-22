<?=$this->Html->link("<i class=\"icon-thumbs-up\"></i>&nbsp; <span>  Postularse</span>",array(
		"controller" => "postulacionesCan",
		"action" => "postularse",
		"id" => "{{=it.id}}"
	),array(
		"data-component" => "ajaxlink",
		"class" => "btn btn_color btn-large",
		"escape" => false
	))?>
