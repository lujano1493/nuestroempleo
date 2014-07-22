<?php 
    $icon_time = $this->Html->tag('i', '', array('class' => 'icon-time')); 
    $icon_ok = $this->Html->tag('i', '', array('class' => 'icon-ok'));  
    $icon_trash = $this->Html->tag('i', '', array('class' => 'icon-remove-sign'));
?>
<?php echo $this->Session->flash(); ?>
<table class="table table-condensed">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Correo Electr&oacute;nico</th>
      <th>Compa&ntilde;ia</th>
      <th>Teléfonos</th>
      <th>Horario de Contacto</th>
      <th>Medio Informaci&oacute;n</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($lista_contactos as $contacto):
        $c = $contacto['EmpresaSolicitud'];
        $status = $c['status_class'];
    	?>
      <tr class="<?php echo $status; ?>">
          <td><?php echo isset($c['nombre']) ? $c['nombre'] : $c['solicitud_nom']; ?></td>
          <td><?php echo $c['solicitud_mail']; ?></td>
          <td><?php echo $c['solicitud_cia']; ?></td>
          <td>
              <?php echo $c['solicitud_tel'] . ' / ' . $c['solicitud_cel']; ?>
          </td>
          <td>
            <span>
              <i class="icon-calendar"></i>
              <?php echo $c['solicitud_horario']; ?>
            </span>
          </td>
          <td><?php echo $lista_medios[$c['medioinf_cve']]; ?></td>
          <td class="center-text">
            <span class="status <?php echo $status; ?>" 
              title="<?php echo $c['status_nom'];?>" data-toggle="tooltip" data-placement="right">
              <i class="icon-circle"></i>
            </span>
          </td>
          <td class="actions">
              <?php 
              if ($status != 'prospecto' && $status != 'concretado') {
                echo $this->Form->postLink($icon_time, array(
                  'admin' => 1,
                  'controller' => 'contacto',
                  'action' => 'prospecto', 
                  $c['solicitud_cve']
                ), array(
                  'title' => 'Prospecto',
                  'class' => 'btn btn-small btn-primary',
                  'data-toggle' => 'tooltip',
                  'escape' => false
                ),
                  '¿Desea cambiar el estado de esta petición a Prospecto?'
                );
              }
              if ($status != 'concretado') {
                echo $this->Html->link($icon_ok, array(
                  'admin' => 1,
                  //'controller' => 'empresas',
                  'action' => 'registrar', 
                  $c['solicitud_cve']
                ), array(
                  'title' => 'Aprobar', 
                  'class' => 'btn btn-small btn-success', 
                  'data-toggle' => 'tooltip', 
                  'escape' => false
                ));
              }
              if ($status != 'noconcretado' && $status != 'concretado') {
                echo $this->Form->postLink($icon_trash, array(
                  'admin' => 1,
                  'controller' => 'contacto',
                  'action' => 'cancelar', 
                  $c['solicitud_cve']
                ), array(
                  'title' => 'Cancelar',
                  'class' => 'btn btn-small btn-danger',
                  'data-toggle' => 'tooltip',
                  'escape' => false
                ),
                  '¿Estás seguro que desea cancelar esta petición?'
                ); 
              }
              ?>
          </td>
      </tr>
      <?php
          endforeach;
      ?>
  </tbody>
</table>

<?php $this->Html->script('bootstrap/tooltip', array('inline' => false)); ?>