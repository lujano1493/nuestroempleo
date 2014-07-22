
                     
 <?php    
      // sacamos los datos
      $IncapCan=$this->data['IncapCan'];


  $form_begin=  "<div class='formulario ' > ".$this->Form->create("IncapCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/IncapCan'),
              "class"=>'form-horizontal well',
              'data-component' => 'ajaxform' 
               ) ) ."   <fieldset>" ;

  $form_end=    " </fieldset>".$this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). 
                $this->Form->end()."</div>";


     $total=count($list['incapacidad_cve'] );
     $cuenta=intval($total/3) +1; 
?>
  
<?=$form_begin ?>


<div class="row-fluid">
	<div class="alert alert-block"> 
		El llenado de esta sección es opcional y tiene como objetivo facilitar, desarrollar y generar acciones afirmativas que fomenten la integración laboral de personas con discapacidad. (LEY FEDERAL PARA PREVENIR Y ELIMINAR LA DISCRIMINACIÓN ARTÍCULO 4 Y 13 SECCIÓN IV)

	</div>
</div>


<div class="row-fluid left"> 
  <div  class="span1">  </div>

<?php
        $i=0;

        echo "";
      foreach ($list['incapacidad_cve'] as $key => $value) {                
        $checked= Funciones::array_search($IncapCan,$key,'incapacidad_cve') ;
          if($i ==0  ){
              echo "<div class='span3'>";
          }

         echo  "<label class='checkbox'  > $value". $this->Form->input("IncapCan.".$key.".incapacidad_cve" , array(
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