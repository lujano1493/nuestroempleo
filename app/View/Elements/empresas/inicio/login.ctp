<?=$this->element("inicio/redes_sociales")?>
<!--logo-->
<div class="span3_2_logo">
  <h1>
      <?php 
      echo $this->Html->link("Nuestro Empleo - Tu Espacio Laboral en Internet",array(
            "controller"=> "informacion",
            "action" => "index"          
    ) , array(
              "class"=> "brand"
    ));?>


  </h1>
</div>
<div class="span8_menu pull-right">
  <?php echo $this->element("inicio/bar_menu"); ?>
</div>
