
    <div class="row-fluid">         
      <div class="span4 ">      
        <?php   

        echo $this->Form->input ('CursoCan.'.$i.'.candidato_cve',
          array(
             'type'=> 'hidden',
            'value'=>$candidato_cve ,
            ));  


        echo $this->Form->input ('CursoCan.'.$i.'.curso_cve',
          array(
             'class'=>"primary-key curso_cve",
             'data-primarykey'=> json_encode(array("name_model"=>"CursoCan") )
             ) );  

        echo  $this->Form->input ('CursoCan.'.$i.'.cursotipo_cve',
          array(                
            'class'=>" input-medium-formulario cursotipo_cve",
            'options' => $list['cursotipo_cve'],        
            'empty' => "Selecciona ...",
            'div' => false,
            'label' => 'Tipo de cursos*:'
            ));


            ?>    
            

      </div>
      <div class="span4 ">      
        <?php 
        echo  $this->Form->input ('CursoCan.'.$i.'.curso_institucion',
          array(                
            'class'=>" input-medium-formulario curso_institucion",      
            'div' => false,
            'label' => 'Institución*:'
            ));

            ?>

      </div>
      <div class="span4 ">      
        <?php 
        echo  $this->Form->input ('CursoCan.'.$i.'.curso_nom',
          array(                
            'class'=>"input-medium-formulario curso_nom",      
            'div' => false,
            'label' => 'Nombre del Curso*:'
            ));

            ?>

      </div>

    </div>

    <div class="row-fluid">         
      <div class="span4 "> 
        <label> Fecha Inicial*: </label>
        <div  id="actualizarCursoCan<?=$i?>Curso_fecini" name="data[actualizar][CursoCan][<?=$i?>][curso_fecini]"  class="curso_fecini date-picker date-picker-month-year date-start"> 
          <?=$this->Form->input("CursoCan.$i.curso_fecini",
                  array("class"=>' hide','type'=>'hidden')) ?>
        </div>
      </div>
      <div class="span4 "> 
        <label> Fecha Final: </label>
        <div  id="actualizarCursoCan<?=$i?>Curso_fecfin"  name="data[actualizar][CursoCan][<?=$i?>][curso_fecfin]" class="curso_fecfin date-picker date-picker-month-year date-end"> 
          <?=$this->Form->input("CursoCan.$i.curso_fecfin",
                  array("class"=>' hide','type'=>'hidden')) ?>

        </div>
      </div>
    </div>
    
