<?php

App::uses('Model', 'Model');

class AppModel extends Model {

  private $dataSource = null;

  public $msg_succes = "modelo";

  public $jsonFields = array();

  public $foreignKey= null;

  /**
   * Guardará los mensajes de error.
   * @var [type]
   */
  private $message = null;

  /**
   * Guardará el código de error.
   * @var [type]
   */
  private $_code = null;

  /**
   * Códigos de error.
   * @var array
   */
  private $statusCodes = array(
    'success' => 200,
    'error' => 400
  );

  /**
   * Para cargar modelos que se deben conocer pero no están relacionados.
   * @var array
   */
  public $knows = array();

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    if (!empty($this->knows)) {
      foreach ($this->knows as $alias => $modelName) {

        $alias = is_numeric($alias) ? $modelName : $alias;
        $model = array('class' => $modelName, 'alias' => $alias);

        $this->{$alias} = ClassRegistry::init($model);
      }
    }
  }

  /**
   * Obtiene el siguiente Id del modelo.
   * @return [type] [description]
   */
  protected function getNextId() {
    $results = $this->find('first', array(
      'fields'=> 'nvl(max(' . $this->alias . '.' . $this->primaryKey . '),0) + 1 as clave',
      'recursive' => -1,
      'nextId' => true
    ));
    return $results[0]['clave'];
  }

  /**
    * Funciones para las transacciones.
    */
  public function begin() {
    if ($this->dataSource === null) {
      $this->dataSource = $this->getDataSource();
    }
    $this->dataSource->begin();
  }

  public function commit() {
    $this->dataSource->commit();
  }

  public function rollback() {
    $this->dataSource->rollback();
  }

  /**
   * Convierte a formato JSON los campos especificados en $jsonFields.
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function encodeToJson($options = array()) {
    foreach ($this->jsonFields as $key => $value) {
      $key = is_integer($key) ? $value : $key;
      if (isset($this->data[$this->alias][$key])) {
        $this->data[$this->alias][$value] = json_encode($this->data[$this->alias][$key]);
        if ($key != $value) unset($this->data[$this->alias][$key]);
      }
    }
  }

  /**
    * Función de ayuda para saber si exite el id del modelo.
    * Si no existe, significa que se va a crear un nuevo registro en la tabla,
    * en caso contrario, se va a editar un registro en la tabla.
    * @return boolean
    */
  public function issetId() {
    return !empty($this->data[$this->alias][$this->primaryKey]) || $this->getID();
  }

  /**
   * Función resumen de búsqueda por id del modelo y el tipo de búsqueda.
   * @param  int    $modelId  Id del modelo.
   * @param  string $findType Tipo de búsqueda.
   * @param  array  $options  Opciones que se pasarán a la búsqueda.
   * @return mixed            Resultados.
   */
  public function get() {
    $returnData = array();

    /**
     * Obtiene los argumentos y dependiendo del tipo, los asigna.
     * @var [type]
     */
    $arguments = func_get_args();
    $modelId = null; $findType = 'all'; $options = array();

    foreach ($arguments as $arg) {
      if (is_numeric($arg) /*|| (isset($arg[0]) && is_int($arg[0]))*/) $modelId = $arg; // La segunda condición verifica arrays númericos
      elseif (is_array($arg)) $options = $arg;
      elseif (is_string($arg)) $findType = $arg;
    }

    $options['conditions'] = isset($options['conditions']) ? $options['conditions'] : array();
    $options['limit'] = isset($options['limit']) ? $options['limit'] : 1000;
    $options['recursive'] = isset($options['recursive']) ? $options['recursive'] : -1;

    $getFirst = isset($options['first']);

    /**
     * Si se especifica un modelo, lo agrega a la condición, y establece el tipo de búsqueda
     * como 'first'.
     */
    if ($modelId) {
      $options['conditions'][$this->alias . '.' . $this->primaryKey] = $modelId;
      $findType = $findType === 'all' ? 'first' : $findType;
    }

    /**
     * Realiza la búsqueda.
     * @var [type]
     */
    $results = $this->find($findType, $options);

    // Si se utiliza la opcion 'contain' o si es recursivo
    // devuelve todos los resultados.
    if (!empty($options['contain']) || $options['recursive'] >= 0) {
      $returnData = $results;
    } elseif (isset($results[$this->alias]) && $findType === 'first' && $options['recursive'] == -1) {
      $returnData = $results[$this->alias];
    } elseif (count($results) == 1 && !empty($results[0]) && is_numeric($modelId)) {
      $returnData = $results[0];
    } else {
      $returnData = $getFirst && !empty($results[0]) ? $results[0] : $results;
    }

    /**
     *
     */
    if (!empty($options['afterFind'])) {
      $afterFind = is_string($options['afterFind']) ? (array)$options['afterFind'] : $options['afterFind'];

      foreach ($afterFind as $key => $value) {
        $functionName = is_numeric($key) ? $value : $key;
        $functionOpts = is_numeric($key) ? array() : (array)$value;

        method_exists($this, $functionName) && $returnData = call_user_func_array(array($this, $functionName), array(
          $returnData,
          $functionOpts
        ));
      }
    }

    return $returnData;
  }

  /**
   * Antes de guardar si no existe el id (que significa que se insertará un nuevo registro)
   * le asignara un nuevo id.
   * @param  array  $options [description]
   * @return [type]          [description]
   */
	public function beforeSave($options = array()) {
    if (!empty($this->jsonFields)) {
      $this->encodeToJson($options);
    }

    /**
     * Verfica si el modelo ya tiene id, en caso de que no, obtiene uno nuevo.
     */
    if (!$this->issetId()) {
      $this->data[$this->alias][$this->primaryKey] = $this->getNextId();
    }

    return true;
	}

  public function beforeFind($queryData = array()) {
    return $queryData;
  }

  public function afterFind($results, $primary = false) {
    return $results;
	}

  /**
    * Función para verificar si algún modelo pertenece al usuario.
    * @param  integer  $userId   Id del usuario.
    * @param  integer  $modelId  Id del modelo, si es null tomará el valor de $this->id.
    * @param  mixed    $options
    * @return boolean
    */
  public function isOwnedBy($userId, $modelId = null,  $options = array()) {
    /**
     * Establece el id, desde $this->id si $modelId es null
     */
    if (!$modelId && $this->id !== false) {
      $modelId = $this->id;
    }

    $fields = array();
    /**
     * Si $options es string los establece a $userPK, en otro caso
     * los establece de la llave 'userKey'.
     */
    if (is_string($options) && !empty($options)) {
      $userPK = $options;
      $itemPK = $this->primaryKey;
      $options = array();
    } else {
      $userPK = isset($options['userKey']) ? $options['userKey'] : 'cu_cve';
      $itemPK = isset($options['itemKey']) ? $options['itemKey'] : $this->primaryKey;
      $fields = isset($options['fields']) ? $options['fields'] : array();
    }

    // Inicia conditions.
    $options['conditions'] = !empty($options['conditions']) ? $options['conditions'] : array();

    /**
     * Hace la búsqueda.
     * @var [type]
     */
    $results = $this->find(is_array($modelId) ? 'all' : 'first', array(
      'fields' => array_merge(array($this->alias . '.' . $this->primaryKey), (array)$fields),
      'conditions' => array_merge(array(
        $this->alias . '.' . $itemPK  => $modelId,
        $this->alias . '.' . $userPK  => $userId,
      ), $options['conditions']),
      'recursive' => -1
    ));

    /**
     * Si existe la opción extract, se usa Hash::extract()
     */
    if (!empty($options['extract'])) {
      $results =  Hash::extract($results, $options['extract']);
    }

    return !empty($results) ? $results : false;
  }

  /* validation custom */
  public function equalTo($field = array(), $compare_field = null ) {
    foreach( $field as $key => $value ){
      $v1 = $value;
      $v2 = $this->data[$this->name][ $compare_field ];
      if ($v1 !== $v2) {
        return FALSE;
      } else {
        continue;
      }
    }
    return TRUE;
  }

  public function getList_Auto ($table, $id, $name,$order=null) {

    $conditions = " where 1 = 1 ";
    $str_sql = "SELECT $id, $name FROM $table ". $conditions;

    if($order && is_array($order)){
      $str_sql = $str_sql . " order by " . $order['field'] . " " . $order['order'];
    }

    //tesccarespe
    $results = $this->query($str_sql);
    $results = Hash::extract($results, '{n}.{n}');
    return $results;
  }

  public function get_lista($id = 1, $type = 0) {
    $results = array();
    $options = array(
      'order' => array(
        "$this->alias.$this->displayField ASC"
      )
    );

    if ($this->foreignKey && $id) {
      $options['conditions']["$this->alias.$this->foreignKey"] = $id;
    }

    if ($type === 0) {
      $results = $this->find('list', $options);
    } elseif ($type === 1) {
      $options['fields'] = array(
        "{$this->alias}.{$this->primaryKey} as id",
        "{$this->alias}.{$this->displayField} as name"
      );

      $results = $this->find('all', $options);
      $results = Hash::extract($results, '{n}.' . $this->alias);
    }

    return $results;
  }

  /**
   * Imprime el log sql.
   * @param  boolean $show Si es true, imprimirá con formato HTML, falso sólo texto.
   * @return [type]        [description]
   */
  public function getLog($show = false) {
    $db = ConnectionManager::getDataSource('default');

    if ($show === true) {
      $db->showLog();
    } else {
      $log = $db->getLog();

      if (empty($log['log'])) {
        return;
      }

      if ($show === 'return') {
        return $log;
      }

      foreach ($log['log'] as $k => $i) {
        print (($k + 1) . ". {$i['query']}\n");
      }
    }
  }

  protected function error($message) {
    $this->message($message, 'error');
    return false;
  }

  protected function success($message) {
    $this->message($message, 'success');
    return true;
  }

  public function message($message = null, $code = null) {
    if ($message === null) {
      return $this->message;
    }

    $this->message = $message;
    $this->_code = $this->statusCodes[$code];
  }

  public function statusCode() {
    return $this->_code;
  }

  public function getStatus($_status, $key = null) {
    $returnV = current(Hash::extract($this->status, '{s}[val=' . $_status . ']'));
    return $key ? $returnV[$key] : $returnV;
  }

  /**
   * Por default, establece recursive = -1.
   * @param  [type]  $fields     [description]
   * @param  boolean $conditions [description]
   * @param  integer $recursive  [description]
   * @return [type]              [description]
   */
  public function updateAll($fields, $conditions = true, $recursive = -1) {
    if (!isset($recursive)) {
      $recursive = $this->recursive;
    }

    /**
     * Es necesario remover las relaciones 'hasOne' y 'belongsTo' temporalmente.
     * @var [type]
     */
    if ($recursive === -1) {
      $belongsTo = $this->belongsTo;
      $hasOne = $this->hasOne;
      $this->unbindModel(array(
        'belongsTo' => array_keys($belongsTo),
        'hasOne' => array_keys($hasOne)
      ), true);
    }

    $result = parent::updateAll($fields, $conditions);

    /**
     * Una vez que se actualiza, se vuelve a relacionar los modelos.
     * @var [type]
     */
    if ($recursive === -1) {
      $this->bindModel(array(
        'belongsTo' => $belongsTo,
        'hasOne' => $hasOne
      ), true);
    }

    return $result;
  }
}
