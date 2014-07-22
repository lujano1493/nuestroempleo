  <div class="btn-group">
	 	<?=$this->Html->link(" <i class='icon-envelope-alt'></i>",
	 		array(
	 				"controller" => "mensajeCan", 
	 				"action" => "ver" ,
	 				"id" =>  "{{=it.id}}"),
	 		array(
 			"data-toggle"=>"tooltip",
 			"title" => "Ver",
 			"style" => "margin-right:5px",
 			"class" => "btn btn_color btn-small",
 			"escape" => false,
 		))?>
	<?=$this->Html->link("<i class='icon-share-alt'></i>",
	array(
		"controller"=>"mensajeCan",
		"action"=>"responder",
		"id" => "{{=it.id}}"),
	array(
			"class" => "btn btn_color btn-small",
			"data-toggle" => "tooltip",
			"style" => "margin-right:5px",
			"title" => "Responder",
			"escape" => false
	))?>

		<?=$this->Html->link("<i class='icon-trash'></i>",
	array(
		"controller"=>"mensajeCan",
		"action"=>"eliminar",
		"id" => "{{=it.id}}"),
	array(
			"class" =>"btn btn-danger btn-small",
			"data-toggle" => "tooltip",
			"data-component" => "ajaxlink",
			"data-action-role" => "delete",
			"data-placement" => "top",
			"title" => "Eliminar",			
			"escape" => false
	))?>   
  </div>
