
<?php

	$descartes=array(
						"estado",
						"categoria"
		);


   if(!$is_empty)	 :
	  foreach ($data_conditions as $value) :

	  	$flag=false;
	  	foreach ($params_name as $key) {
			  if( $value['name'] == $key ){
			  			$flag=true;

			  	}
	  		
	  	}

	  	if(!$flag  || in_array($value['name'], $descartes) ){
	  			continue;
	  	}	 
	  	$field_query=$value['name'];
	  	$value_query=$value['value'];
	
?>

<p class="filtro-select ellipsis" style="width:150px;display:inline"> 
	<span class="badge badge-info">
		 <button type="button" class="delete-filter" data-value="<?=$value_query?>" data-query="<?=$field_query?>" >×</button>
		<a href="#" class="<?=$field_query?>" title="<?=$value_query?>"  data-placement="bottom"  data-component="tooltip" > 
			<?=$value_query?>
		</a> 
	</span> 
</p>


<?php 
		endforeach;
	endif;

?>