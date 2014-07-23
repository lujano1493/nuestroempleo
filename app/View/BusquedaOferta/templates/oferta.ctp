<div class="ofertas_back left">
  <table class="{{=it.class_extra }}">
    <tbody>
      <tr>
        <td style=" width:25%; border-right:#CCC solid thin;"> 

        
          <div class="localidad" style="padding-top: 5%;"> 
            {{=it.ciudad}}   , {{=it.estado}} <br>
            <i class=" icon-hand-right"></i>&nbsp;{{=it.sueldo}}
          </div>

        </td>
        <td style="vertical-align:middle; text-align:center; width:50%; border-right:#CCC solid thin;" class="center">

          <?=$this->Html->link ("{{=it.puesto}}",array(
            "controller" => "postulacionesCan",
            "action" => "oferta_detalles",
            "id" => "{{=it.id}}"
          ), array(
            "class"=> "strong ajax",
            "data-toggle" =>"modal-ajax",
            "data-target" =>"#oferta_detalles01"

          ) ) ?>
          <p style="text-align:justify">
            {{=it.resumen}}
          </p>
          <p style="text-align:justify">
            {{? it.has_bene }} {{=it.beneficios}}  {{?}}
          </p>

           <?=$this->Html->link ("Ver mas",array(
            "controller" => "postulacionesCan",
            "action" => "oferta_detalles",
            "id" => "{{=it.id}}"
          ), array(
            "class"=> "strong ajax",
            "data-toggle" =>"modal-ajax",
            "data-target" =>"#oferta_detalles01"

          ) ) ?>         
        </td>
        <td style="width:25%;">
          <center>

            {{? !it.privada  && (it.recomendada || it.distinguida  )  }}
            <img src="{{=it.src}}"  style="width:175px;height:105px;margin:auto"  >
            {{?}}



            {{? it.privada  && (it.recomendada || it.distinguida  )  }}
            <img src="/img/oferta/img_oferta_priv.jpg"  style="width:175px;height:105px;margin:auto"  >
            {{?}}
            <p>Publicada:

                   <?=$this->Html->link ("{{=it.fecha}} ",array(
                "controller" => "busquedaOferta",
                "?" => "publicacion={{=it.fecha}}"
              ), array(                

              ) ) ?>    
            </p>
            </center>
          </td>
        </tr>
      </tbody>
    </table>
</div>