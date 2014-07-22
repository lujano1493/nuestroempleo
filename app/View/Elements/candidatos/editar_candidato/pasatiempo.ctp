<div id="pasatiempo_" class="view_" >
	<div class="row-fuid"> 
	
	</div>

	<div class="row-fluid"> 
		<div class="span1"> </div>
		<div class="span10"> 
				<?=$this->form->input('PasatiempoPer.persona_cve',array( 
															'id'=>'persona_cve',															
															'type'=> 'hidden'								
													)) ?>
				<?=$this->form->input('PasatiempoPer.gpo_cve',array( 
															'id'=>'persona_cve',
															'type'=> 'hidden'								
													)) ?>
			<div class="row-fluid"> 
				<div class="span12 pasatiempo">
					<div class="row-fluid"> 
						<?php for ($i=0;$i< count($Pasatiempo);): ?>	
						<?php 
							$value=$Pasatiempo[$i];
							$pasa_cve=$value['Tipopasatiempo']['pasa_cve']; 
							$div="";
							$row_div="";
							$col=0;
						
						?>
							<div class="row-fluid"> 
								<div class="span12 title_p"> <?=$value['Tipopasatiempo']['pasa_nom'];?>  </div>
							</div>
								<?php 						
								while ($i< count($Pasatiempo) ){
									if ($pasa_cve == $Pasatiempo[$i]['Tipopasatiempo']['pasa_cve'] ){	
																			
										
										$checked=Funciones::array_search($PasatiempoPer,$Pasatiempo[$i],'Pasatiempo','pas_cve');
										$checkbox=$this->form->checkbox( $i.'.PasatiempoPer.pas_cve', 
																array('value'=>$Pasatiempo[$i]['Pasatiempo']['pas_cve'],'id'=>'pas_cve'.$i,'class'=>''
																	,'checked'=>$checked,'disabled'=>true,'hiddenField' => false));
										$label= "<label class='label_p'>".$Pasatiempo[$i]['Pasatiempo']['pas_nom']." </label>";						
																
										$data=$checkbox.$label;						
									
										$div= $div."<div class='span2'>".$data ."</div>";
										if($col>=5){
											$row_div=$row_div."<div class='row-fluid'>". $div ."</div>";
											$div="";
											$col=0;
										}
										
										$col++;
										$i++;
										
									}
									else{																			
										break;
									}
									
								}
									/*por si quedaron elementos  y el ciclo termino*/
									if($div!=""){
											$row_div=$row_div."<div class='row-fluid'>". $div ."</div>";											
										}
								
							
								echo "$row_div" ;
							?>				
							
						<?php endfor; ?>
					</div>
				
				</div>	
					
			</div>
			
			
			
			<div class="row-fluid">  
				
				<div class="span3"></div>
				<div class="span6" style="text-align:center">
						<button class="btn editar_pasatiempo"> Editar   </button>
				</div>
			
			
			</div>
			
		</div>
		
		<div class="span2"> </div>
		
	</div>

</div>

