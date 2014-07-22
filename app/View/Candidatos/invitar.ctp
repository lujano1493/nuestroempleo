<?php
  echo $this->element('empresas/title');
?>

<div class="">
  <?php
    echo $this->Form->create(false, array(
      'class' => 'no-lock'
    ));
  ?>
    <div class="alert alert-success">
      <p>Invita hasta 20 futuros Candidatos a unirse a Nuestro Empleo.</p>
    </div>
    <div class="row">
      <div class="col-xs-12" id="invites">
        <div class="row">
          <div class="col-xs-6">
            <label for="Invitacion6bbd88Nombre">
              <?php echo __('Nombre') ?>
            </label>
          </div>
          <div class="col-xs-5">
            <label for="Invitacion6bbd88Email">
              <?php echo __('Correo Electrónico') ?>
            </label>
          </div>
        </div>
        <ol>
          <li class="row">
            <div class="col-xs-6">
              <?php
                echo $this->Form->input('Invitacion.6bbd88.nombre', array(
                  'class' => 'form-control input-sm',
                  'label' => false, __('Nombre'),
                  'required' => true,
                ));
              ?>
            </div>
            <div class="col-xs-5">
              <?php
                echo $this->Form->input('Invitacion.6bbd88.email', array(
                  'class' => 'form-control input-sm',
                  'label' => false, //__('Correo Electrónico'),
                  'required' => true,
                  'type' => 'email'
                ));
              ?>
            </div>
            <div class="col-xs-1">
              <div class="input">
                <?php
                  echo $this->Html->link('', '#', array(
                    'class' => 'btn btn-sm btn-danger btn-block disabled rm-item',
                    'icon' => 'remove-sign',
                    'disabled' => true
                  ));
                ?>
              </div>
            </div>
          </li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="text-center">
          <?php
            echo $this->Html->link(__('Agregar'), '#', array(
              'icon' => 'plus',
              'class' => 'new-invite'
            ));
          ?>
        </div>
        <div class="btn-actions">
          <?php
            echo $this->Html->link(__('Aceptar'), '#', array(
              'class' => 'btn btn-success btn-lg',
              'data' => array(
                'submit' => true
              )
            ));
          ?>
        </div>
      </div>
    </div>
    <div class="results">

    </div>
  <?php
    echo $this->Form->end();
  ?>
</div>

<?php
  echo $this->Template->insert(array(
    'invitaciones',
    'invitacion-enviada'
  ));
?>
