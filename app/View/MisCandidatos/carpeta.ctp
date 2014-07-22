<?php
  echo $this->element('empresas/title');
?>
<ul class="nav nav-pills tasks">
    <li>
      <?php
        echo $this->Html->link('Buscar', array(
          'controller' => 'candidatos',
          'action' => 'index'
        ));
      ?>
  </li>
</ul>

<table class="table table-striped table-bordered" data-component='dynamic-table'>
  <thead>
    <tr class='table-header'>
      <th colspan="9">
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th>Perfil</th>
      <th>Sueldo</th>
      <th>Experiencia</th>
      <th>Estudios</th>
      <th>Acciones</th>
      <th><input type="checkbox"></th>
    </tr>
  </thead>
  <tbody>
    <?php
      //$candidatos = $carpeta['Candidatos'];
      if (!empty($candidatos)) {
      foreach ($candidatos as $candidato):
        $c = $candidato;
    ?>
    <tr>
      <td>
        <?php 
          echo $this->Html->link($c['nombre'], array(
            'controller' => 'mis_candidatos',
            'action' => 'perfil',
            'id' => $c['candidato_cve'],
            //'slug' => Inflector::slug($u['cu_sesion'], '-')
          )); 
        ?>
      </td>
      <td>Mil Ocho Mil</td>
      <td>Muchísima</td>
      <td>Harvard</td>
      <td></td>
      <td><input type="checkbox"></td>
    </tr>
    <?php
      endforeach;
    } else {
    ?>
      <tr>
        <td colspan="9">
          No tienes ningún Candidato.
          <?php
            echo $this->Html->link('Buscar candidatos.', array(
              'controller' => 'candidatos',
              'action' => 'index'
            ));
          ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>