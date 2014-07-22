
<?php 
	$descrip="";
	$titulo="";
	$link=($result['tipodoc_cve'] !=10 ) ? "/ArchivosCan/ver/".$result['docscan_cve'] :$result['docscan_nom'] ;
	$icon="";
	$name=($result['tipodoc_cve'] !=10 ) ? $result['docscan_nom'] :"enlace" ;
	$hide= empty($hide) ? $hide :"";

if ($result['tipodoc_cve'] == 10  ){
	$titulo="Dirección Web";
	$icon="icon-globe";
}

else if ($result['tipodoc_cve'] == 1  ){
	$titulo="Imagen";
	$icon="icon-picture";
}

else if ($result['tipodoc_cve'] == 2  ){
	$titulo="Documento PDF";
	$icon="icon-book";
}
else if ($result['tipodoc_cve'] == 3  ){
	$titulo="Documento WORD";
	$icon="icon-book";
}
?>
<div  id="file-upload<?=$result['docscan_cve']?>" class="span9 pull-left left tabular file-upload archivo<?=$result['tipodoc_cve']?> <?=$hide?> ">
		<label>
			<i class="<?=$icon?>"></i>
			<?=$titulo?>
		</label>
		<a href="<?=$link?>" class="btn btn-info" target="_blank"><i class="<?=$icon?>"></i> <?=$result['docscan_descrip']?></a> 
			<a href="/Portafolio/eliminar/<?=$result['docscan_cve']?>/<?=$result['tipodoc_cve']?>/<?=$name?>" 
				class="file-delete" data-component="ajaxrequest" data-msg-status-ajax="false"  >
				<label class="btn btn-danger"><i class="icon-trash"></i></label>
			</a>
</div>

