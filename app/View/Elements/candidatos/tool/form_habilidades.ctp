 


<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    <a class="close" href="#" data-dismiss="alert">×</a>

    <i class=" icon-info-sign icon-2x"></i>
     Indica 5 habilidades que te caractericen.  </div>
</div>




 <?php    
      // sacamos los datos
      $HabiCan=$this->data['HabiCan'];


  $form_begin=  "<div class='formulario ' > ".$this->Form->create("HabiCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/HabiCan'),
              "class"=>'form-horizontal well',
              'data-max-checked'=> 5,
              'id' => 'habilidades01'              
               ) ) ."   <fieldset>" ;

  $form_end=    " </fieldset>".$this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). 
                $this->Form->end()."</div>";


     $total=count($list['habilidad_cve'] );
     $cuenta=intval($total/3) +1; 
?>
  



<?=$form_begin ?>
<div class="row-fluid left"> 

<?php
        $i=0;

        echo "";
      foreach ($list['habilidad_cve'] as $key => $value) {                
        $checked= Funciones::array_search($HabiCan,$key,'habilidad_cve') ;
          if($i ==0  ){        
              echo "<div class='span4'>";
          }

         echo  "<label class='checkbox'  > $value". $this->Form->input("HabiCan.".$key.".habilidad_cve" , array(
             'label' => false ,
              'value' => $key,
              'hiddenField'=>false,
              'type' => 'checkbox',
              'div' => false,
              'checked'=> $checked    
            )) ."</label>";         

          $i++;
          if($i  === $cuenta  || $i == $total-1  ){
              echo "</div>";
              $i=0;
          }


          
      }  
    ?>


</div>


<?=$form_end ?>




<?php 

$this->AssetCompress->addScript(array(
    'app/candidatos/tool/check_form.js',            
    ), 'habilidades.js');

    ?>