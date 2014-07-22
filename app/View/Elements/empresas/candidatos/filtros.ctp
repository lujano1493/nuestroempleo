<?php
      //elmento
	$dato = "";
	if (array_key_exists("dato", $param_query)) {
		$dato = $param_query['dato'];
	}
?>
<div class="destacadas_candidato">
  <div class="destacadas_candidato-title">
    <h4><?php echo __('Criterios de búsqueda'); ?></h4>
  </div>
</div>
<div class="filtros-busqueda" data-request="<?=$tipo_?>" data-component="linkconcat" data-callback-refresh-element='[{"type":"datatable","target":"#busqueda-candidato"}]' data-param-search-ini="<?=$dato?>" data-url-filter="/candidatos/filtros">
  <div class="destacadas_candidato2_2_back target-load">
   <?= $this->element("empresas/candidatos/filtroc"); ?>
  </div>
</div>