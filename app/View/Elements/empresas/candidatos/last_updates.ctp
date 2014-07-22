<div class="last-updates">
  <h5 class="subtitle">
    <i class="icon-file-text"></i><?php echo __('Últimos Currículums Adquiridos'); ?>
  </h5>
  <?php
    $chunks = array_chunk($candidatos, 4);
    foreach ($chunks as $k => $chunkCandidatos):
  ?>
    <div class="row">
      <?php foreach ($chunkCandidatos as $k => $c): ?>
        <?php
          $ce = $c['CandidatoB'];
          $isAcquired = (int)$c['Empresa']['adquirido'] === 1;

          $direccion = $isAcquired ? implode(', ', array(
            //$value['Direccion']['colonia'],
            $ce['ciudad_nom'],//$value['Direccion']['ciudad'],
            $ce['est_nom'],//$value['Direccion']['estado'],
            $ce['pais_nom'],//$value['Direccion']['pais'],
            $ce['cp_cp'],//$value['Direccion']['cp']
          )) : implode(', ', array(
            $ce['est_nom'], //$value['Direccion']['estado'],
            $ce['pais_nom'], //$value['Direccion']['pais'],
          ));
        ?>
        <div class="col-xs-3">
          <div class="card <?php echo $k & 1 ? 'even' : 'odd'; ?>">
            <?php
              echo $this->Html->image($ce['foto_url'], array(
                'alt' => '',
                'class' => 'img-oval img-md'
              ));
            ?>
            <h6 class="one-line" title="<?php echo ucwords($ce['candidato_perfil']); ?>">
              <?php echo ucwords($ce['candidato_perfil']); ?>
            </h6>
            <ul class="list-unstyled text-left">
              <li class="one-line">
                <?php
                  $cNombre = $ce['candidato_nom'] . ' ' . $ce['candidato_pat'] . ' ' . $ce['candidato_mat'];
                  echo ucwords($cNombre);
                ?>
              </li>
              <li><?php echo $ce['candidato_edad'] . ' años'; ?></li>
              <li class="one-line"><?php echo $direccion; ?></li>
              <li class="one-line">Sueldo: <?php echo $ce['explab_sueldod']; ?></li>
            </ul>
            <p>
              <?php
                echo $this->Html->link(__('Ver más detalles'), array(
                  'controller' => 'candidatos',
                  'action' => 'perfil',
                  'id' => $ce['candidato_cve'],
                  'slug' => Inflector::slug($ce['candidato_perfil'], '-')
                ), array(
                  'data' => array(
                    'component' => 'ajaxlink',
                    'magicload-target' => '#main-content'
                  )
                ));
              ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>