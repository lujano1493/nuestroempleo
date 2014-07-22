<div class="to-expire">
  <h5 class="subtitle">
    <i class="icon-time"></i>Ofertas Pr&oacute;ximas a Vencerse
  </h5>
  <p>Revise periódicamente la vigencia de sus ofertas, ya que una vez vencida, pasarán automáticamente a la sección de eliminadas.</p>
  <?php
    if (!empty($ofertas_a_vencer)) {
      $chunks = array_chunk($ofertas_a_vencer, 4);
      foreach ($chunks as $key => $value) {
      ?>
        <div class="row">
          <?php
            foreach ($value as $k => $v) {
              $ofer = $v['Oferta'];
              $dir = $v['Direccion'];
              ?>
              <div class="col-xs-3">
                <?php
                  echo $this->Html->link('', array(
                    'controller' => 'mis_ofertas',
                    'action' => 'index'
                  ), array(
                    'class' => 'expire',
                    'icon' => 'warning-sign icon-2x',
                    'tags' => array(
                      array('span', $ofer['puesto_nom'], array(
                        'class' => 'one-line'
                      )),
                      array('span', $dir['ciudad'] . ', ' . $dir['estado'], array(
                        'class' => 'dir one-line'
                      )),
                      array('em', $ofer['vigencia'], array(
                        'class' => 'days label label-danger'
                      ))
                    )
                  ));
                ?>
              </div>
              <?php
            }
          ?>
        </div>
      <?php
      }
    } else {
  ?>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->element('common/alert', array(
            'class' => 'alert-info',
            'message' => 'Aquí aparecerán las ofertas próximas a vencer.'
          ));
        ?>
      </div>
    </div>
  <?php
    }
  ?>
</div>