

<?php 
      //elmento 
	$dato="";
	if ( array_key_exists("dato",$param_query) ){
		$dato=$param_query['dato'];
	}


?>

<div class="destacadas_candidato">
   <div class="destacadas_candidato-title"><h4>Criterios de búsqueda</h4></div>
</div>
<div class="clearfix filtros-busqueda " data-request="<?=$tipo_?>"  data-component="linkconcat" data-callback-refresh-element='[{"type":"datatable","target":"#ofertas-table"}]' data-param-search-ini="<?=$dato?>" data-url-filter="<?=$this->Html->url(array("controller" => "busquedaOferta","action" => "filtros"))?>"   >
      <div class="destacadas_candidato2_2_back  target-load">
         <?=$this->element("candidatos/filtro")?>
      </div>
</div>
