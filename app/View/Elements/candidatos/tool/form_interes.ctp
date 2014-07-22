 



<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    <a class="close" href="#" data-dismiss="alert">×</a>

    <i class=" icon-info-sign icon-2x"></i>
      Selecciona todos los  temas que sean de tu interés.  </div>
</div>


 <?php    
      // sacamos los datos
      $interescan=$this->data['InteresCan'];


  $form_begin=  "<div class='formulario ' > ".$this->Form->create("InteresCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_lista/InteresCan'),
              "class"=>'form-horizontal well',
              'data-component' => 'ajaxform' 
               ) ) ."   <fieldset>" ;

  $form_end=    " </fieldset>".$this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions'))). 
                $this->Form->end()."</div>";

    $total=count($list['interes_cve'] );
     $cuenta= intval($total/3) + 1; 

?>
  
<?=$form_begin ?>
<div class="row-fluid left"> 
  <div  class="span1">  </div>

<?php
        $i=0;

        echo "";
      foreach ($list['interes_cve'] as $key => $value) {                
        $checked= Funciones::array_search($interescan,$key,'interes_cve') ;
          if($i ==0  ){
              echo "<div class='span3'>";
          }

         echo  "<label class='checkbox'  > $value". $this->Form->input("InteresCan.".$key.".interes_cve" , array(
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