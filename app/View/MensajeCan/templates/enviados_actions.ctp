 <div class="btn-group">

 	 	<?=$this->Html->link(" <i class='icon-envelope-alt'></i>",
	 		array("controller" => "mensajeCan", "action" => "ver" ,"id" =>  "{{=it.id}}","enviados" ),
	 		array(
 			"data-toggle"=>"tooltip",
 			"title" => "Ver",
 			"class" => "btn btn_color btn-small",
 			"escape" => false,
 		))?>
 	<?=$this->Html->link(" <i class='icon-reply-all'></i>",array(
 		"controller" => "mensajeCan",
 		"action" => "reenviar",
 		"id" => "{{=it.id}}"),array(
 			"data-toggle"=>"tooltip",
 			"title" => "Reenviar",
 			"class" => "btn btn_color btn-small",
 			"escape" => false,
 		))?>
   
  </div>