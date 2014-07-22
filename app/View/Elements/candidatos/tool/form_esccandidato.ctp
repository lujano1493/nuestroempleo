

<input type="hidden" id="escolar"  />
	<?php if("primera" ==$action) :?>
	<h4>
		Último nivel de Estudios
	</h4>
	<?php endif ; ?>

<div class="row-fluid">
<div class="span4 ">
	
	<?php
	$type="radio";
	$label1="¿Estudias Actualmente? ";
	$options_input=array(		
		'hiddenField'=>false,
		'class'=>"event-change ec_actual",							
		'div' => array("class"=>"ec_actual_div group-radio"),
		'legend' => false,
		"type"=>'radio',
		'label'=>true,    
		'options'=> $list['siono']
		);
	if($i>0){
		$options_input["before"]="";
		$options_input["type"]="hidden";
		$options_input["value"]="N";
		$label1="";
	}

	?>

	<label> <?=$label1?></label>

	<?php							
	echo $this->Form->input ('EscCan.'.$i.'.ec_actual',$options_input);  
	?>

</div>

<div class="span4 ">			
	<?php 	

	echo $this->Form->input ('EscCan.'.$i.'.candidato_cve',
		array(
			'value'=>$candidato_cve ,
			'class'=>"candidato_cve",
			'type'=>'hidden'));  


	echo $this->Form->input ('EscCan.'.$i.'.ec_cve',
		array(
			'class'=>"primary-key ec_cve",
			'data-primarykey'=> json_encode(array("name_model"=>"EscCan") ),
			'type'=>'hidden'));  

$options=array();

for ($iter_=0;$iter_<15;$iter_++ ) {
	if($iter_<=2){
		$options[]="N";
	}
	else{
		$options[]="S";	
	}
	 
}


	echo  $this->Form->input ('EscCan.'.$i.'.ec_nivel',
		array(								
			'class'=>" input-medium-formulario event-change ec_nivel",
			'options' => $list['ec_nivel'],				
			'div' => array("class"=>"controls")  ,
			'label' => 'Nivel Estudio*:'
			));


	?>		


</div>
<div class="span4 ">			
	<?php 
	echo  $this->Form->input ('EscCan.'.$i.'.ec_institucion',
		array(								
			'class'=>" input-medium-formulario  ec_institucion",			
			'div' => array("class"=>"controls") ,
			'label' => 'Institución*:'
			));

			?>

</div>

</div> 


<div class="row-fluid ">
	<div class="carreras">
				<?php 
				$esccararea= ClassRegistry::init('EscCarArea')->get_lista();
				if(!empty($this->data['EscCan'][$i]) && $this->data['EscCan'][$i]['cespe_cve']   ){		

					$id0=$this->data['EscCan'][$i]['EscCarArea']['carea_cve'];
					$id1=$this->data['EscCan'][$i]['EscCarGene']['cgen_cve'];
					

				}
				else{
					$id0=$id1 =1;
				}
				$escargene= ClassRegistry::init("EscCarGene")->get_lista($id0);		
				
			  $esccaresp= ClassRegistry::init("EscCarEspe")->get_lista($id1);


		   ?>
		<div class="span4">
			<?= $this->Form->input('EscCan.'.$i.'.EscCarEspe.carea_cve',
				array(
					"options" => $esccararea,
					"value" =>$id0,
					'label' => "Área:",
					'class' =>"input-medium-formulario  ",
					'data-source-controller' => $this->name,
					'data-source-name' => 'carreras_genericas',
					'data-source-scope'=>'form'
			 )) ?>
			
		</div >
		<div class="span4">
					<?= $this->Form->input('EscCan.'.$i.'.EscCarEspe.cgen_cve',
				array(
					"options" => $escargene,
					"value" =>$id1,
					'label' => "Carrera Genérica:",
					'class' =>"input-medium-formulario  ",
					'data-source-controller'=>$this->name,
					'data-json-name'=>'carreras_genericas',
					'data-source-scope'=>'form',
					'data-source-name'=>'carreras_especificas'
					
			 )) ?>

			
		</div >
		<div class="span4">

				<?= $this->Form->input('EscCan.'.$i.'.cespe_cve',
				array(
					'label' => "Carrera Específica:",
					'data-json-name'=> 'carreras_especificas',
					"class" =>"input-medium-formulario  ",
					"options" => $esccaresp
				
			 )) ?>
			
		</div>
	</div>

	<div class="especialidad"> 
			<div class="span12">
					<?= $this->Form->input('EscCan.'.$i.'.ec_especialidad',
				array(
					'label' => "Especialidad*:",
					'data-rule-required'=> 'true',
					'data-msg-required' => "Ingresa una especialidad",
					"class" =>"input-medium-formulario  ec_especialidad"
				
			 )) ?>

			</div>
	</div>
</div>

<div class="row-fluid">					
<div class="span4 "> 
	<div class="controls">
		<label> Fecha Inicial*: </label>
		<div  id="actualizarEscCan<?=$i?>Ec_fecini" name="data[EscCan][<?=$i?>][ec_fecini]"  class="ec_fecini date-picker date-picker-month-year date-start"> 
		<?=$this->Form->input("EscCan.$i.ec_fecini",
		array("class"=>' hide','type'=>'hidden')) ?>
		</div>
	</div>
</div>
<div class="span3 "> 
	<div clasS="controls fecha_final_escolar">
		<label> Fecha Final: </label>
		<div  id="actualizarEscCan<?=$i?>Ec_fecfin"  name="data[EscCan][<?=$i?>][ec_fecfin]" class="ec_fecfin date-picker date-picker-month-year date-end"> 
		<?=$this->Form->input("EscCan.$i.ec_fecfin",
		array("class"=>' hide','type'=>'hidden')) ?>
		</div>
	</div>			

</div>

<?php 
$disabled=false;
$value_ini=array();
if($i< $count){	
	$EscCan= (!empty($this->data['EscCan']))? $this->data['EscCan'][$i] :false;
	if($EscCan){
		if($EscCan['ec_nivel']<=2){											
			$disabled=true;
			$model="";
		}
		if(!empty($EscCan['area_cve'])) {
			$value_ini=array(array("area_cve"=>$EscCan['area_cve'],"area_nom"=>$EscCan['AreaInt']['area_nom']  ) );

		}
	}
}


?>
</div>

