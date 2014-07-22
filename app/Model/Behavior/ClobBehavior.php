<?php
/**
 * CakePHP Clob Behaviour
 * Preparing and inserting the clob values in the database
 *
 * Authors: Bobby Borisov and Nedko Penev
 */

App::uses('ModelBehavior', 'Model');

class ClobBehavior extends ModelBehavior {
  public $model;

  public $time_end;

  public $time_start;

  public $saved = array(); // array to store clob values

  /**
   * Método de inicialización.
   * @param  Model  $Model    [description]
   * @param  array  $settings [description]
   * @return [type]           [description]
   */
  public function setup(Model $Model, $config = array()) {
    $this->model = $Model;
    $this->settings = $config;
  }

  /**
   * Establece los campos text a NULL antes de guardarlos.
   * @param  Model  $Model   [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function beforeSave(Model $Model, $options = array()) {
    $this->model->cachedData = $this->saved = $this->model->data[$this->model->alias];

    foreach ($this->model->schema() as $key => $value) {
      // Para CakePHP text = CLOB
      if ($value['type'] === 'text' && isset($this->model->data[$this->model->alias][$key])) {
        $this->model->data[$this->model->alias][$key] = NULL;
      }
    }

    return true;
  }

  /**
   * Actualiza el registro con los datos CLOB.
   * @param  Model  $Model   [description]
   * @param  [type] $created [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function afterSave(Model $Model, $created, $options = array()) {
    // Obtiene la conexión a la BD.
    $db = ConnectionManager::getDataSource($this->model->useDbConfig);

    // Obtiene el ID del modelo.
    $id = (!$this->model->id) ? $this->model->getLastInsertId() : $this->model->id;
    $fields   = array(); // Arreglo con los campos a actualizar.

    foreach ($this->model->schema() as $key => $value) {
      /**
       * Verifica que el campo sea CLOB y que exista en los campos guardados
       * ó esté en lo campos que se van a generar.
       */
      if ($value['type'] === 'text' && (
        isset($this->saved[$key]) || $this->canGenerateField($key)
      )) {
        $fields = am($key, $fields); // array_merge
      }
    }

    if (!empty($fields)) {
      $set = array();   // clausula SET en el sql.
      $into = array();  // clausula INTO en el sql.

      $this->model->begin(); // transacción.
      foreach ($fields as $key => $value) {
        $set = am($value . ' = EMPTY_CLOB()' , $set);
        $into = am(":muclob" . $key, $into);
      }

      $set_stmt  = implode(', ', $set);     // array a string para el SET en el sql.
      $returning = implode(', ', $fields);  // array a string para el RETURNING en el sql.
      $into_stmt = implode(', ', $into);    // array a string para el INTO en el sql.

      // Generamos el SQL.
      $sql = 'UPDATE ' . $this->model->table . ' SET ' . $set_stmt .
        ' WHERE ' . $this->model->primaryKey . ' = ' . $id .
        ' RETURNING ' . $returning .
        ' INTO ' . $into_stmt;

      $stmt = oci_parse($db->connection, $sql);
      $cnt = 0;

      // just see http://www.oracle.com/technology/pub/articles/oracle_php_cookbook/fuecks_lobs.html
      foreach ($into as $key => $value) {
        // descriptores
        $mylob[$cnt] = oci_new_descriptor($db->connection, OCI_DTYPE_LOB);
        oci_bind_by_name($stmt,$value,$mylob[$cnt++], -1, OCI_B_CLOB);
      }

      oci_execute($stmt, OCI_NO_AUTO_COMMIT); //or die ("No se puede ejecutar la sentencia.");
      $cnt = 0;
      foreach ($fields as $key => $value) {
        // Obtiene el campo
        $clobText = $this->getField($value);

        // Guarda el objeto CLOB.
        if (!$mylob[$cnt++]->save($clobText)) {
          // En caso de no guardar algún campo, hará un rollback.
          $this->model->rollback(); // die("No se pudo actualizar campo CLOB.");
        }
      }

      $this->model->commit();
      oci_free_statement($stmt); // Libera los recursos de la sentencia.
    }
  }

  /**
   * Verifica si se puede generar el campo en base a los campos guardados.
   * @param  [type] $field [description]
   * @return [type]        [description]
   */
  public function canGenerateField($field) {
    $canGenerateField = false;

    // $field existe en generateFields.
    if (!empty($this->settings['generateFields']) && in_array($field, array_keys($this->settings['generateFields']))) {
      $fieldOptions = $this->settings['generateFields'][$field];

      // Cuando al generar un campo se pasan parámetros busca si se pasaron al guardar.
      foreach ($fieldOptions as $key => $value) {
        if (is_string($key) && !empty($key) && !empty($value) && !empty($this->saved[$value])) {
          $canGenerateField = true;
          break;
        }
      }
    }


    return $canGenerateField;
  }

  public function getField($field) {
    $generatedValue = '';

    /**
     * Si existe la llave 'generateFields', los generará en base a una función del modelo.
     */
    if (!empty($this->settings['generateFields']) && !empty($this->settings['generateFields'][$field])) {
      $fieldOptions = $this->settings['generateFields'][$field];

      foreach ($fieldOptions as $key => $value) {
        $fn = is_string($key) && !empty($key) ? $key : $value;

        // Llama la función del modelo.
        $generatedValue = call_user_func_array(array($this->model, $fn), array(
          $fn === $value ? $this->saved : $this->saved[$value]
        ));
      }
    } else {
      $generatedValue = isset($this->saved[$field]) ? $this->saved[$field] : '';
    }

    return $generatedValue;
  }
}