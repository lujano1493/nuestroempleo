<?php
  echo $this->element('empresas/title');
?>

<div class="row">
  <div class="col-xs-8">
    <h5 class="subtitle">
      <i class="icon-shopping-cart"></i><?php echo __('Nuestros Productos'); ?>
    </h5>
    <p>
      Conozca todas las opciones que Nuestro Empleo tiene para su Compañía, filtre eficazmente a sus candidatos y cubra sus
      vacantes en tiempo record. <br><br>
      Estos son algunos de nuestros diferenciadores:
    </p>
    <div class="row productos green">
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-pencil round-icon"></i>
          <h5><?php echo __('Evaluaciones'); ?></h5>
        </div>
        <p>Aplique pruebas psicométricas y técnicas en línea. Reciba los resultados al instante y ahorre tiempos de Selección.</p>
      </div>
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-calendar round-icon"></i>
          <h5><?php echo __('Eventos'); ?></h5>
        </div>
        <p>Publicación de eventos masivos de reclutamiento, ferias de los empleos locales y nacionales y específicos por compañía.</p>
      </div>
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-ok round-icon"></i>
          <h5><?php echo __('Referencias'); ?></h5>
        </div>
        <p>Certificación de referencias a través de encuestas online.</p>
      </div>
    </div>
    <div class="row productos purple">
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-comments round-icon"></i>
          <h5><?php echo __('Ofertas Interactivas'); ?></h5>
        </div>
        <p>Haga sus postulaciones más atractivas permitiendo que el candidato publique dudas o comentarios referentes a la oferta.</p>
      </div>
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-download round-icon"></i>
          <h5><?php echo __('Expediente Virtual'); ?></h5>
        </div>
        <p>Visualice la documentación más importante del candidato y descárguela en cualquier momento para contratarlo.</p>
      </div>
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-star round-icon"></i>
          <h5><?php echo __('Sello de empresa Premium'); ?></h5>
        </div>
        <p>Permite que Nuestro Equipo realice una sencilla verificación a tu Empresa y adquiere este distintivo.</p>
      </div>
    </div>
    <div class="row productos blue">
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-laptop round-icon"></i>
          <h5><?php echo __('Micrositio'); ?></h5>
        </div>
        <p>Personalice la bolsa de empleo de acuerdo al diseño de su marca.</p>
      </div>
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-rss round-icon"></i>
          <h5><?php echo __('Mensajes SMS'); ?></h5>
        </div>
        <p>El sistema filtrará candidatos acordes a tu vacante y le enviará tu oferta vía SMS.</p>
      </div>
      <div class="col-xs-4 text-center">
        <div class="heading-icon">
          <i class="icon-edit round-icon"></i>
          <h5><?php echo __('Notas en CV'); ?></h5>
        </div>
        <p>Agrega recordatorios y/o comentarios al CV del candidato y facilita tu proceso de selección.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <p>
          <strong>
            Entre en contacto con nosotros ahora mismo y deje que uno de nuestros ejecutivos estudie su caso específico y le brinde
            información sobre el producto que más le conviene.
            </strong>
        </p>
        <div class="btn-actions text-center">
          <?php
            echo $this->Html->link(__('Contacto'), '#contacto-ejecutivo', array(
              'class' => 'btn btn-sm btn-blue',
              'data-toggle' => 'modal',
            ));
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-4">
    <h5 class="subtitle">
      <i class="icon-tasks"></i><?php echo __('Datos de mi Cuenta'); ?>
    </h5>
    <div class="row">
      <div class="col-xs-12">
        <ul class="list-unstyled">
          <li>
            <h5>
              <small><?php echo __('Empresa'); ?></small>
              <?php echo $this->Session->read('Auth.User.Empresa.cia_razonsoc'); ?>
            </h5>
          </li>
          <li>
            <h5>
              <small><?php echo __('Socio'); ?></small>
              <?php echo $this->Session->read('Auth.User.Empresa.cia_cve'); ?>
            </h5>
          </li>
          <li>
            <h5>
              <small><?php echo _('Socio desde'); ?></small>
              <?php
                $since = $this->Session->read('Auth.User.Empresa.created');
                echo $this->Time->d($since);
              ?>
            </h5>
          </li>
        </ul>
        <div class="btn-actions">
          <?php
            echo $this->Html->spanLink(__('Contacta a un Ejecutivo'), '#contacto-ejecutivo', array(
              'class' => 'btn btn-blue btn-block btn-multiline',
              'data-toggle' => 'modal',
              'icon' => 'comment icon-2x',
            ));

            echo $this->Html->spanLink(__('Recomendamos los siguientes Productos'), array(
              'controller' => 'mis_productos',
              'action' => 'recomendaciones'
            ), array(
              'class' => 'btn btn-green btn-block btn-multiline',
              'icon' => 'thumbs-up icon-2x',
            ));

            echo $this->Html->spanLink(__('Mis Productos Adquiridos'), array(
              'controller' => 'mis_productos',
              'action' => 'adquiridos'
            ), array(
              'class' => 'btn btn-purple btn-block btn-multiline',
              'icon' => 'shopping-cart icon-2x',
            ));

            echo $this->Html->spanLink(__('Mis Facturas'), array(
              'controller' => 'mis_productos',
              'action' => 'facturas'
            ), array(
              'class' => 'btn btn-orange btn-block btn-multiline',
              'icon' => 'file icon-2x',
            ));
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $this->element('empresas/contacto_ejecutivo'); ?>