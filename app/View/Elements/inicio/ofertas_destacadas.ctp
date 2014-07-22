 
<div class="container">
        <div class="destacadas-title">
            <h3>OFERTAS DISTINGUIDAS</h3>
        </div>
    <div id="ofertas-distinguidas-content" data-component="carrusel"  
              data-type="flexslider" data-isajax="true" data-url="<?=$this->Html->url(array("controller" => "busquedaOferta","action"=>"destacadas"))?>" 
              data-template-id="#tmpl-oferta-distinguida-inicio" data-content-type="json" data-direction="horizontal" 
              data-num-item-display="6" data-paginate="true" data-limit="200"      >

    <div id="carrusel-ofertas-distinguidas" class="flexslider destacadas-list">
      
           
    </div>

    <?=$this->Template->insert(array(
        'oferta-distinguida-inicio',
      ), null, array(
        'viewPath' => 'BusquedaOferta'
      ));
       ?>
</div>


  
</div>
