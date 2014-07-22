<?php
  echo $this->element('empresas/title', array(
    'busqueda' => false
  ));

  $c = $candidato['CandidatoEmpresa'];
  $id = (int)$c['candidato_cve'];
  $isAcquired = (int)$candidato['Empresa']['adquirido'] === 1;
?>

<div id="profile">
  <?
    echo $this->Session->flash();
  ?>
  <div class="">
    <div class="btn-actions" data-item-id="<?php echo $id; ?>">
      <?php
        echo $this->Html->link(__('Guardar en cartera'), '#', array(
          'data-source' => '/carpetas/candidatos.json',
          'data-id' => $id,
          'data-controller' => 'mis_candidatos',
          'class' => 'btn btn-sm btn-blue',
          'data-component' => 'folderito',
          'icon' => 'folder-open'
        ));

        if ($isAcquired) {
          echo $this->Html->link(__('Asignar Evaluación'), array(
              'controller' => 'mis_evaluaciones',
              'action' => 'asignar',
              Inflector::slug($c['candidato_perfil'] . '-' . $id, '-')
            ), array(
            'class' => 'btn btn-sm btn-orange',
            'icon' => 'pencil',
          ));
          echo $this->Html->link(__('Enviar Mensaje'), array(
              'controller' => 'mis_mensajes',
              'action' => 'nuevo',
              '?' => array(
                'to' => $candidato['Cuenta']['cc_email'],
                'id' => $id
              )
            ), array(
            'class' => 'btn btn-sm btn-green',
            'icon' => 'folder-open',
            'data' => array(
              'component' => 'ajaxlink',
              'magicload-target' => '#main-content'
            )
          ));
          // echo $this->Html->link('Descargar CV', array(
          //   'controller' => 'mis_candidatos',
          //   'action' => 'curriculum',
          //   'id' => $id,
          //   'ext' => 'pdf'
          // ), array(
          //   'class' => 'btn btn-sm btn-orange',
          //   'icon' => 'download-alt',
          //   'target' => '_blank'
          // ));
        }
        $timestamp = time();
        if(!$denuncia_previa){

            echo $this->Html->link(__('Reportar CV'), '#denuncia-cv-' . $timestamp, array(
                'data-toggle' => 'modal',
                'class' => 'btn btn-sm btn-danger ',
                'icon' => 'warning-sign',
              ));

        }
      
        echo $this->Html->back();
      ?>
    </div>
    <div class="row">
      <div class="col-xs-9 searchable">
        <?php
          echo $this->element('common/candidato_perfil', array(
            'candidato' => $candidato
          ));
        ?>
      </div>
      <div class="col-xs-3">
        <?php
          if ($isAcquired) {
            $userFullname = $candidato['Empresa']['Contacto']['con_nombre'] . ' ' . $candidato['Empresa']['Contacto']['con_paterno'];
            $acquiredDate = $this->Time->dt($candidato['Empresa']['fecha_adquirido']);

            echo $this->element('common/alert', array(
              'class' => 'alert-success',
              'message' => __('Currículo adquirido por %s el %s.', $userFullname, $acquiredDate)
            ));
            echo $this->element('empresas/candidatos/notas', array(
              'id' => $id
            ));
          } else {
            echo $this->element('common/alert', array(
              'class' => 'alert-warning',
              'message' => __('Este CV no contiene toda la información del candidato, si deseas ver más detalles contrata aquí.')
            ));
          }
        ?>
        <?php if(!empty($candidato['Carpetas'])) { ?>
          <div class="folders" data-item-id="<?php echo $id; ?>">
            <?php
              $count = count($candidato['Carpetas']);
              foreach ($candidato['Carpetas'] as $key => $v) {
                echo $this->Html->link($v['carpeta_nombre'], array(
                  'controller' => 'mis_candidatos',
                  'action' => 'carpeta',
                  'id' => $v['carpeta_cve'],
                  'slug' => Inflector::slug($v['carpeta_nombre'], '-')
                ), array(
                  'data-folderito-id' => $v['carpeta_cve']
                )) . ($key < $count - 2 ? ', ' : ($key === $count - 2 ? ' y ' : ''));
              }
            ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php
  echo $this->element('empresas/candidatos/denuncia_cv', array(
    'id' => $id,
    'timestamp' => $timestamp
  ));

  echo $this->Template->insert(array(
    'notas'
  ));
?>