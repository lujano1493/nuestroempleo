<?php
  echo $this->element('empresas/title');
?>
<ul class="nav nav-pills tasks">
    <li>
      <?php
        echo $this->Html->link('Nueva Carpeta', array(
          'controller' => 'carpetas',
          'action' => 'nueva',
        ), array(
          'class' => 'btn btn-sm btn-purple'
        ));
      ?>
  </li>
</ul>

<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Usuario</th>
      <th>Tipo</th>
      <th>Creada</th>
      <th>Acciones</th>
      <th><input type="checkbox"></th>
    </tr>
  </thead>
  <tbody>
    <?php
      if (!empty($carpetas)) {
        foreach ($carpetas as $carpeta) :
          $c = $carpeta['Carpeta'];
          $u = $carpeta['Usuario'];
          $con = $carpeta['Contacto'];
    ?>
      <tr>
        <td class="">
          <?php
            echo $this->Html->link($c['carpeta_nombre'], array(
              'controller' => 'mis_candidatos',
              'action' => 'carpeta',
              'slug' => Inflector::slug($c['carpeta_nombre'], '-'),
              'id' => $c['carpeta_cve']
            ), array(
              //'icon' => 'folder-open'
            ));
          ?>
        </td>
        <td>
          <?php echo $con['con_nombre']; ?>
          <span>
            <?php echo $u['cu_sesion']; ?>
          </span>
        </td>
        <td><?php echo $c['tipo_cve']; ?></td>
        <td><?php echo $c['created']; ?></td>
        <td class="actions-container">
          <ul class="actions">
            <li>
              <?php
                echo $this->Html->link(null, array(
                  'action' => 'editar',
                  'id' => $c['carpeta_cve'],
                ), array(
                  'title' => 'Cambiar nombre',
                  'class' => 'btn btn-sm btn-green',
                  'data-toggle' => 'tooltip',
                  'icon' => 'edit'
                ));
              ?>
            </li>
<!--             <li>
              <?php
                echo $this->Html->link(null, array(
                  'action' => 'compartir',
                  'id' => $c['carpeta_cve'],
                ), array(
                  'title' => 'Hacer publica',
                  'class' => 'btn btn-small',
                  'data-toggle' => 'tooltip',
                  'icon' => 'share-sign'
                ));
              ?>
            </li> -->
            <?php if ($c['cu_cve'] == $authUser['cu_cve']): ?>
              <li>
                <?php
                  echo $this->Form->postLink(null, array(
                    'controller' => 'carpetas',
                    'action' => 'borrar',
                    'id' => $c['carpeta_cve'],
                  ), array(
                    'title' => 'Borrar carpeta',
                    'class' => 'btn btn-sm btn-danger',
                    'data-toggle' => 'tooltip',
                    'icon' => 'trash'
                  ));
                ?>
              </li>
            <?php endif; ?>
          </ul>
        </td>
        <td><input type="checkbox"></td>
      </tr>
    <?php
        endforeach;
      } else {
    ?>
      <tr>
        <td colspan="6">
          No tienes ninguna carpeta.
          <?php
            echo $this->Html->link('Agrega una nueva.', array(
              'controller' => 'carpetas',
              'action' => 'nueva'
            ));
          ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>