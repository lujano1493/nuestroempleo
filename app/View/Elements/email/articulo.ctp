<table width="95%" border="0" style="text-align:justify;margin-top:10px;">
	<tbody>
		<tr>
	    <td>
				<?=$this->Html->link("<img src='".$value['src']."'  width='200' height='107'>",
			    	array(
			    		"controller" =>"Articulos",
						"action" => "destacados",
						'full_base'=>true ,
						$value['id'] 
			    		),
			    	array('escape' => false)
				);?>

	    	
	    </td>
	    <td style="padding-left:10px">
	    	<p style="font-size: 16px;font-weight: bold;">  
					<?=$this->Html->link($value['title'],array(
						"controller" =>"Articulos",
						"action" => "destacados",
						'full_base'=>true ,
						$value['id'] ) ,array(								
						'style' =>"color:black"
						) )?>

	    	 </p>

			<p> <?=$value['descrip']?>  </p>
		</td>
	  </tr>	
	</tbody>
</table>