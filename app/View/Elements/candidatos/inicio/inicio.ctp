<?= $this->element("inicio/busqueda", array("extra_class"=> "buscador_cand","with_title"=>true, "param" =>array() ) )?>


            <table style="width:100%;">
            <tbody>
            
             <tr>
            <td style="width:40%; padding:10px;" valign="top">

              <?php  
            

              ?>
             <?=$this->element("candidatos/ofertas_perfil",array(
                                                                          "ofertas_perfil" =>$ofertas_perfil

             ))?>
            </td>
           
            <td style="width:60%; padding:10px;" valign="top">
<br>
<div class="articulos_interes" >
<?php  
  $art=ClassRegistry::init("WPPost");
  $articulos= $art->articulos_liga(3);
?>


    <div id="semblaza_carru" data-component="carrusel"  
              data-type="flexslider" data-isajax="true" data-url="<?=$this->Html->url(array("controller" => "candidato","action" =>"semblazas") )?>" 
              data-template-id="#tmpl-semblaza" data-content-type="json" data-direction="vertical" 
              data-num-item-display="2" data-paginate="true" data-limit="40"      >

      <div id="semblaza_carrs" class="flexslider">
        
             
      </div>

    <?=$this->Template->insert(array(
        'semblaza',
      ), null, array(
        'viewPath' => 'Candidato'
      ));
       ?>
    </div>




<?php 
                $pos=array(
                          "pull-left",
                          "pull-left",
                          "pull-left");

                $alineacion=array(
                          "align=right",
                          "align=left",
                          "align=right");

                $itera=0;
                $cont=0;
                foreach ($articulos as $value) {
                   echo $this->element("candidatos/articulo_index",array("value"=>$value,"pull" =>$pos[$itera++],  "span" => "span12",  "alineacion" => $alineacion[$cont++]));
                }

          ?>
              
      
                
                </div>
</td>
            </tr>
            </tbody>
            </table>