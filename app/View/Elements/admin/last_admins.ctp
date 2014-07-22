<div class="well">
  <p class="title">&Uacute;ltimas <?php echo $this->Html->link('cuentas', array(
    'admin' => $isAdmin,
    'controller' => 'cuentas',
    'action' => 'index'
  )) ?> registradas.</p>
  <table class="table table-condensed table-striped table-bordered">
    <thead>
      <tr>
        <th>Clave</th>
        <th>Contacto</th>
        <th>Cuenta</th>
        <th>Perfil</th>
        <th>Fecha de Alta</th>
        <th>Registrado por</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        foreach ($admins as $admin):
          $u = $admin['UsuarioAdmin'];
          $s = $admin['Superior'];
          $p = $admin['Perfil'];
          $c = $admin['Contacto'];
      ?>

        <tr>
          <td><?php echo $u['cu_cve']; ?></td>
          <td>
            <?php 
              echo $this->Html->link($c['con_nombre'], array(
                'admin' => $isAdmin,
                'controller' => 'cuentas',
                'action' => 'detalles',
                'id' => $c['cu_cve']
              )); 
            ?>
          </td>
          <td>
            <?php 
              echo $this->Html->link($u['cu_sesion'], array(
                'admin' => $isAdmin,
                'controller' => 'cuentas',
                'action' => 'ver',
                'id' => $u['cu_cve']
              ));
            ?>
          </td>
          <td><?php echo $p['per_nom']; ?></td>
          <td><?php echo $u['created']; ?></td>
          <td><?php echo $s['cu_sesion']; ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>