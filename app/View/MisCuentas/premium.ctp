<?php
  echo $this->element('empresas/title');
?>
<div>
  <h5 class="subtitle">
    <i class="icon-star"></i>Ser una Empresa Premium es muy sencillo
  </h5>
  <div class="row productos purple">
    <div class="col-xs-4 text-center">
      <div class="heading-icon">
        <i class="icon-search round-icon"></i>
        <h5>1. Verificación</h5>
      </div>
      <p>Nuestro Empleo realiza una verificación  para corroborar que la Empresa se encuentra legalmente constituida a través de una visita a sus instalaciones.</p>
    </div>
    <div class="col-xs-4 text-center">
      <div class="heading-icon">
        <i class="icon-ok-circle round-icon"></i>
        <h5>2. Empresa Premium</h5>
      </div>
      <p>Una vez realizada la verificación, colocaremos en cada una de sus vacantes, el sello de Empresa Premium, con esto...</p>
    </div>
    <div class="col-xs-4 text-center">
      <div class="heading-icon">
        <i class="icon-list-ol round-icon"></i>
        <h5>3. Más Postulaciones</h5>
      </div>
      <p>Los candidatos estarán seguros de que su Empresa publica vacantes confiables y tendrá un mayor  número de postulaciones y logrará prestigio dentro de la Bolsa de Trabajo, como una Empresa Socialmente  Responsable.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-8">
      <img src="/img/assets/estructura_premium.png" class="img-responsive">
    </div>
    <!-- Derecho sección -->
    <div class="col-xs-4">
      <h5 class="subtitle">
        <i class="icon-question-sign icon-2x"></i>¿Qué tengo que hacer?
      </h5>
      <div class="text-left">
        <?php
          echo $this->Html->spanLink(__('Ir al formulario'), '#contacto-premium', array(
            'data-toggle' => 'modal',
            'class' => 'btn btn-lg btn-purple btn-multiline btn-block',
            'icon' => 'star icon-2x'
          ));

          echo $this->Html->spanLink(__('¿Tienes alguna duda? Contacta a un ejecutivo Aquí'), '#contacto-ejecutivo', array(
            'data-toggle' => 'modal',
            'class' => 'btn btn-lg btn-green btn-multiline btn-block',
            'icon' => 'question icon-2x'
          ));
        ?>
      </div>
    </div>
  </div>
</div>

<?php echo $this->element('empresas/contacto_ejecutivo'); ?>
<?php echo $this->element('empresas/contacto_premium'); ?>