<?php
  $cart = $this->Session->read('Auth.Cart');
  if (!empty($cart)) {
?>
  <ul class="nav navbar-nav" id="carrito-list" data-ajaxlink-view="carrito-menu">
    <li class="dropdown">
      <?php
        echo $this->Html->link('Carrito', '#', array(
          'class' => 'link-icon',
          'icon' => 'shopping-cart',
          'data-toggle' => 'dropdown',
          'tags' => array(
            'span', $cart['count'], 'label'
          )
        ));
      ?>
      <div class="dropdown-menu pull-right" style="padding:5px 10px;">
        <div style="min-width:510px;">
          <?php
            echo $this->Html->image('assets/carrito.png', array(
              'style' => 'display:inline-block;vertical-align: initial;',
              'width' => 100
            ));
          ?>
          <ul class="list-unstyled well well-sm" style="width:400px;display:inline-block;">
            <li>
              <div class="row">
                <div class="col-xs-6 text-center">
                  <?php echo __('Descripción'); ?>
                </div>
                <div class="col-xs-3 text-center">
                  <?php echo __('Costo'); ?>
                </div>
                <div class="col-xs-3 text-center">
                  <?php echo __('Total'); ?>
                </div>
              </div>
            </li>
            <?php foreach ($cart['items'] as $key => $value): ?>
              <li>
                <div class="">
                  <?php
                    $tags = $this->Html->tags(array(
                        array('span', __('<strong>%s</strong>', $key), 'col-xs-5 text-center'),
                        array('small',
                          __('%s x %s', $value['cant'], $this->Number->currency($value['desc']['costo'])),
                          'col-xs-4 text-right'
                        ),
                        array('span',
                          __('<strong>%s</strong>', $this->Number->currency($value['desc']['costo'] * $value['cant'])),
                          'col-xs-3 text-right'
                        )
                    ));
                    echo $this->Html->link('', array(
                      'controller' => 'mis_productos',
                      'action' => 'carrito'
                    ), array(
                      'class' => 'block',
                      'tags' => array(
                        array(
                          'div', $tags, 'row'
                        )
                      )
                    ));
                  ?>
                </div>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
        <span class="block text-right">
          <?php echo __('Subtotal: <strong>%s</strong>', $this->Number->currency($cart['total'])); ?>
        </span>
        <div class="btn-actions text-right">
          <?php
            echo $this->Html->link('Comprar', array(
              'controller' => 'mis_productos',
              'action' => 'carrito'
            ), array(
              'icon' => 'shopping-cart',
              'class' => 'btn btn-primary',
            ));
          ?>
        </div>
      </div>
    </li>
  </ul>
<?php
  }
?>