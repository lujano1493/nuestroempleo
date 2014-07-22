
<div class="work_area" data-tamplate="areas_interes"  data-max="3"  >
	<div class="row-fluid"> 
		<div class="span8">
			<div class="title margin_title text-left" >Áreas de Interés </div>
		</div>
		<div class="span4">
		<!--	<div class=" margin_title">
				<a href="#" class=" add" > 	  (+) agregar </a> (solo se puedran agregar 3 registros como maximo)
			</div>-->
		</div>
	</div>


	<div class="row-fluid">

		<div class="agregados clearfix">

			<div class="areas_interes formulario ">
				<form>
					<input type="hidden" value="0" name="data[lista]" />
					<input type="hidden" name="name_input" class="name_input" value="data[actualizar][AreaIntCan]"> 
					<?php 
						$candidato_cve=$this->data['Candidato']['candidato_cve'] ;
						$count= count( $this->data['AreaIntCan']) ;
						$i=0;

					?>

					<?php	while ($i< $count): ?>
					<div class="AreaIntCan">

						<?php 
								echo $this->form->input ('AreaIntCan.'.$i.'.cespe_cve',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"cespe_cve",
											'type'=>'hidden'));  
								echo $this->form->input ('AreaIntCan.'.$i.'.AreaInt.cespe_nom',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"cespe_nom",
											'type'=>'hidden'));  
						?>
					</div>
					<?php $i++; endwhile ?>

					<div class="span12"> 
							<input class="lista_areas_interes"  type="text" /> 					
					</div>
				</form>
			</div>
		</div>
	</div>
<div class="template" style="display:none"> 

	<?php  

	echo $this->form->input ('cespe_cve_arr',array(
										'class'=>"cespe_cve_arr",
										'options'=>$cespe_cve_arr));  


	echo $this->element("candidatos/template/areasinteres",array ("i"=>$i,"save"=>"","candidato_cve"=>$candidato_cve))  ?>
</div>
<input class="count_register "  type="hidden" id="count" value="<?=$i?>" /> 

<div class="row-fluid "> 
	<div class="span12">
		<div class="control" style="margin-top:2%;margin-left:2%"> 
			<div class="area clearfix">

				<div class="bottons text-left float-left" > 
					<button class='btn btn-success  guardar_actualizacion multiple'> 
						Guardar Áreas de Interés
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