<table width="95%" border="0" style="text-align:justify;margin-top:10px;">
	<tbody>
		<tr>
	    <td>
				<?=$this->Html->link("<img src='".$value['src']."' style='width:200px;height:107px;border: 3px solid #B6B6B6;background-color: #FFF;'>",
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
						'style' =>"text-decoration:none;font-weight:bold;color:#2f72cb;",
						) )?>

	    	 </p>

			<p> <?=$value['descrip']?>  </p>
		</td>
	  </tr>	
	</tbody>
</table>