<?php

App::uses('FormHelper', 'View/Helper');

/**
  * Helper personalizado para los inputs de nuestro empleo.
  */
final class FormitoHelper extends FormHelper {
  public $helpers = array('Html');

  public $validation = array('required');

  public function input($fieldName, $options = array()) {
    if (!isset($options['div'])) {
      $options['div'] = '';
    }

    if (array_key_exists('icon', $options)) {
      $iconClass = 'icon';
      $label = array_key_exists('label', $options) ? $options['label'] : null;
      $icon = $options['icon'];
      $options['label'] = "<i class='icon-${icon}' ></i>";
      if ($label) {
        $options['label'] .= $label;
      }
      $options['div'] .= ' icon';
      unset($options['icon']);
    }

    if (array_key_exists('pass', $options) && $options['pass']) {
      $options['before'] = isset($options['before']) ? $options['before'] : '';
      //$pass = $options['pass'];
      $options['before'] .= parent::input('passFields.', array(
        'class' => 'pass-input',
        'div' => array('class' => 'pass-checkbox'),
        'label' => array(
          'data-component' => 'tooltip',
          'title' => 'Marque este campo como importante.',
          'text' => ''
        ),
        'hiddenField' => false,
        'type' => 'checkbox',
        'value' => $fieldName,
        'id' => 'pass-field-' . str_replace('.', '',$fieldName),
      ));
      $options['div'] .= ' pass';
      unset($options['pass']);
    }

    $name_model = $this->model();
    $fields =  explode(".",$fieldName);
    $count = count($fields);
    $field = ($count > 1) ? $fields[$count-1] : $fields[0];
    $name_model = ($count > 1) ? (is_numeric($fields[$count - 2]) ? $fields[$count - 3] : $fields[$count - 2]) : $name_model;
    $object = $this->_getModel($name_model);

    if ($object) {
      if (!empty($object->validate[$field])) {
        $validates=$object->validate[$field];
        foreach ($validates as $key => $value) {
          if($key == 'unique') {
            continue;
          }
          if (!empty($value['arguments'])) {
            $options['data-rule-' . $key] = json_encode($value['arguments']);
          }
          if ('equalto' === $key){
            $options['data-rule-' . $key] = "." . $value['rule'][1];
          }
          if('maxlength' === $key || 'minlength' === $key) {
            $options['data-rule-'.$key]=$value['rule'][1];
          }

          $options['data-rule-' . $key] = empty($options['data-rule-' . $key]) ? 'true' : $options['data-rule-' . $key];
          $options['data-msg-' . $key] = empty($value['message']) ? '' : $value['message'] ;
         }
      }
    }
    // $options['required']=false;
    return parent::input($fieldName, $options);
  }

  /**
    *
    */
  protected function _divOptions($options) {
    if ($options['type'] === 'hidden') {
      return array();
    }
    $div = $this->_extractOption('div', $options, true);
    if (!is_string($div) && !$div) {
      return array();
    }

    $divOptions = array('class' => 'input');
    $divOptions = $this->addClass($divOptions, $options['type']);
    if (is_string($div)) {
      //$divOptions['class'] .= ' ' . $div;
      $divOptions = $this->addClass($divOptions, $div);
    } elseif (is_array($div)) {
      $divOptions = array_merge($divOptions, $div);
    }

    if ($this->_introspectModel($this->model(), 'validates', $this->field())) {
      $divOptions = $this->addClass($divOptions, 'required');
    }
    if (!isset($divOptions['tag'])) {
      $divOptions['tag'] = 'div';
    }
    return $divOptions;
  }

  public function button($title, $options = array()) {
    if (isset($options['type']) && $options['type'] === 'caret') {
      $title = '<span class="caret"></span>';
      $options['type'] = 'button';
      $options['escape'] = false;
    }

    return parent::button($title, $options);
  }

  public function _maxLength($options) {
    $fieldDef = $this->_introspectModel($this->model(), 'fields', $this->field());
    $autoLength = (
      !array_key_exists('maxlength', $options) &&
      isset($fieldDef['length']) &&
      is_scalar($fieldDef['length']) &&
      $options['type'] !== 'select'
    );
    if ($autoLength &&
      in_array($options['type'], array('text','textarea' ,'email', 'tel', 'url', 'search'))
    ) {
      $options['maxlength'] = $fieldDef['length'];

    }
    return $options;
  }

  public function url($url = null, $full = false) {
    if (isset($this->params['compania']) && is_array($url)) {
      $url['compania'] = $this->params['compania']['name'];
    }
    return parent::url($url, $full);
  }

  public function radios($name, $radioOptions, $options = array()) {
    $out = array();
    foreach ($radioOptions as $key => $value) {
      $slug = is_numeric($key) ? Inflector::slug($value) : $key;

      $out[] = $this->input($name, array(
        'id' => $name . '_' . $slug,
        'hiddenField' => false,
        'options' => array(
          strtolower($slug) => $value,
        ),
        'type' => 'radio'
      ) + $options);
    }

    return implode('', $out);
  }

}
