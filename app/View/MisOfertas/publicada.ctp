<?php
  echo $this->element('empresas/title');
?>
<div class="">
  <?php if (true): ?>
    <div>
      <p>Tu vacante se ha publicado con éxito, si deseas compartirla en las redes sociales lo podrás hacer con el siguiente link.</p>
      <?php
        if ($shortenUrl) {
          echo $this->Html->link($shortenUrl, $shortenUrl, array(
            'class' => 'shorten-url',
            'target' => '_blank'
          ));
        } else {
          echo $this->Html->link(__('Intentar generar link'), $this->here, array(
            'class' => 'btn btn-default',
          ));
        }
      ?>
      <p class="social_vacantes">
        <a class="facebook" href="https://www.facebook.com/NuestroEmpleo" target="_blank" ></a>
                        <a class="linkedin" href="http://mx.linkedin.com/company/nuestro-empleo" target="_blank"></a>
                        <a class="twitter" href="https://twitter.com/NuestroEmpleo" target="_blank"></a>
                        <a class="googleplus" href="https://plus.google.com/111610607829310871158/posts" target="_blank"></a>
      </p>
    </div>
  <?php endif ?>
  <div>
    <?php
      echo $this->Html->link('Regresar a Mis Ofertas', array(
        'controller' => 'mis_ofertas',
        'action' => 'index'
      ), array(
        'class' => 'btn btn-small',
        'data-close' => true,
        'icon' => 'arrow-left',
        'after' => true
      ));
    ?>
  </div>
  <p>Encontramos varios candidatos que podrían cubrir tu vacante.</p>
</div>

<div class="row">
  <div class="col-xs-12">
    <table id="busqueda-candidato" class="table table-bordered" data-table-role="main"
      data-component="dynamic-table" data-source-url="/mis_ofertas/<?php echo $ofertaID; ?>/match.json">
      <thead>
        <tr class="table-header">
          <th colspan="6">
            <div class="pull-left btn-actions">
              <?php
                echo $this->Html->link('Guardar en', array(
                  'controller' => 'mis_candidatos',
                  'action' => 'guardar_en'
                ), array(
                  'class' => 'btn btn-sm btn-aqua',
                  'data-component' => 'folderito',
                  'data-source' => '/carpetas/candidatos.json',
                  'data-controller' => 'mis_candidatos',
                  'icon' => 'folder-close',
                  'after' => true
                ));
              ?>
            </div>
            <div id="filters" class="pull-right"></div>
          </th>
        </tr>
        <tr>
          <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
          <th data-table-prop="#tmpl-foto" data-table-order="none" width='100'></th>
          <th data-table-prop="#tmpl-perfil">Perfil</th>
          <th data-table-prop="#tmpl-sueldo">Sueldo</th>
          <th data-table-prop="#tmpl-experiencia">Experiencia Laboral</th>
          <th data-table-prop="#tmpl-estudios">Estudios</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'foto',
    'perfil__match',
    'sueldo',
    'experiencia',
    'estudios',
    'acciones__index' => 'acciones-match'
  ), null, array(
    'viewPath' => 'MisCandidatos'
  ));
?>