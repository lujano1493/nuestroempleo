<?php

//if($this->name==="Pages"){
$activite="current-page";
//}
/*else{
$pass="href=\"/\"";
$activite="";
}


if($this->name==="Empresas"){
$pass="class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"";
$activite="current-page";
}
else{
$pass="href=\"/empresas\"";
$activite="";
}
*/

?>
<?=$this->element("inicio/menu_opcion_inicio",
  array(
    "titulo" => "Candidato",
    "icono" =>"group",
    "submenu" =>
    array(
      array(
        "titulo" =>"REGISTRO DE CANDIDATO",
        "atributos" => array(
          "class"=>"option-registrate-candidato",
          "data-toggle"=>"modal",
          "data-target"=>"#modal-nuevo-form-candidato01",
          "data-backdrop"=>"static",
          "data-keyboard"=>"false"

          )

        ),
      array(
        "titulo" =>"RECUPERACIÓN DE CONTRASEÑA",
        "atributos" => array(
          "class"=>"option-recuperar-contrasena-candidato",
          "data-toggle"=>"modal",
          "data-target"=>"#recuperar_pass",
          "data-backdrop"=>"static",
          "data-keyboard"=>"false"

          )

        ),
      array(
        "titulo" =>"REENVIAR CORREO DE ACTIVACIÓN",
        "atributos" => array(
          "data-toggle"=>"modal",
          "data-target"=>"#reenvio_mail",
          "data-backdrop"=>"static",
          "data-keyboard"=>"false"

          )

        ),
      array(
        "titulo" =>"BÚSQUEDA AVANZADA",
        "change_atr" => true,
        "atributos" => array(
          "href"=>"/#search-avanced-01"
          ),
        "atr_extras"=> array(
          "Informacion/index"=>array(
            "data-component" => "triggerelement",
            "data-target"=>"#search-avanced-01"

            ),
          "default" =>array(

            )

          )
        ),
      array(
        "titulo" =>"PREGUNTAS FRECUENTES",
        "atributos" => array(
          "href"=>"/informacion/preguntas_frecuentes_candidato"

          )

        )

      )


      ))?>


<?=$this->element("inicio/menu_opcion_inicio",
  array(
    "titulo" => "Empresas",
    "icono" =>"briefcase",
    "submenu" =>
    array(
      array(
        "titulo" =>"Nuestros Servicios",
        "atributos" => array(
          "href"=>"/empresas/index"
          )

        ),
      array(
        "titulo" =>"Registro de Empresas",
        "atributos" => array(
          "href"=>"#registro-empresas",
          "class"=>"option-recuperar-contrasena",
          "data-toggle"=>"modal",
          "data-backdrop"=>"static",
          "data-keyboard"=>"false"

          )

        ),
      array(
        "titulo" =>"RECUPERACIÓN DE CONTRASEÑA",
        "atributos" => array(
          "data-toggle"=>"modal",
          "data-target"=>"#recuperar_contrasena_empresas",
          "data-backdrop"=>"static",
          "data-keyboard"=>"false"

          )

        ),
      array(
        "titulo" =>"REENVIAR CORREO DE ACTIVACIÓN",
        "atributos" => array(
          "data-toggle"=>"modal",
          "data-target"=>"#reenvio_mail_empresas",
          "data-backdrop"=>"static",
          "data-keyboard"=>"false"

          )

        ),
      array(
        "titulo" =>"PREGUNTAS FRECUENTES",
        "atributos" => array(
          "href"=>"/informacion/preguntas_frecuentes_empresas"

          )
        ),
      array(
        "titulo" =>"CONTACTO",
        "atributos" => array(
          "href"=>"/empresas/index#tab_der"
          ),

        )

      )


      ))?>


<?=$this->element("inicio/menu_opcion_inicio",
  array(
    "titulo" => "Educación",
    "icono" =>"book",
    "submenu" =>
    array(
      array(
        "titulo" =>"Nuestros Convenios",
        "atributos" => array(
          "href"=>"/informacion/convenio_edu"
          )

        ),
      array(
        "titulo" =>"Más información",
        "atributos" => array(
          "href"=>"/informacion/mas_info_edu"
        )
      ),
      array(
        'titulo' => __('Nuestro Blog'),
        'atributos' => array(
          'href' => '/blog'
        )
      )
    )
  )
)?>
<?=$this->element("inicio/menu_liga_inicio",array(
  "titulo" =>"Eventos",
  "icono" =>"calendar",
  "liga"=> "/eventosCan/index",
  "extra" =>""

  ))?>


<?=$this->element("inicio/menu_opcion_inicio",
  array(
    "titulo" => "Conócenos",
    "icono" =>"building",
    "submenu" =>
    array(
      array(
        "titulo" =>"¿Quiénes somos?",
        "atributos" => array(
          "href"=>"/informacion/quienes_somos"
          )

        ),
      array(
        "titulo" =>"Misión, Visión y Valores",
        "atributos" => array(
          "href"=>"/informacion/valores"

          )
        ),
      array(
        "titulo" =>"Políticas de calidad",
        "atributos" => array(
          "href"=>"/informacion/politica"

          )
        )
      )

    )


    )?>

<?=$this->element("inicio/menu_opcion_inicio",
  array(
    "titulo" => "Ayuda",
    "icono" =>"question-sign",
    "submenu" =>
    array(
      array(
        "titulo" =>"Preguntas frecuentes Empresas",
        "atributos" => array(
          "href"=>"/informacion/preguntas_frecuentes_empresas"
          )

        ),
      array(
        "titulo" =>"Preguntas frecuentes Candidatos",
        "atributos" => array(
          "href"=>"/informacion/preguntas_frecuentes_candidato"

          )
        ),
      array(
        "titulo" =>"Preguntas frecuentes Convenios",
        "atributos" => array(
          "href"=>"/informacion/preguntas_frecuentes_convenios"

          )
        )
      )

    )


    )?>


<?=$this->element("inicio/menu_liga_inicio",array(
  "titulo" =>"Contacto",
  "icono" =>"envelope-alt",
  "liga"=> "/informacion/contacto",
  "extra" =>""

  ))?>