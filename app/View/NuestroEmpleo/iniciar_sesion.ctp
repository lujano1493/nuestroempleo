<!-- Header -->
<div id="out_container">
  <!-- Empieza contenido -->
  <div class="contenido">
    <!-- busqueda -->
    <div id="header-index" class="superior">
      <div class="container">
        <div class="row superior">
          Bienvenido al Portal de Administración de:<br>
          <div id="logo">
            <img src="/img/admin/logo.png" width="539" height="227">
          </div>
        </div>
      </div>
    </div>
    <!-- contacto -->
    <div class="container">
      <div id="intro-index" class="inferior inferior-style1">
        <div class="title">Datos de Acceso</div>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-md-offset-4">
              <?php
                echo $this->Form->create(false, array(
                  'class' => ''
                ));
                  echo $this->Session->flash();
              ?>
                <fieldset>
                  <div class="form-group">
                    <?php
                      echo $this->Form->input('UsuarioAdmin.cuenta', array(
                        'class' => 'form-control text-center',
                        'label' => 'Usuario:',
                        'icon' => 'user',
                        'placeholder' => 'Correo Electrónico'
                      ));
                    ?>
                  </div>
                  <div class="form-group">
                    <?php
                      echo $this->Form->input('UsuarioAdmin.password', array(
                        'class' => 'form-control text-center',
                        'label' => 'Contraseña:',
                        'icon' => 'key',
                        'placeholder' => 'Contraseña'
                      ));
                    ?>
                  </div>
                  <?php
                    echo $this->Form->submit('Entrar', array(
                      'class' => 'btn_color'
                    ));
                  ?>
                </fieldset>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="contenedor">
        <div class="row">
          <div class="span5">
            <p>D.R. ©; iGenter México S. de R.L. de C.V., Nuevo León No. 202 Piso 5, Colonia Hipódromo Condesa, C.P. 06170, Delegación Cuauhtémoc, México, D.F., 2014.<br/>Prohibida la reproducción total o parcial de esta obra sin la previa autorización de su titular.</p>
          </div>
          <div class="right span3 pull-right">
            <p><a href="#">Ayuda</a></p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</div>