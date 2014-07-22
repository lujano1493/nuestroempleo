<div class="btn-group">

		<?=$this->Html->link("<i class='icon-ok'></i>",
			array(
				"controller"=>"mensajeCan",
				"action"=>"restaurar",
				"id" => "{{=it.id}}"
				),
			array(
					"class" =>"btn btn_color btn-small",
					"data-toggle" => "tooltip",
					"data-component" => "ajaxlink",
					"data-action-role" => "delete",
					"data-placement" => "top",
					"title" => "Restablecer",			
					"escape" => false
			))?>   

		<?=$this->Html->link("<i class='icon-minus-sign'></i>",
			array(
				"controller"=>"mensajeCan",
				"action"=>"eliminar_completamente",
				"id" => "{{=it.id}}"
				),
			array(
					"class" =>"btn btn-danger btn-small",
					"data-toggle" => "tooltip",
					"data-component" => "ajaxlink",
					"data-action-role" => "delete",
					"data-placement" => "top",
					"title" => "Borrar permanente",			
					"escape" => false
			))?>   
  </div>