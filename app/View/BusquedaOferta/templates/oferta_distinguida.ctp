  <table class="destacadas_ofertas_perfil">
    <tr >
         <td style="vertical-align:middle; width:25%; border-right:#CCC solid thin;">
                {{=it.ciudad}}   , {{=it.estado}}
              <p>

                   <i class=" icon-hand-right"></i> &nbsp;{{=it.sueldo}}
              </p>
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
              <p  style="text-align:justify">
                        {{=it.resumen}}
                        
          

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
         <td style="vertical-align:middle; width:25%;">

              <center>
                     {{? !it.privada  }}
                      <img src="{{=it.src}}" width="210px" height="110px" style="width:175px;height:105px;margin:auto" >
                     {{??}}
                        <img  src="/img/oferta/img_oferta_priv.jpg"  width="210px" height="110px" style="width:175px;height:105px;margin:auto"  >
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
  </table>