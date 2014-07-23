 <div class="tab-pane" style="width:15%;display:inline-block;margin-right:5px;margin-left:5px">


    {{? !it.privada  }}
    <img src="{{=it.src}}" class="tabular"   style="width:150px;height:90px;margin:auto" width="175px" height="110px">
   {{??}}
      <img  src="/img/oferta/img_oferta_priv.jpg"  class="tabular"  style="width:150px;height:90px;margin:auto"    width="175px" height="110px">
   {{?}}
                     
      <p class="destacadas-principal tabular ellipsis"> 
         {{=it.puesto}} 
      </p>

        <div class="clearfix detalles-oferta-carrusel">
     
          <p class="resumen-carrusel">  {{=it.ciudad}}   , {{=it.estado}}. {{=it.sueldo}}  </p>
          <?=$this->Html->link("Ver Oferta",array(
                "controller" => "postulacionesCan",
                "action" => "oferta_detalles",
                "id" => "{{=it.id}}"
              ),array(
                "class" => "strong ajax",
                "data-toggle" => "modal-ajax",
                "data-target" => "#oferta_detalles01"
              ) )?>          
       
        </div>
      
    </div>
