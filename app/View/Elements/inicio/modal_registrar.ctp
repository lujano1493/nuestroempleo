
<?php if (!$isAuthUser): ?>

<div id="modal-nuevo-form-candidato01"   class="modal hide"  data-component="modalform" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title forma_genral_tit">Registro de nuevo candidato</h2>
      </div>
      <div class="modal-body">

      <div class="ajax-done hide">
      <div class="row-fluid" >
        <div class="span1"> </div>
        <div class="span10">
            <div class="row-fluid">
              <div class="span12 well">
                Tu registro se llevó a cabo de manera exitosa, se ha enviado una contraseña a tu correo electrónico, con ella
                podrás acceder a <a href="/"> <strong> Nuestro Empleo </strong> </a>.
              </div>
            </div>
        </div>
        <div class="span1"> </div>
      </div>
    </div>

    <div class="formulario">

      <div class="alert-container clearfix">
          <div class="alert alert-info" fade="" in="">
              Ingresa tus datos personales y de contacto, los campos que tienen (*)  son obligatorios para registro.
          </div>
      </div>
          <?php  echo $this->element("candidatos/tool/registro_rapido");  ?>


    </div>

        <a  class="" data-dismiss="modal" aria-hidden="true" href="" >Cerrar formulario</a>
      </div>
      <div class="modal-footer">
    <!--     <button type="button" class="btn btn_small" data-dismiss="modal">Cerrar</button>  -->
      </div>

</div>




<?php  endif;?>