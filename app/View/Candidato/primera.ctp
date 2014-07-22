
<?if ( !$hasPsw) :?>
	<?=$this->element("candidatos/agregar_contrasena")?>
<?endif;?> 


	<h2>Perfil General </h2>
<div class="row-fluid"> 

	<div class="span12 formulario"> 			
		<?=$this->Form->create('Candidato',  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_primera'),
	        "class"=>'form-horizontal  well',
	        'data-component'=>"validationform ajaxform",
	        'data-onsucces'=>json_encode(array("action"=>"show"  )), 
	        'id'=>'form_primera01', 
	        'inputDefaults' => array(
	          'label' => false,
	          'div' => false
	          ) ) );
          ?>
          <?=$this->Session->flash()?>
		<?php 

		 echo $this->element('candidatos/tool/form_candidato_dircandidato',array("action"=>"primera")); 		

		 echo $this->element('candidatos/tool/work_area',array("action"=>"primera",
															  "title"=>"Ãšltimo Nivel Estudios",
															  "max_item"=>3,
															  "name_model"=>"EscCan",
															  "name_template"=>"escolar",
															  "ini_add_form"=>1,
															  "route_view"=>"candidatos/tool/form_esccandidato"  ));  
		?>


		<div class="row-fluid">
				<div class="span5">
						<?= $this->element('candidatos/tool/form_idiomacan',array("action"=>"primera"));   ?>

				</div>
				<div class="span6">
					<?= $this->element('candidatos/tool/form_areaintcan',array("action"=>"primera"));  ?>
					
				</div>
		</div>
	
		<?
			echo $this->element('candidatos/tool/form_expecocan',array("action"=>"primera", ));  

		?>
		<?php 
			$count= count( $this->data['ExpLabCan']) ;
			$value=($count>0)?"S":"N";
			$options_hiddenform=json_encode( array("target"=>".tiene_experiencia_laboral","type"=>"radio" ));
		?>

		<div> 
			<h4> 
				 ¿Tienes Experiencia Laboral?
			</h4>

			<p class=""> 
						<?php echo
								$this->Form->input('hiddenform', array(
								"name"=>"data[hiddenform][s_hidden]",
								'options'=>$list['siono'],
								'type'=>"radio",
								'label'=>true,
								'legend'=>false,
								'value'=>$value,
					            'div'=>  array('class'=>'group-radio'),
					            'class'=>' input-medium-formulario   siono_laboral'));
			            ?>

			</p>

			<div class="tiene_experiencia_laboral"> 
				<?php 
				
				echo $this->element('candidatos/tool/work_area',array("action"=>"primera",
																	  "title"=>"",
																	  "max_item"=>3,
																	  "name_model"=>"ExpLabCan",
																	  "name_template"=>"explabcandidato",
																	  "ini_add_form"=>1,
																	  "route_view"=>"candidatos/tool/form_explabcan"  ));			 			
				echo $this->element('candidatos/tool/form_areaexpcan',array("action"=>"primera")) ;
				?>

			</div>


		
		</div>
			<?=$this->Form->input("ConfigCan.0.config_cve" , array(
					  			'label' => false,
					  			'after'=>'Acepto recibir notificaciones SMS',
					  			'value' => '5',
					  			'hiddenField'=>false,
					  			'div'=>array("class"=>"controls"),
					  			'type' => 'checkbox',
					  			'checked'=> false	
				     		)) ?>


			<?php for ($i=1;$i<=8;$i++ ) :?>

					<?php  if ($i!=5 && $i!=6  ) : ?> 
						<?=$this->Form->input("ConfigCan.$i.config_cve",array(
							'type' => 'hidden',
							'value' => $i
							
						)) ?>
					<?php endif; ?>	
			<?php endfor; ?>


			<?=$this->Form->submit("Guardar", array ("class"=>'btn_color' ,
													 'title'=>"Revisa los datos  antes de Guardar.",
													 'data-component' => "tooltip",
													 'data-placement' => "bottom",
														"div"=>array("class"=>'')));  ?>
		 <?= $this->Form->end();  ?>

	</div>	

</div>


<?php 

					/*agregamos eventos*/
					 $this->Html->scriptBlock(
				    'toggle_radio(["N","S"],"change",".tiene_experiencia_laboral",".siono_laboral",true);'.				    
				    'toggle_radio(["S","N"],"change",".fecha_final_escolar",".ec_actual ",true);'.
				    'toggle_radio(["S","N"],"change",".fecha_final_explab" ,".explab_actual",true);'
				    ,
				    array('inline' => false)
				);

					 $this->Html->script(array("app/candidatos/tool/form_esccandidato"),array("inline"=>false ) );


?>



