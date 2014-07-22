<div class="container">
 <!--criterios de busqueda-->


 <div class="span3 pull-left">
  <?=$this->element("candidatos/postulacion/filtros",array(
                                                              "conditions" => array(),
                                                              "tipo_" => "none"

  ) )?>

   <!-- publicidad lateral-->


  <?=$this->element("candidatos/postulacion/historial")?>

  <?=$this->element("candidatos/postulacion/sociales") ?>


  <div class="span3 pull-left" style="padding-top:15px;">
   <!-- eventos -->
    <?=$this->element("candidatos/eventos")?>
   <!--<div class="tabular"><img src="assets/img/face.png" width="306" height="48"></div>-->
   <!--articulos-->
    <?=$this->element("candidatos/articulos_destacado",array("span" => "span2"))?>



    <div class="left">
       <img src="/img/publicidad/publicidad-vertical.jpg" width="167" height="191" class="img-polaroid">
       </div>



  </div>
</div>	


<!-- ofertas -->
<div class="span9 margen_derecho">
    <?=$this->element("candidatos/oferta_detalles" )?>

 </div>




</div>


