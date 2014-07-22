<?php
  echo $this->element('empresas/title');
?>

<p class="well well-small info">
  Captura los datos de tu empresa para gozar de los beneficios de
  <?php echo $this->element('common/logo', array('class' => 'small')); ?>, entre los cuales destacan:
  Publicaci&oacute;n de ofertas, Acceso a nuestra base de Curr&iacute;culums, Administraci&oacute;n de cuentas, etc.
  <strong>
    Por favor, llena los datos de tu empresa lo m&aacute;s claro posible, recuerda que esta informaci&oacute;n
    sirve tanto para el candidato, como para la facturaci&oacute;n.
  </strong>
</p>
<?php
  if ($isEmpresaAdmin) {
    echo $this->element('empresas/subir_logo');
    ?>
    <!-- <div class="row">
      <div class="n_clientes span3">
        <div class="work span3">
          <?php
            echo $this->Html->image($this->Session->read('Auth.User.Empresa.logo'), array(
              'alt' => 'Mi logotipo',
              'id' => 'img-logo'
            ));
          ?>
        </div>
        <?php
          echo $this->Html->link('Cambiar / subir imagen', '#subir-logo', array(
            'data-toggle' => 'modal',
            'id' => 'upload-logo'
          ));
        ?>
      </div>
    </div> -->
    <?php
    if ($this->Acceso->checkProfile(null, 'diamond')) {
      echo $this->element('empresas/micrositio_config');
    }
    echo $this->element('empresas/datos_empresa');
    echo $this->element('empresas/datos_facturacion');
  }
  echo $this->element('empresas/datos_usuario');

?>