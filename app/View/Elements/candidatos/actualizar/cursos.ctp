
<?php 
	$count= count( $this->data['CursoCan']) ;
	$candidato_cve=$this->data['Candidato']['candidato_cve'] ;
	$class_has_exp=($count>0)?"active":"";
	$class_no_has_exp=($count==0)?"active":"";
?>

<div class="work_area" data-tamplate="cursos"  data-max="6"  >
	<div class="row-fluid"> 
		<div class="span4">
			<div class="title margin_title text-left" >Cursos </div>
		</div>
	
		<div class="span4">
			<div class=" margin_title">
				<a href="#" class=" add" > 	  (+) agregar </a>   (Sólo se pueden agregar 6 registros como máximo)
			</div>
		</div>
	</div>


	<div class="row-fluid">

		<div class="agregados clearfix">
			<form>
				<input type="hidden" value="0" name="data[multiple]" />
			</form>
			<?php 
			$i=0;
			while ($i< $count):  ?>

			<?php echo $this->element("candidatos/template/cursos",array ("i"=>$i,"save"=>"save","count"=>$count ,
				"candidato_cve"=>$candidato_cve,"model"=>'CursoCan' )) ; 
			$i++;
			?>		
		<?php endwhile; ?>
	</div>
</div>

<div class="template" style="display:none"> 
	<?php  echo $this->element("candidatos/template/cursos",array ("i"=>$i,"save"=>"","count"=>$count,"candidato_cve"=>$candidato_cve,"model"=>''))  ?>
</div>

<input class="count_register "  type="hidden" id="count" value="<?=$i?>" /> 

<div class="row-fluid "> 
	<div class="span12">
		<div class="control" style="margin-top:2%;margin-left:2%"> 
			<div class="area clearfix">

				<div class="bottons text-left float-left" > 
					<button class='btn btn-success  guardar_actualizacion multiple'> 
						Guardar Curso
					</button>
				</div>
				<div class="loading float-left"> 
					<img src='<?php echo $this->webroot;?>img/candidatos/load.gif'  />  
				</div> 
				<div class="text-center float-left">

					<div class="status">  </div> 							
				</div>
			</div>
		</div>									
	</div>
</div>

<div class="row-fluid "> 
	<div class="span12">
	</div>
</div>
</div>