<?php
  echo $this->element('empresas/title', array(
    'busqueda' => false
  ));

  $c = $candidato['CandidatoEmpresa'];
  $id = (int)$c['candidato_cve'];
  $isAcquired = (int)$candidato['Empresa']['adquirido'] === 1;

  $nombre = $candidato['CandidatoEmpresa']['candidato_nom'] . ' '
    . $candidato['CandidatoEmpresa']['candidato_pat'] . ' '
    . $candidato['CandidatoEmpresa']['candidato_mat'];

  $direccion = implode(', ', array(
    //$value['Direccion']['colonia'],
    $c['ciudad_nom'],//$value['Direccion']['ciudad'],
    $c['est_nom'],//$value['Direccion']['estado'],
    $c['pais_nom'],//$value['Direccion']['pais'],
    $c['cp_cp'],//$value['Direccion']['cp']
  ));
?>

<div id="profile">
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

        $timestamp = time();
        echo $this->Html->link(__('Reportar CV'), '#denuncia-cv-' . $timestamp, array(
          'data-toggle' => 'modal',
          'class' => 'btn btn-sm btn-danger ',
          'icon' => 'warning-sign',
        ));
        echo $this->Html->back();
      ?>
    </div>
    <div class="row">
      <div class="col-xs-9">
        <div class="row">
          <div class="col-xs-8">
            <?php
              $foto = $c['foto_url'];
            ?>
            <img class="img-profile pull-left" src="<?php echo $foto; ?>" width="100" height="130">
            <h4 class="title-profile">
              <?php echo $c['candidato_perfil']; ?>
              <small><?php echo $direccion; ?></small>
            </h4>
          </div>
          <div class="col-xs-4">
            <div class="btn-actions">
              <?php
                echo $this->Html->link(__('Descargar CV'), array(
                  'controller' => 'mis_candidatos',
                  'action' => 'curriculum',
                  'id' => $id,
                  Inflector::slug($c['candidato_perfil'] . '-' . ucwords(strtolower($nombre)), '-'),
                  'ext' => 'pdf'
                ), array(
                  'class' => 'btn btn-lg btn-block btn-orange',
                  'icon' => 'download',
                  'target' => '_blank'
                ));
              ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Datos Personales'); ?></div>
              <div class="panel-body">
                <ul class="list-unstyled">
                  <li>
                    <small><?php echo __('Nombre'); ?></small>
                    <?php echo ucwords(strtolower($nombre)); ?>
                  </li>
                  <li>
                    <small><?php echo __('Dirección'); ?></small>
                    <?php echo $direccion; ?>
                  </li>
                  <li>
                    <small><?php echo __('Edad'); ?></small>
                    <?php echo $c['edad'] . ' años'; ?>
                  </li>
                  <li>
                    <small><?php echo __('Estado Civil'); ?></small>
                    <?php echo $c['edo_civil_nombre']; ?>
                  </li>
                  <li>
                    <small><?php echo __('Sueldo'); ?></small>
                    <?php echo $c['elsueldo_ini']; ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Datos de Contacto'); ?></div>
              <div class="panel-body">
                <ul class="list-unstyled">
                  <li>E-mail: <?php
                      echo $this->Html->link($candidato['Cuenta']['cc_email'], array(
                        'controller' => 'mis_mensajes',
                        'action' => 'nuevo',
                        '?' => array(
                          'to' => $candidato['Cuenta']['cc_email'],
                          'id' => $id
                        )
                      ), array(
                      ));
                    ?>
                  </li>
                  <li>Celular: <?php echo $c['candidato_movil']; ?></li>
                  <li>Teléfono:</li>
                  <!-- <li>
                    <?php
                      // echo $this->Html->link(__('Utiliza un crédito aquí'), array(
                      //   'controller' => 'mis_candidatos',
                      //   'action' => 'comprar',
                      //   'id' => $id
                      // ), array(
                      //   'class' => 'btn btn-default btn-sm btn-block',
                      //   'data' => array(
                      //     'after' => 'reloadContent',
                      //     'component' => 'ajaxlink',
                      //     //'action-role' => 'buy'
                      //     'ajaxlink-target' => 'credits-bar'
                      //   ),
                      // ));
                    ?>
                  </li> -->
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Experiencia Laboral'); ?></div>
              <div class="panel-body">
                <?php if (!empty($candidato['ExpeLaboral'])) { ?>
                  <?php foreach ($candidato['ExpeLaboral'] as $k => $v) { ?>
                    <div class="panel-item">
                      <h4>
                        <?php echo $v['puesto']; ?>
                        <small class="pull-right">
                          <?php
                            echo $this->Time->month($v['inicio']);
                          ?> – <?php
                            echo $v['actual'] === 'S' ? 'Actual' : $this->Time->month($v['fin']);
                          ?>
                        </small>
                      </h4>
                      <h5 class="text-center"><?php echo $v['empresa'] . ' - ' . $v['giro_nombre']; ?></h5>
                      <p>
                        <?php echo $v['funciones']; ?>
                      </p>
                    </div>
                  <? } ?>
                <?php
                  } else {
                    echo __('Información no capturada');
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Áreas de Experiencia'); ?></div>
              <div class="panel-body">
                <?php if (!empty($candidato['Experiencia'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Experiencia'] as $k => $v) { ?>
                      <li>
                        <?php echo $v['area']; ?>
                        <small><?php echo $v['tiempo']; ?></small>
                      </li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('Sin Experiencia');
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Áreas de interés'); ?></div>
              <div class="panel-body">
                <?php if (!empty($candidato['AreasInteres'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['AreasInteres'] as $k => $v) { ?>
                      <li><?php echo $v['area']; ?></li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('Sin datos');
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Habilidades'); ?></div>
              <div class="panel-body">
                <?php if (!empty($candidato['Habilidades'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Habilidades'] as $k => $v) { ?>
                      <li><?php echo $v['habilidad']; ?></li>
                    <? } ?>
                  </ul>
                <?php
                  } else {
                    echo __('Sin datos');
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Educación'); ?></div>
              <div class="panel-body">
                <?php if (!empty($candidato['Estudios'])) { ?>
                  <?php foreach ($candidato['Estudios'] as $k => $v) { ?>
                    <ul class="list-unstyled panel-item">
                      <li>
                        <?php echo $v['carrera']; ?>
                        <small>
                          <?php
                            echo $this->Time->month($v['inicio']);
                          ?> – <?php
                            echo $v['fin'] ? $this->Time->month($v['fin']) : '';
                          ?>
                        </small>
                      </li>
                      <li><strong><?php echo $v['instituto']; ?></strong></li>
                      <li><?php echo $v['nivel_escolar']; ?></li>
                    </ul>
                  <? } ?>
                <?php
                  } else {
                    echo __('Sin datos');
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo _('Cursos'); ?></div>
              <div class="panel-body">
                <?php if(!empty($candidato['Cursos'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Cursos'] as $k => $v) { ?>
                      <li>
                        <?php echo $v['nombre']; ?>
                        <small><?php echo $v['institucion']; ?></small>
                      </li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('Sin datos');
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Idiomas'); ?></div>
              <div class="panel-body">
                <?php if(!empty($candidato['Idiomas'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Idiomas'] as $k => $v) { ?>
                      <li>
                        <?php echo $v['idioma']; ?>
                        <small><?php echo $v['nivel']; ?></small>
                      </li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('Sin datos');
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Conocimientos Adicionales'); ?></div>
              <div class="panel-body">
                <?php if(!empty($candidato['Conocimientos'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Conocimientos'] as $k => $v) { ?>
                      <li><?php echo $v['conoc_descrip']; ?></li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('Sin datos');
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Información Adicional') ?></div>
              <div class="panel-body">
                <ul class="list-unstyled">
                  <li>
                    <small><?php echo __('Disponibilidad para viajar'); ?></small>
                    <?php echo $c['viajar']; ?>
                  </li>
                  <li>
                    <small><?php echo __('Disponibilidad para reubicarse'); ?></small>
                    <?php echo $c['reubicacion']; ?>
                  </li>
                  <li>
                    <small><?php echo __('Tipo de Empleo'); ?></small>
                    <?php echo $c['expeco_tipoe']; ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Evaluaciones'); ?></div>
              <div class="panel-body">
                <?php if(!empty($candidato['Evaluaciones'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Evaluaciones'] as $k => $v) { ?>
                      <li>
                        <?php
                          if ((int)$v['tipo'] === 3) {
                            echo $this->Html->link($v['tipo_texto'] . ' ' . $v['nombre'], array(
                              'controller' => 'mis_candidatos',
                              'action' => 'evaluacion',
                              'id' => $id,
                              'slug' => Inflector::slug($c['candidato_nomcom'], '-'),
                              'itemId' => $v['id'],
                              'itemSlug' => Inflector::slug($c['candidato_nomcom'] . '-' . $v['nombre'], '-'),
                              'ext' => 'pdf'
                            ), array(
                              'target' => '_blank'
                            ));
                          } else {
                            echo $this->Html->link($v['tipo_texto'], array(
                              'controller' => 'mis_candidatos',
                              'action' => 'evaluacion',
                              'id' => $id,
                              'slug' => Inflector::slug($c['candidato_nomcom'], '-'),
                              'itemId' => $v['id'],
                              'itemSlug' => Inflector::slug($c['candidato_nomcom'] . '-' . $v['tipo_texto'], '-')
                            ), array(
                              'target' => '_blank'
                            ));
                          }
                        ?>
                      </li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('No se han aplicado evaluaciones al candidato');
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Documentos'); ?></div>
              <div class="panel-body">
                <?php if(!empty($candidato['Documentos'])) {
                  $icons = array(1 => 'picture', 2 => 'book', 3 => 'book', 10 => 'globe');
                ?>
                <ul class="list-unstyled">
                  <?php foreach ($candidato['Documentos'] as $k => $v) { ?>
                    <li>
                      <?php
                        $link = (int)$v['tipodoc_cve'] === 10 ? $v['docscan_nom'] : array(
                          'controller' => 'mis_candidatos',
                          'action' => 'documento',
                          'id' => $id,
                          'slug' => Inflector::slug($c['candidato_nomcom'], '-'),
                          'itemId' => $v['docscan_cve'],
                          'itemSlug' => Inflector::slug($v['docscan_descrip'], '-')
                        );

                        echo $this->Html->link($v['docscan_descrip'], $link, array(
                          'icon' => $icons[(int)$v['tipodoc_cve']],
                          'after' => true,
                          'target' => '_blank'
                        ));
                      ?>
                    </li>
                  <?php } ?>
                </ul>
              <?php
                } else {
                  echo __('No hay archivos del candidato.');
                }
              ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Referencias'); ?></div>
              <div class="panel-body">
                <?php if (!empty($candidato['Referencias'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Referencias'] as $k => $v) { ?>
                      <li>
                        <strong><?php echo $v['nombre']; ?></strong>
                        <small><?php echo $v['relacion']; ?></small>
                        <?php
                          // if ($isAcquired) {
                            echo $this->Html->link($v['email'], 'mailto:' . $v['email'], array(
                              'class' => 'block',
                              'target' => '_blank'
                            ));
                            if ($v['status'] === 'S') {
                              echo $this->Html->link(__('Resultados Encuesta de Referencia'), array(
                                'controller' => 'candidatos',
                                'action' => 'referencias',
                                'id' => $v['candidato_cve'],
                                'slug' => Inflector::slug($c['candidato_nomcom'], '-'),
                                'itemId' => $v['id'],
                                'itemSlug' => Inflector::slug($c['candidato_nomcom'] . '-' . $v['relacion'] . '-' . ($k + 1), '-'),
                                'ext' => 'pdf'
                              ), array(
                                'class' => 'block',
                                'icon' => 'ok',
                                'target' => '_blank'
                              ));
                            }
                          // }
                        ?>
                      </li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('No existen referencias del candidato');
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo __('Capacidades Diferentes'); ?></div>
              <div class="panel-body">
                <?php if(!empty($candidato['Incapacidades'])) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($candidato['Incapacidades'] as $k => $v) { ?>
                      <li><?php echo $v['nombre']; ?></li>
                    <?php } ?>
                  </ul>
                <?php
                  } else {
                    echo __('No');
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
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
            ?>
              <div class="alert alert-info">
                <p>
                  <?php echo __('Estás viendo la información completa de este candidato debido a que él se postuló a esta oferta'); ?>
                </p>
                <div class="btn-actions">
                  <?php
                  echo $this->Html->link(__('Adquirir CV'), array(
                    'controller' => 'mis_candidatos',
                    'action' => 'comprar',
                    'id' => $id
                  ), array(
                    'class' => 'btn btn-lg btn-primary',
                    'data' => array(
                      'after' => 'reloadContent',
                      'component' => 'ajaxlink',
                      //'action-role' => 'buy'
                      'ajaxlink-target' => 'credits-bar'
                    ),
                    'icon' => 'group'
                  ));
                ?>
                </div>
              </div>
            <?php
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

  // echo $this->Template->insert(array(
  //   'notas'
  // ));
?>