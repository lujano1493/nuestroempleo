<?php if (!empty($children)): ?>
  <ul class="submenu">
    <?php
    /*
    if (!empty($prepend)) {
      foreach ($prepend as $k => $v) { ?>
        <li>
          <?php
            echo $this->Html->spanLink($k, $v['url'], $v['options']);
          ?>
        </li>
      <?php }
    }
    /**/
    ?>
    <?php foreach ($children as $folder): ?>
      <li>
        <?php
          $slug = Inflector::slug($folder['Carpeta']['carpeta_nombre'], '-');
          $isActive = /*strpos($this->here, $slug)
            &&*/ $this->params['controller'] === $controller
            && (int)$this->params['id'] === (int)$folder['Carpeta']['carpeta_cve'];

          $tags = array(
            array('span', $folder['Carpeta']['carpeta_nombre'], array(
              'class' => 'block one-line',
              'title' => $folder['Carpeta']['carpeta_nombre']
            ))
          );

          if (isset($folder['Carpeta']['total'])) {
            $tags[] = array('span', $folder['Carpeta']['total'], 'total-items');
          }

          echo $this->Html->link('', array(
            'controller' => $controller,
            'action' => 'carpeta',
            'slug' => Inflector::slug($folder['Carpeta']['carpeta_nombre'], '-'),
            'id' => $folder['Carpeta']['carpeta_cve']
          ), array(
            'class' => $isActive ? 'folder active' : false,
            //'icon' => $isActive ? 'folder-open-alt' : 'folder-close-alt',
            'tags' => $tags,
          ));

          if (!empty($folder['children'])):
            echo $this->element('common/folder', array(
              'controller' => $controller,
              'children' => $folder['children']
            ));
          endif
        ?>
      </li>
    <?php endforeach ?>
  </ul>
<?php endif ?>