<div class="center">
  <!-- Botón que activa el panel -->
  <a href="#" id="abre_tab_der">
    <div id="tab_der">
      <div id="tab_der_interna">

      </div>
    </div>
  </a>

  <!-- Panel oculto -->
  <div id="panel_der">
    <div class="contenido_der">
      <div class="center" style="margin-right:20px;">
        <div>
              <?=$this->element("empresas/inicio/contacto")?>
        </div>
      </div>
    </div>
  </div>
  <div class="row container" style="margin-bottom:10px; margin-top:20px;">
    <table class="table table-bordered table-striped">
      <tbody>
        <tr>

          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;"> <i class="icon-edit icon-2x"></i>
              &nbsp;EVALUACIONES
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Aplique pruebas psicométricas y técnicas en línea. Reciba los resultados al instante y ahorre tiempos de Selección.
            </p>
          </td>
          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;"> <i class="icon-calendar icon-2x"></i>
              &nbsp;EVENTOS
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Publicación de eventos masivos de reclutamiento, ferias de los empleos locales y nacionales y específicos por compañía.
            </p>
          </td>
          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-thumbs-up icon-2x"></i>
              &nbsp;REFERENCIAS
            </div>
            <p style="padding-left:40px; padding-right:15px;">Certificación de referencias a través de encuestas online.</p>
          </td>
        </tr>
        <tr>

          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-comments-alt icon-2x"></i>
              &nbsp;VACANTES INTERACTIVAS
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Haga sus postulaciones más atractivas permitiendo que el candidato publique dudas o comentarios referentes a la oferta.
            </p>
          </td>
          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-copy icon-2x"></i>
              &nbsp;EXPEDIENTE VIRTUAL
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Visualice la documentación más importante del candidato y descárguela en cualquier momento para contratarlo.
            </p>
          </td>
          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-mobile-phone icon-2x"></i>
              &nbsp;MENSAJES SMS
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              El sistema filtrará candidatos acordes a tu vacante y le enviará tu oferta vía SMS..
            </p>
          </td>

        </tr>
        <tr>

          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-laptop icon-2x"></i>
              &nbsp;MICROSITIO
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Personalice la bolsa de empleo de acuerdo al diseño de su marca.
            </p>
          </td>
          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-star icon-2x"></i>
              &nbsp;SELLO DE EMPRESA PREMIUM
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Permite que Nuestro Equipo realice una sencilla verificación a tu Empresa y adquiere este distintivo.
            </p>
          </td>
          <td class="span3 left">
            <div class="empresas_index-tit" style="padding-left:10px;">
              <i class="icon-pencil icon-2x"></i>
              &nbsp;NOTAS EN CV
            </div>
            <p style="padding-left:40px; padding-right:15px;">
              Permite que Nuestro Equipo realice una sencilla verificación a tu Empresa y adquiere este distintivo.
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?=$this->element("inicio/modalinfo",array(
                                          "id"=> "completo_contacto_empresa_01",
                                          "title" => "Registro Completo",
                                          "content" =>'La información fue enviada con éxito. En breve nos pondremos en contacto.',
                                          "back" =>   "<a  data-dismiss='modal' aria-hidden='true' href=''>Cerrar formulario</a>"

  ))?>