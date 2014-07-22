<li class="row">
  <div class="col-xs-6">
    <?php
      echo $this->Form->input(false, array(
        'class' => 'form-control input-sm',
        'label' => false,
        'name' => 'data[Invitacion][{{= it.id }}][nombre]',
        'id' => 'Invitacion{{= it.id }}nombre',
        'type' => 'text',
        'required' => true
      ));
    ?>
  </div>
  <div class="col-xs-5">
    <?php
      echo $this->Form->input(false, array(
        'class' => 'form-control input-sm',
        'label' => false,
        'name' => 'data[Invitacion][{{= it.id }}][email]',
        'id' => 'Invitacion{{= it.id }}email',
        'type' => 'email',
        'required' => true
      ));
    ?>
  </div>
  <div class="col-xs-1">
    <div class="input">
      <?php
        echo $this->Html->link('', '#', array(
          'class' => 'btn btn-sm btn-danger btn-block rm-item',
          'icon' => 'remove-sign',
        ));
      ?>
    </div>
  </div>
</li>