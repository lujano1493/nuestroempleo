
<div class="work_area" data-tamplate="idiomas"  data-max="6"  >
	<div class="row-fluid"> 
		<div class="span8">
			<div class="title margin_title text-left" >Idiomas </div>
		</div>
		<div class="span4">
		<!--	<div class=" margin_title">
				<a href="#" class=" add" > 	  (+) agregar </a> (solo se puedran agregar 3 registros como maximo)
			</div>-->
		</div>
	</div>


	<div class="row-fluid">

		<div class="agregados clearfix">

			<div class="idiomas formulario ">
				<form>
					<input type="hidden" value="0" name="data[lista]" />
					<input type="hidden" name="name_input" class="name_input" value="data[IdiomaCan]"> 
					<?php 
						$candidato_cve=$this->data['Candidato']['candidato_cve'] ;
						$count= count( $this->data['IdiomaCan']) ;
						$i=0;

					?>

					<?php	while ($i< $count): ?>
					<div class="IdiomaCan">

						<?php 
								echo $this->form->input ('IdiomaCan.'.$i.'.idioma_cve',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"idioma_cve",
											'type'=>'hidden'));  
								echo $this->form->input ('IdiomaCan.'.$i.'.ic_nivel',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"ic_nivel",
											'type'=>'hidden'));  
								echo $this->form->input ('IdiomaCan.'.$i.'.Idioma.idioma_nom',
										array(
											'name'=>false,
											'id'=>false,
											'data-id'=>"idioma_nom",
											'type'=>'hidden'));  
						?>
					</div>
					<?php $i++; endwhile ?>

					<div class="span12"> 
							<?php
								echo $this->form->input ('lista_idiomas',
									array(
										'class'=>"lista_idiomas",
										'label'=>false,
										'type'=>'text'));  
							 ?> 				
					</div>
				</form>
			</div>
		</div>
	</div>
<div class="template" style="display:none"> 
	<?php
		echo $this->form->input ('ic_nivel_arr',array(
										'class'=>"ic_nivel_arr",
										'options'=>$ic_nivel_arr));  
		echo $this->form->input ('idioma_cve_arr',array(
										'class'=>"idioma_cve_arr",
										'options'=>$idioma_cve_arr));  

		 echo $this->element("candidatos/template/idiomas",array ("i"=>$i,"save"=>"","candidato_cve"=>$candidato_cve))  ?>
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