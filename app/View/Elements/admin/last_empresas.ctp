<table class="table table-condensed table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>RFC</th>
      <th>Contacto</th>
      <th>Cuenta</th>
      <th>Télefono</th>
      <th>Fecha de Alta</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($last_empresas as $empresa):
        $e = $empresa['Empresa'];
        $a = $empresa['Admin'];
        $c = $empresa['AdminContacto'];
    ?>
      <tr>
        <td><?php echo $e['cia_cve']; ?></td>
        <td>
          <?php
            echo $this->Html->link($e['cia_nombre'], array(
              'admin' => $isAdmin,
              'controller' => 'empresas',
              'action' => 'historial',
              'id' => $e['cia_cve'],
              'slug' => Inflector::slug($e['cia_nombre'], '-')
            ), array(
              'data' => array(
                'component' => 'ajaxlink',
                'magicload-target' => '#main-content',
                'item-id' => $e['cia_cve']
              )
            ));
          ?>
        </td>
        <td><?php echo $e['cia_rfc']; ?></td>
        <td><?php echo $c['con_nombre']; ?></td>
        <td>
          <?php
            echo $a['cu_sesion'];
            // echo $this->Html->link($a['cu_sesion'], array(
            //   'admin' => $isAdmin,
            //   'controller' => 'empresas',
            //   'action' => 'administrador',
            //   'id' => $e['cia_cve']
            // ));
          ?>
        </td>
        <td>
          <?php
            echo !empty($c['con_tel']) ? $c['con_tel'] : __('N/D');
          ?>
        </td>
        <td><?php echo $this->Time->dt($e['created']); ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>