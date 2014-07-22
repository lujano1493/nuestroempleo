<div class="row servicios">
  <div class="col-xs-12 text-center">
    <ul class="list-unstyled list-inline" id="servicios-slides-btns">
      <li>
        <?php
          echo $this->Html->link('', '#', array(
            'class' => 'serv publicar btn btn-sm',
            'icon' => 'edit icon-2x block',
            'tags' => array(
              'span', __('Publicación de vacantes'), 'block'
            )
          ));
        ?>
      </li>
      <li>
        <?php
          echo $this->Html->link('', '#', array(
            'class' => 'serv cvs btn btn-sm',
            'icon' => 'search icon-2x block',
            'tags' => array(
              'span', __('Búsqueda y liberación de CVs'), 'block'
            )
          ));
        ?>
      </li>
      <li>
        <?php
          echo $this->Html->link('', '#', array(
            'class' => 'serv silver btn btn-sm',
            'icon' => 'certificate icon-2x block',
            'tags' => array(
              'span', __('Membresía Silver'), 'block'
            )
          ));
        ?>
      </li>
      <li>
        <?php
          echo $this->Html->link('', '#', array(
            'class' => 'serv golden btn btn-sm',
            'icon' => 'magic icon-2x block',
            'tags' => array(
              'span', __('Membresía Golden'), 'block'
            )
          ));
        ?>
      </li>
      <li>
        <?php
          echo $this->Html->link('', '#', array(
            'class' => 'serv diamond btn btn-sm',
            'icon' => 'trophy icon-2x block',
            'tags' => array(
              'span', __('Membresía Diamond'), 'block'
            )
          ));
        ?>
      </li>
      <li>
        <?php
          echo $this->Html->link('', '#', array(
            'class' => 'serv anuncios btn btn-sm',
            'icon' => 'star icon-2x block',
            'tags' => array(
              'span', __('Publicidad'), 'block'
            )
          ));
        ?>
      </li>
    </ul>
  </div>
</div>