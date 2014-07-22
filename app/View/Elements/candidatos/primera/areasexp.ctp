
<div class="work_area" data-tamplate="areas_experiencia"  data-max="3"  >
	<div class="row-fluid"> 
		<div class="span8">
			<div class="title margin_title text-left" >Áreas de Experiencia </div>
		</div>
		<div class="span4">
		<!--	<div class=" margin_title">
				<a href="#" class=" add" > 	  (+) agregar </a> (solo se puedran agregar 3 registros como maximo)
			</div>-->
		</div>
	</div>


	<div class="row-fluid">

		<div class="agregados clearfix">

			<div class="areas_experiencia formulario ">
				<form>										
					<?php 
						$candidato_cve=$this->data['Candidato']['candidato_cve'] ;
						$count= count( $this->data['AreaExpCan']) ;
						$i=0;

					?>

					<?php	while ($i< $count): ?>
					<div class="AreaExpCan">

						<?php 
								echo $this->form->input ('AreaExpCan.'.$i.'.cespe_cve',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"cespe_cve",
											'type'=>'hidden'));  
								echo $this->form->input ('AreaExpCan.'.$i.'.tiempo_cve',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"tiempo_cve",
											'type'=>'hidden'));  
							echo $this->form->input ('AreaExpCan.'.$i.'.AreaInt.cespe_nom',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"cespe_nom",
											'type'=>'hidden'));  
						?>
					</div>
					<?php $i++; endwhile ?>

					<div class="span12"> 
							<input class="lista_areas_interes_exp"  type="text" /> 					
					</div>
				</form>
			</div>
		</div>
	</div>
<div class="template" style="display:none"> 
	<?php echo  $this->form->input("tiempo_cve",array("id"=>"tiempo","class"=>"tiempo_cve_arr","options"=>$tiempo_cve_arr )) ?>
	<?php  echo $this->element("candidatos/template/areasexp",array ("i"=>$i,"save"=>"","candidato_cve"=>$candidato_cve))  ?>
</div>
<input class="count_register "  type="hidden" id="count" value="<?=$i?>" /> 


</div>