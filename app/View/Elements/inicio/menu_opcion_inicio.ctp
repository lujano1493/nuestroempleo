<?php 		
	   $class_active="menu-active";
	   $name="/".strtolower($this->name);
	   $curren_page=strtolower( $name."/".$this->action);
	   $is_corrent_page=false;
	$menu_arr=array();
	foreach ($submenu as  $opcion_menu) {
		$atr="";
		foreach ($opcion_menu['atributos'] as $key => $data) {
			if($key==='class'|| $key==='href')
					continue;
			$atr.= "$key=\"$data\"";
			
		}
		if(isset($opcion_menu['change_atr'])&&isset($opcion_menu['atr_extras']) && $opcion_menu['change_atr']===true){

			$current_page=$this->name."/".$this->action;
			$atr_extras_arr= $opcion_menu['atr_extras'];
			$atr_extras_arr=!is_array($atr_extras_arr) ?array():$atr_extras_arr;


			if(!empty($atr_extras_arr)){
				$atr_ext_arr=
					isset($atr_extras_arr[$current_page]) ?
					$atr_extras_arr[$current_page]: ( isset($atr_extras_arr['default']) ? 
																				$atr_extras_arr['default']:array() );

					

				foreach ($atr_ext_arr as $key =>$info) {
					if($key==='class'|| $key==='href')
						continue;
					 $atr.= "$key=\"$info\"";
				}
			}

		}	

		$href= isset($opcion_menu['atributos']['href']) ?$opcion_menu['atributos']['href']:"";		
		$class= isset($opcion_menu['atributos']['class']) ?$opcion_menu['atributos']['class']:"";
		$opcion_current="";

		

		if($curren_page=== strtolower($href)){
			$opcion_current=$class_active;
			$is_corrent_page= !$is_corrent_page ? true:$is_corrent_page;
		}
		

		/*controlando bug*/
		if(($icono==="group" &&     $curren_page==="/info/preguntas_frecuentes_candidato") ||
			($icono==="briefcase" &&   $curren_page==="/info/preguntas_frecuentes_empresas")
		 ){
			$opcion_current="";
			$is_corrent_page=false;
		}

		$title=$opcion_menu['titulo'];
		$link= "<li> <a href=\"$href\" class=\"$class $opcion_current\"  $atr > $title	</a> </li> ";
		$menu_arr[]=$link;
			
	}
	

?>


<li class="dropdown menu_li"> 
	<a   class="dropdown-toggle <?= $is_corrent_page ? $class_active:""?>" data-toggle="dropdown" href="#">
		<i class="icon-<?=$icono?>">
			
		</i>
	</a>
		<br /> <?=$titulo?>
	<ul class="dropdown-menu" id="swatch-menu">
		<?php foreach($menu_arr as $opcion ): ?>
		<?=$opcion?>		
		<?php endforeach;?>
		
	</ul>
</li>    