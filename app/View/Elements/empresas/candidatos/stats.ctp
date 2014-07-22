<div class="fast-resume">
  <h5 class="subtitle">
    <i class="icon-tasks"></i>Resumen rápido
  </h5>
  <div class="row">
    <div class="col-xs-3 resume">
      <i class="icon-file-text"></i>
      <?php echo __('CV´s'); ?>
      <ul>
        <?php
          $cvsStats = $authUser['Stats']['candidatos']['stats'];

          foreach ($cvsStats as $key => $value):
        ?>
          <li>
            <span class="stat-label"><?php echo ucfirst($key); ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-xs-3 resume">
      <i class="icon-ok"></i>
      <?php echo __('Candidatos'); ?>
      <ul>
        <?php
          $foldersStats = $authUser['Stats']['candidatos']['folders'];
          // Un array en caso de que se quieran crear más estadísticas.
          $candidatosStats = array(
            'En Cartera' => array_sum(Hash::extract($foldersStats, '{n}.Carpeta.total'))
          );

          foreach ($candidatosStats as $key => $value):
        ?>
          <li>
            <span class="stat-label"><?php echo $key; ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-xs-3 resume">
      <i class="icon-ok"></i>
      <?php echo __('Liberaciones'); ?>
      <ul>
        <?php
          $creditos = $authUser['Creditos']['consulta_cv'];
          // Un array en caso de que se quieran crear más estadísticas.
          $liberacionesStats = array(
            'Disponibles' => (bool)$creditos['creditos_infinitos'] ? '&infin;' : $creditos['disponibles']
          );

          foreach ($liberacionesStats as $key => $value):
        ?>
          <li>
            <span class="stat-label"><?php echo $key; ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-xs-3">
      <?php echo $this->element('empresas/candidatos/main-tasks'); ?>
    </div>
  </div>
</div>