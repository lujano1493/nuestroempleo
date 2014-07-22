<?php 

  $m= ( !empty($micrositio)? "$micrositio[name]" :''  ) ;   

?>


<?=
  $this->element("/inicio/menu_liga_inicio",array(
    "titulo" =>"Cargar CV",
    "icono" =>"upload-alt",
    "liga"=> "#",
    "extra" => "data-toggle=\"modal\" data-target=\"#modal-nuevo-form-candidato01\" data-backdrop=\"static\" data-keyboard=\"false\" "
  ))
?>      
<?=
  $this->element("inicio/menu_liga_inicio",array(
    "titulo" =>"Ver Ofertas",
    "icono" =>"file",
    "liga"=> "/$m/busquedaOferta/index",
    "extra" =>""
  ))
?>

<?=
  $this->element("inicio/menu_liga_inicio",array(
    "titulo" =>"Ayuda",
    "icono" =>"question-sign",
    "liga"=> "/$m/informacion/preguntas_frecuentes_candidato",
    "extra" =>""
  ))
?>
