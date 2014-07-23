<?php
/**
  *
  */
App::uses('AppHelper', 'View/Helper');

/**
 *
 */
class MenuHelper extends AppHelper {

  public $helpers = array('Html', 'Session');

  protected $recursiveOptions = array(
    'path' => 'name',
    'children' => 'children'
  );

  public function recursive($data, $options = array()) {
    $items = array();

    foreach ($data as $item) {
      $items[] = '<li>' . Hash::get($item, $options['path']) . $this->recursive($item['children'], $options) . '</li>';
    }

    if (count($items)) {
      return '<ul>' . implode('', $items) .'</ul>';
    } else {
      return '';
    }
  }

  /**
   * Crea un menu.
   * @param  [type] $items   [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function make($items, $options = array()) {
    $mainMenu = '<ul class="'. $options['ul'] . '">';
    foreach ($items as $title => $item) {
      $mainMenu .= $this->li($item, $title);
    }
    $mainMenu .= '</ul>';

    return $mainMenu;
  }

  public function li($item, $title = null) {
    if (!isset($item['title']) && is_string($title)) {
      $item['title'] = $title;
    }

    $li = '<li class="' . $this->_isActive($item) . '">' . $this->_link($item)
      . (isset($item['element']) ? $this->element($item['element']) : '')
      . '</li>';

    return $li;
  }

  public function link($title, $url = null, $options = array(), $confirmMessage = false) {
    $controller = $this->request->params['controller'];
    $action = $this->request->params['action'];

    if (($url['controller'] === $controller
      || strpos($controller, $url['controller'])
      || strpos($url['controller'], $controller)) && ($url['action'] === $action)) {

      // Si 'class' no existe, entonces la establece a una cadena vacía.
      !isset($options['class']) && $options['class'] = '';

      $options['class'] .= 'active';
    }

    return $this->Html->link($title, $url, $options, $confirmMessage);
  }

  private function _isActive($item) {
    $controller = $this->request->params['controller'];
    $url = $item['url'];

    $isActive = $url['controller'] === $controller
      || strpos($controller, $url['controller'])
      || strpos($url['controller'], $controller)
      || (!empty($item['active_with']) && $item['active_with'] === $controller);

    if ($isActive) {
      return 'active open';
    }
    return '';
  }

  private function _link($item) {
    return $this->Html->spanLink($item['title'], $item['url'], array(
      'icon' => $item['icon'],
      'after' => true
    ));
  }

  private function element($element, $options = array()) {
    $ouput = '';
    if ($element) {
      $ouput = $this->arrow() . $this->_View->element($element, $options);
    }

    return $ouput;
  }

  private function arrow($url = '#') {
    return $this->Html->link(null, $url, array(
      'class' => 'arrow',
      'icon' => 'angle-down'
    ));
  }
}
