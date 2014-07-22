<?php
  $_emp = $empresa['Empresa'];
  $_admin = $empresa['Administrador'];

  echo $this->element('admin/title');
?>

<ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Lista de Empresas', array(
        'admin' => $isAdmin,
        'controller' => 'empresas',
        'action' => 'index'
      ));
    ?>
  </li>
</ul>

<table class="table table-condensed table-striped table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Nombre</th>
      <th>Cuenta</th>
      <th>Perfil</th>
      <th>Creado</th>
      <th>Acciones</th>
      <th>
        <input type="checkbox">
      </th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($usuarios as $usuario):
        $u = $usuario['UsuarioEmpresa'];
        $c = $usuario['Contacto'];
        $p = $usuario['Perfil'];
    ?>
      <tr>
        <td>
          <?php
            echo $this->Html->link($u['cu_cve'], array(
              'admin' => $isAdmin,
              'controller' => 'cuentas',
              'action' => 'ver',
              'id' => $u['cu_cve']
            ));
          ?>
        </td>
        <td><?php echo $c['nombre']; ?></td>
        <td>
          <?php
            echo $this->Html->link($u['cu_sesion'], array(
              'admin' => $isAdmin,
              'controller' => 'empresas',
              'action' => 'usuarios',
              'id' => $_emp['cia_cve'],
              $u['cu_cve']
            ));
          ?>
          <?php if ($_admin['cu_cve'] === $u['cu_cve']): ?>
            <span class="badge pull-right">Administrador</span>
          <?php endif ?>
        </td>
        <td><?php echo $p['per_nom']; ?></td>
        <td><?php echo $u['created']; ?></td>
        <td class="actions-container">
          <ul class="actions">
            <li>
              <?php
                echo $this->Html->link('', array(
                  'admin' => $isAdmin,
                  'controller' => 'cuentas',
                  'action' => 'status',
                  'id' => $u['cu_cve']
                ), array(
                  'icon' => 'lock',
                  'class' => 'btn btn-small'
                ));
              ?>
            </li>
            <li>
              <?php
                echo $this->Html->link('', array(
                  'admin' => $isAdmin,
                  'controller' => 'cuentas',
                  'action' => 'editar',
                  'id' => $u['cu_cve']
                ), array(
                  'class' => 'btn btn-primary btn-small',
                  'icon' => 'pencil'
                ));
              ?>
            </li>
          </ul>
        </td>
        <td>
          <input type="checkbox">
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>