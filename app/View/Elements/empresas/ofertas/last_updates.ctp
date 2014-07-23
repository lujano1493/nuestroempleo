<div class="last-updates">
  <h5 class="subtitle">
    <i class="icon-file-text"></i><?php echo __('Últimas Ofertas Creadas'); ?>
  </h5>
  <div class="row">
    <?php
      foreach ($ofertas_recientes as $k => $v) {
        $ofer = $v['Oferta'];
        $cat = $v['Catalogo'];
        $dir = $v['Direccion'];
        ?>
        <div class="col-xs-3">
          <div class="card <?php echo $k & 1 ? 'even' : 'odd'; ?>">
            <?php
              echo $this->Html->image($this->Session->read('Auth.User.Empresa.logo'), array(
                'alt' => __('Logotipo de la empresa'),
                'style' =>'width:150px;height:100px;margin:auto',
                'class' => 'img-responsive',
              ));
            ?>
            <h6 class="one-line">
              <?php echo $ofer['puesto_nom']; ?>
              <small class="one-line"><?php echo $dir['ciudad'] . ', ' . $dir['estado']; ?></small>
            </h6>
            <strong><?php echo __('Requisitos'); ?></strong>
            <ul class="list-unstyled text-left">
              <li><?php echo $cat['experiencia']; ?></li>
              <li class="one-line"><?php echo $cat['escolaridad']; ?></li>
              <li><?php echo $cat['genero']; ?></li>
              <li><?php echo $cat['edocivil']; ?></li>
              <li><?php echo __('Edad de %s a %s años', $ofer['oferta_edadmin'], $ofer['oferta_edadmax']); ?></li>
              <li><?php echo $cat['disponibilidad']; ?></li>
            </ul>
            <?php
              echo $this->Html->link(__('Ver más'), array(
                'controller' => 'mis_ofertas',
                'id' => $ofer['oferta_cve'],
                'slug' => Inflector::slug($ofer['puesto_nom'], '-'),
                'action' => 'editar'
              ));
            ?>
          </div>
        </div>
        <?php
      }
    ?>
  </div>
</div>