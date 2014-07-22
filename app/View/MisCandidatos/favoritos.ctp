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

<table class="table table-striped table-bordered table-hover">
  <thead>
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
        $c = isset($candidato['CandidatoEmpresa']) ? $candidato['CandidatoEmpresa'] : $candidato;
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
      <td class="actions-container">
        <ul class="actions">
          <li>
            <?php
              echo $this->Form->postLink('', array(
                'controller' => 'mis_candidatos',
                'action' => 'fav',
                'id' => $c['candidato_cve']
              ), array(
                'class' => 'btn btn-warning btn-small',
                'icon' => 'star',
                'title' => 'Agregar como favorito'
              ));
            ?>
          </li>
        </ul>
      </td>
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