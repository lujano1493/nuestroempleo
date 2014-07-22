<span >    
      {{? it.idEva == 2  }}
        {{? it.status == 0 }}
            <?=$this->Html->link("<i class='icon-pencil'> </i> Aplicar ",array(
                  "controller" => "evaluaciones",
                  "action" => "evaluacion_disc",
                  "id" => "{{=it.id}}"
            ),array(
              "data-toggle" => "tooltip",
              "data-placement" => "top",
              "title" => "Aplicar evaluación",
              "class"=> "btn btn_color btn-small",
              "escape" => false
            ))?>

        {{?}}


      {{? it.status == 1 }}

        <!--/*<button  data-toggle="tooltip" data-placement="top" title="Has realizado con éxito tu evaluación. Los resultados han sido enviados al reclutador." class="btn btn_color btn-small"   >  <i class="icon-ban-circle"> </i>   </button>*/-->
          <?=$this->Html->link("<i class='icon-book'> </i> Ver resultados ",array(
                  "controller" => "evaluaciones",
                  "action" => "evaluacion_disc_resultados",
                  "id" => "{{=it.id}}"
            ),array(
              "data-toggle" => "tooltip",
              "data-placement" => "top",
              "title" => "Ver resultados de la evaluación",
              "class"=> "btn btn_color btn-small",
              "escape" => false
            ))?>
    

      {{?}}    

      {{?}}



        {{? it.idEva != 2  }}

        {{? it.status == 0 }}

           <?=$this->Html->link(" <i class='icon-pencil'> </i> Aplicar  ",array(
                  "controller" => "evaluaciones",
                  "action" => "aplicar",
                  "id" => "{{=it.id}}"
            ),array(
              "data-toggle" => "tooltip",
              "data-placement" => "top",
              "title" => "Aplicar evaluación",
              "class"=> "btn btn_color btn-small",
              "escape" => false
            ))?>
             
        {{?}}

         {{? it.status == 1 }}

           <?=$this->Html->link("  <i class='icon-ban-circle'> </i>    ","#",array(
              "data-toggle" => "tooltip",
              "data-placement" => "top",
              "title" => "Has realizado con éxito tu evaluación. Los resultados han sido enviados al reclutador.",
              "class"=> "btn btn_color btn-small",
              "escape" => false
            ))?>
                 
         {{?}}    


        {{?}}





</span>