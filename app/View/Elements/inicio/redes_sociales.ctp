<?php
    $href="/";
    $label="Inicio";

    if(  !empty($micrositio)){     
       $label="Inicio NE";
    }
    ?>

<div class="span12_2 right pull-right cintillo_redes">
  <span class="pull-left">
    <div class="accordion_inicio" id="accordion2">
      <?=$this->element("inicio/acceso_candidato")?>
      <?=$this->element("inicio/acceso_empresas")?>
    </div>  
  </span>
    <?php if (empty($micrositio)) :?>            
      <?php if ($this->params['controller'] !== 'empresas') { ?>
        <a class=" btn-warning btn-medium registrate-candidato pull-left margin_left_5" 
        data-component="triggerelement" data-target=".option-registrate-candidato"  href="/">
          <i class="icon-user"></i> 
          Regístrate
        </a>     
      <?php } else { ?>

            <a class=" btn-warning btn-medium pull-left margin_left_5" href="#registro-empresas" data-toggle="modal"  >
                <i class="icon-briefcase"></i> 
                Regístrate
              </a>
      <?php } ?>
        <a class=" btn-success btn-medium pull-left margin_left_5" href="#registro-empresas"  data-toggle="modal">
          <i class="icon-edit-sign"></i> 
          Publicar Oferta
        </a>
    <?php  endif;?>
	 <div class="boton-social">
	 	<?=$this->Html->link("<i class='icon-home'></i> $label ",$href,array(
			"class"=> "btn-small btn_color",
      "style" => "font-family:'Open Sans', Helvetica, Arial, sans-serif",
			"escape"=>false)
	 	)?>
	 </div>


   <?php  if ( empty($micrositio)  ):?>

  	<div class="boton-social">
  		 <?=$this->Html->tag("div","",array(
                          "class" =>"g-plusone",
                          "data-size" =>"medium",
                          "data-annotation" =>"none",
                          "data-href"=>"https://plus.google.com/111610607829310871158/posts"

          )) ?>

  	</div>
      <div class="boton-social">
        	<?=$this->Html->tag("script","",array(
        		"type" => "IN/FollowCompany",
        		"data-id" =>"325576",
        		// "data-counter" =>"right"
        		 ))?>
      </div>
      <div class="boton-social">
  		<?=$this->Html->link("","https://twitter.com/NuestroEmpleo",array(
  			"class" =>"twitter-follow-button",
  			"data-show-count" => "false",
  			"data-lang" =>"es",
  			"data-show-screen-name" =>"false"

  		))?>
      </div>
      	<div class="boton-social">
  		   <?=$this->Facebook->like(array(
            "href"=>"https://www.facebook.com/NuestroEmpleo",
            "show_faces" => false,
            "data-layout" =>"button",
            "share" => false,
            "action" => "like"
            ) ) ?>
  	</div>
  <?php  endif;?>
</div>