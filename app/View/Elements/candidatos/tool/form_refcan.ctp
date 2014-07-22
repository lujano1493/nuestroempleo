


<div class="row-fluid">
   
  <div class="span4">

      <?=  $this->Form->input ("RefCan".'.'.$i.'.refcan_nom',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Nombre referencia*:",
              'div' => array("class"=>"controls")  
              ))
      ?>
        
        <?= $this->Form->input ("RefCan".'.'.$i.'.candidato_cve',
            array(                
              'type'=>"hidden", 
               'value'=>$candidato_cve
              ));

     ?>

        <?= $this->Form->input ("RefCan".'.'.$i.'.refcan_cve',
            array(  
                  'class' => 'primary-key',
                  'data-primarykey'=> json_encode(array("name_model"=>"RefCan") ),

               ))?>   

       <?= $this->Form->input ("RefCan".'.'.$i.'.reftipo_cve',
            array(                
              'type'=>"hidden",
              'class' =>'reftipo_cve',
              "default"=>1
              ))?> 

  </div>
  <div class="span4">

   <?=  $this->Form->input ("RefCan".'.'.$i.'.refcan_mail',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Correo electr&oacute;nico*:",
              'div' => array("class"=>"controls")  ,
              ))
      ?>
  </div>

 <div class="span4">
      <?=  $this->Form->input ("RefCan".'.'.$i.'.refrel_cve',
            array(                
              'class'=>" input-medium-formulario refrel_cve", 
              'label' => "Relación*:",
              'options'=> $list['refrel_cve'],
              'empty'=> 'Selecciona ...',
              'div' => array("class"=>"controls")  ,
              ));
      ?>
  </div>

  
</div>


<div class="row-fluid">


    <div class="span4">

   <?=  $this->Form->input ("RefCan".'.'.$i.'.tipo_movil',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Tipo de Teléfono*:",
              'empty' => 'Selecciona ...',
              'options' => $list['tipo_movil'],
              'div' => array("class"=>"controls")  ,
              ))
      ?>
  </div>

   <div class="span4">

     <?=  $this->Form->input ("RefCan".'.'.$i.'.refcan_tel',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Tel&eacute;fono*:",
              'div' => array("class"=>"controls")  ,
              ));
      ?>

  </div>
	
  
  <div class="span4">
		

     <?=  $this->Form->input ("RefCan".'.'.$i.'.reftiempo_cve',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Tiempo de conocerlo*:",
              'options'=>  $list['reftiempo_cve'] ,
              'empty'=> 'Selecciona ...',
              'div' => array("class"=>"controls")  ,
              ));
      ?>
  </div>
</div>


