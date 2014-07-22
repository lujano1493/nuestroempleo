<?php
  echo $this->element('admin/title');
?>

<ul class="nav nav-pills tasks">
    <li>
      <?php
        echo $this->Html->link('Ver todas las Facturas', array(
          'admin' => $isAdmin,
          'controller' => 'facturas',
          'action' => 'index'
        ));
      ?>
  </li>
</ul>

<table class="table table-condensed table-striped table-bordered">
  <thead>
    <tr>
      <th>Clave</th>
      <th>Nombre</th>
      <th>Raz&oacute;n Social</th>
      <th>Contato</th>
      <th>Email</th>
      <th>Acciones</th>
      <!--<th>Fecha de Alta</th>
      <th>Tipo de Memebresia</th>
      <th>Fecha de Vencimiento</th> -->
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($empresas as $empresa):
        $e = $empresa['Empresa'];
        $a = $empresa['Administrador'];
        $c = $empresa['Contacto'];
    ?>
    <tr>
      <td>
        <?php
          echo $this->Html->link($e['cia_cve'], array('admin' => 1, 'action' => 'ver', $e['cia_cve']), array());
        ?>
      </td>
      <td>
        <?php
          echo $this->Html->link($e['cia_nombre'], array('admin' => 1, 'action' => '/', $e['cia_cve']), array());
        ?>
      </td>
      <td><?php echo $e['cia_razonsoc']; ?></td>
      <td><?php echo $c['con_nombre'] . ' ' . $c['con_paterno']; ?></td>
      <td><?php echo $a['cu_sesion']; ?></td>
      <td class="actions-container">
        <ul class="actions">
          <li>
            <?php
              echo $this->Html->link('Ver Facturas', array(
                'admin' => $isAdmin,
                'controller' => 'empresas',
                'action' => 'facturas',
                'id' => $e['cia_cve']
              ));
            ?>
          </li>
          <li>
            <?php
              echo $this->Html->link('Nueva Factura', array(
                'admin' => $isAdmin,
                'controller' => 'empresas',
                'action' => 'facturas',
                'id' => $e['cia_cve'],
                'nuevo'
              ));
            ?>
          </li>
        </ul>
      </td>
    </tr>
    <?php
      endforeach;
    ?>
  </tbody>
</table>