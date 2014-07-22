<?php
  echo $this->element('admin/title');
?>

<ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Ver todas las facturas', array(
        'admin' => $isAdmin,
        'controller' => 'facturas',
        'action' => 'empresas'
      ));
    ?>
  </li>
  <li>
    <?php
      echo $this->Html->link('Ver todas las empresas', array(
        'admin' => $isAdmin,
        'controller' => 'facturas',
        'action' => 'empresas'
      ));
    ?>
  </li>
</ul>

<?php echo $this->Form->create('Factura'); ?>
  <fieldset>
    <legend>Datos de la empresa</legend>
    <div class="row-fluid">
      <div class="span4">
        <?php echo $data['Empresa']['cia_nombre']; ?>
      </div>
      <div class="span4">
        <?php echo $data['Empresa']['cia_razonsoc']; ?>
      </div>
      <div class="span4">
        <?php echo $data['Empresa']['cia_rfc']; ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <?php echo $data['DatosEmpresa']['calle']; ?>
      </div>
      <div class="span4">
        <?php echo 'Colonia'; ?>
      </div>
      <div class="span4">
        <?php echo 'Municipio'; ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <?php echo $data['Contacto']['con_nombre']; ?>
      </div>
      <div class="span6">
        <?php echo $data['Administrador']['cu_sesion']; ?>
      </div>
    </div>
  </fieldset>
  <fieldset>
    <legend>Detalles</legend>
  </fieldset>
<?php echo $this->Form->end(); ?>