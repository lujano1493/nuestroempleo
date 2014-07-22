
  <?php 
    

    if($name_model === "RefCanLab"){
        $label_1="laboral";
        $list_refrel_cve=$list['refrel_cve_lab'];
    }
    else{
      $label_1="personal";
      $list_refrel_cve= $list['refrel_cve_per'] ;
    }

  ?>

<div class="row-fluid">
  <div class="span4">



    <?= $this->Form->input ($name_model.'.'.$i.'.candidato_cve',
            array(                
              'type'=>"hidden", 
               'value'=>$candidato_cve
              ));

     ?>



        <?= $this->Form->input ($name_model.'.'.$i.'.refcan_cve',
            array(  
                  'class' => 'primary-key',
                  'data-primarykey'=> json_encode(array("name_model"=>"RefCan") ),

               ));?>

    
       <?= $this->Form->input ($name_model.'.'.$i.'.reftipo_cve',
            array(                
              'type'=>"hidden", 
               'default'=> $name_model === "RefCanLab" ? 0  :  1
              ));

     ?>


      <?=  $this->Form->input ($name_model.'.'.$i.'.refcan_nom',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Nombre referencia $label_1*:",
              'div' => array("class"=>"controls")  
              ));
      ?>
  </div>
  <div class="span3">

   <?=  $this->Form->input ($name_model.'.'.$i.'.refcan_mail',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Correo electr&oacute;nico*:",
              'div' => array("class"=>"controls")  ,
              ));
      ?>



 
  </div>
  <div class="span4">

     <?=  $this->Form->input ($name_model.'.'.$i.'.refcan_tel',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Tel&eacute;fono*:",
              'div' => array("class"=>"controls")  ,
              ));
      ?>

  </div>
</div>


<div class="row-fluid">
  <div class="span4">
      <?=  $this->Form->input ($name_model.'.'.$i.'.refrel_cve',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Relación*:",
              'options'=> $list_refrel_cve,
              'empty'=> 'Selecciona ...',
              'div' => array("class"=>"controls")  ,
              ));
      ?>
  </div>
  <div class="span4">
     <?=  $this->Form->input ($name_model.'.'.$i.'.reftiempo_cve',
            array(                
              'class'=>" input-medium-formulario", 
              'label' => "Tiempo de conocerlo*:",
              'options'=> $list['reftiempo_cve'],
              'empty'=> 'Selecciona ...',
              'div' => array("class"=>"controls")  ,
              ));
      ?>
  </div>
</div>