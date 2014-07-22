<?php
/**
 * Oracle layer for DBO.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model.datasources.dbo
 * @since         CakePHP v 1.2.0.4041
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('DboSource', 'Model/Datasource');

/**
 * Oracle layer for DBO.
 *
 * Long description for class
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model.datasources.dbo
 */
class Oracle extends DboSource {

/**
 * Configuration options
 *
 * @var array
 * @access public
 */
  public $config = array();

/**
 * Alias
 *
 * @var string
 */
  public $alias = '';

/**
 * Sequence names as introspected from the database
 */
  public $_sequences = array();

/**
 * Contador para las transacciones.
 * @var integer
 */
public $transactionsCounter = 0;

/**
 * Transaction in progress flag
 *
 * @var boolean
 */
  public $__transactionStarted = false;

/**
 * Column definitions
 *
 * @var array
 * @access public
 */
  public $columns = array(
    'primary_key' => array('name' => ''),
    'string' => array('name' => 'varchar2', 'limit' => '255'),
    'text' => array('name' => 'varchar2'),
    'integer' => array('name' => 'number'),
    'float' => array('name' => 'float'),
    'datetime' => array('name' => 'date', 'format' => 'Y-m-d H:i:s'),
    'timestamp' => array('name' => 'date', 'format' => 'Y-m-d H:i:s'),
    'time' => array('name' => 'date', 'format' => 'Y-m-d H:i:s'),
    'date' => array('name' => 'date', 'format' => 'Y-m-d H:i:s'),
    'binary' => array('name' => 'bytea'),
    'boolean' => array('name' => 'boolean'),
    'number' => array('name' => 'number'),
    'inet' => array('name' => 'inet'));

/**
 * Connection object
 *
 * @var mixed
 * @access public
 */
  public $connection;

/**
 * Query limit
 *
 * @var int
 * @access protected
 */
  protected $_limit = -1;

/**
 * Query offset
 *
 * @var int
 * @access protected
 */
  protected $_offset = 0;

/**
 * Enter description here...
 *
 * @var unknown_type
 * @access protected
 */
  protected $_map;

/**
 * Current Row
 *public
 * @var mixed
 * @access protected
 */
  protected $_currentRow;

/**
 * Number of rows
 *
 * @var int
 * @access protected
 */
  protected $_numRows;

/**
 * Query results
 *
 * @var mixed
 * @access protected
 */
  protected $_result;

/**
 * Last error issued by oci extension
 *
 * @var unknown_type
 */
  protected $_error;

/**
 * Base configuration settings for MySQL driver
 *
 * @var array
 */
  protected $_baseConfig = array(
    'persistent' => true,
    'host' => 'localhost',
    'login' => 'system',
    'password' => '',
    'database' => 'cake',
    'nls_sort' => '',
    'nls_sort' => ''
  );

/**
 * Table-sequence map
 *
 * @var unknown_type
 */
  protected $_sequenceMap = array();

/**
 * Connects to the database using options in the given configuration array.
 *
 * @return boolean True if the database could be connected, else false
 * @access public
 */
  public function connect() {
    $config = $this->config;
    $this->connected = false;
    $config['encoding'] = !empty($config['encoding']) ? $config['encoding'] : null;

    if (!$config['persistent']) {
      $this->connection = @oci_connect($config['login'], $config['password'], $config['database'], $config['encoding']);
    } else {
      $this->connection = @oci_pconnect($config['login'], $config['password'], $config['database'], $config['encoding']);
    }

    if ($this->connection) {
      $this->connected = true;
      if (!empty($config['nls_sort'])) {
        $this->execute('ALTER SESSION SET NLS_SORT='.$config['nls_sort']);
      }

      if (!empty($config['nls_comp'])) {
        $this->execute('ALTER SESSION SET NLS_COMP='.$config['nls_comp']);
      }
      $this->execute("ALTER SESSION SET NLS_DATE_FORMAT='YYYY-MM-DD HH24:MI:SS'");
    } else {
      $this->connected = false;
      $this->_setError();
      return false;
    }
    return $this->connected;
  }

/**
 * Keeps track of the most recent Oracle error
 *
 */
  function _setError($source = null, $clear = false) {
    if ($source) {
      $e = oci_error($source);
    } else {
      $e = oci_error();
    }
    $this->_error = $e['message'];
    if ($clear) {
      $this->_error = null;
    }
  }

/**
 * Sets the encoding language of the session
 *
 * @param string $lang language constant
 * @return bool
 */
  function setEncoding($lang) {
    if (!$this->execute('ALTER SESSION SET NLS_LANGUAGE='.$lang)) {
      return false;
    }
    return true;
  }

/**
 * Gets the current encoding language
 *
 * @return string language constant
 */
  function getEncoding() {
    $sql = 'SELECT VALUE FROM NLS_SESSION_PARAMETERS WHERE PARAMETER=\'NLS_LANGUAGE\'';
    if (!$this->execute($sql)) {
      return false;
    }

    if (!$row = $this->fetchRow()) {
      return false;
    }
    return $row[0]['VALUE'];
  }

/**
 * Disconnects from database.
 *
 * @return boolean True if the database could be disconnected, else false
 * @access public
 */
  public function disconnect() {
    if ($this->connection) {
      $this->connected = !oci_close($this->connection);
      return !$this->connected;
    }
  }

/**
 * Scrape the incoming SQL to create the association map. This is an extremely
 * experimental method that creates the association maps since Oracle will not tell us.
 *
 * @param string $sql
 * @return false if sql is nor a SELECT
 * @access protected
 */
  protected function _scrapeSQL($sql) {
    $sql = str_replace("\"", '', $sql);
    $preFrom = preg_split('/\bFROM\b/', $sql);
    $preFrom = $preFrom[0];
    $find = array('SELECT');
    $replace = array('');
    $fieldList = trim(str_replace($find, $replace, $preFrom));
    $fields = preg_split('/,\s+/', $fieldList);//explode(', ', $fieldList);
    $lastTableName  = '';

    foreach($fields as $key => $value) {
      if ($value != 'COUNT(*) AS count') {
        if (preg_match('/\s+(\w+(\.\w+)*)$/', $value, $matches)) {
          $fields[$key] = $matches[1];

          if (preg_match('/^(\w+\.)/', $value, $matches)) {
            $fields[$key] = $matches[1] . $fields[$key];
            $lastTableName  = $matches[1];
          }
        }
        /*
        if (preg_match('/(([[:alnum:]_]+)\.[[:alnum:]_]+)(\s+AS\s+(\w+))?$/i', $value, $matches)) {
          $fields[$key] = isset($matches[4]) ? $matches[2] . '.' . $matches[4] : $matches[1];
        }
        */
      }
    }
    $this->_map = array();

    foreach($fields as $f) {
      if (strpos($f, $this->virtualFieldSeparator) == false) {
        $e = explode('.', $f);
      } else {
        $e = explode($this->virtualFieldSeparator, $f);
      }

      if (count($e) > 1) {
        $table = $e[0];
        if (strpos($table, '.') !== false) {
          $table = explode('.', $table);
          $table = end($table);
        }

        $field = strtolower($e[1]);
      } else {
        $table = 0;
        $field = $e[0];
      }
      $this->_map[] = array($table, $field);
    }
  }

/**
 * Modify a SQL query to limit (and offset) the result set
 *
 * @param integer $limit Maximum number of rows to return
 * @param integer $offset Row to begin returning
 * @return modified SQL Query
 * @access public
 */
  public function limit($limit = -1, $offset = 0) {
    $this->_limit = (int) $limit;
    $this->_offset = (int) $offset;
  }

/**
 * Returns number of rows in previous resultset. If no previous resultset exists,
 * this returns false.
 *
 * @return integer Number of rows in resultset
 * @access public
 */
  public function lastNumRows($source = null) {
    return $this->_numRows;
  }

/**
 * Executes given SQL statement. This is an overloaded method.
 *
 * @param string $sql SQL statement
 * @return resource Result resource identifier or null
 * @access protected
 */
  protected function _execute($sql, $params = array(), $prepareOptions = array()) {
    $this->_statementId = @oci_parse($this->connection, $sql);
    if (!$this->_statementId) {
      $this->_setError($this->connection);
      return false;
    }

    if ($this->__transactionStarted && $this->transactionsCounter > 0) {
      $mode = OCI_NO_AUTO_COMMIT;
    } else {
      $mode = OCI_COMMIT_ON_SUCCESS;
    }

    if (!@oci_execute($this->_statementId, $mode)) {
      $this->_setError($this->_statementId);
      return false;
    }

    $this->_setError(null, true);

    switch(oci_statement_type($this->_statementId)) {
      case 'DESCRIBE':
      case 'SELECT':
        $this->_scrapeSQL($sql);
      break;
      default:
        return $this->_statementId;
      break;
    }

    if ($this->_limit >= 1) {
      oci_set_prefetch($this->_statementId, $this->_limit);
    } else {
      oci_set_prefetch($this->_statementId, 3000);
    }
    $this->_numRows = oci_fetch_all($this->_statementId, $this->_results, $this->_offset, $this->_limit, OCI_NUM | OCI_FETCHSTATEMENT_BY_ROW);
    $this->_currentRow = 0;
    $this->limit();
    return $this->_statementId;
  }

/**
 * Fetch result row
 *
 * @return array
 * @access public
 */
  public function fetchRow($sql = null) {
    if ($this->_currentRow >= $this->_numRows) {
      /**
        * Existe una advertencia cuando el query no devulve algún resultado.
        * Apuntar $this->_statementId a null, es igual que oci_free_statement($this->_statementId);
        *
        * oci_free_statement($this->_statementId);
        */
      $this->_statementId = null;
      $this->_map = null;
      $this->_results = null;
      $this->_currentRow = null;
      $this->_numRows = null;
      return false;
    }
    $resultRow = array();

    foreach($this->_results[$this->_currentRow] as $index => $field) {
      list($table, $column) = $this->_map[$index];

      if (strpos($column, ' count')) {
        $resultRow[0]['count'] = $field;
      } else {
        $result = $this->_results[$this->_currentRow][$index];
        if ((empty($result) || trim($result) === '') && !empty($resultRow[$table][$column])) {
          $result = $resultRow[$table][$column];
        }

        $resultRow[$table][$column] = $result;
      }
    }
    $this->_currentRow++;
    return $resultRow;
  }

/**
 * Fetches the next row from the current result set
 *
 * @return unknown
 */
  function fetchResult() {
    return $this->fetchRow();
  }

/**
 * Checks to see if a named sequence exists
 *
 * @param string $sequence
 * @return bool
 * @access public
 */
  public function sequenceExists($sequence) {
    $sql = "SELECT SEQUENCE_NAME FROM USER_SEQUENCES WHERE SEQUENCE_NAME = '$sequence'";
    if (!$this->execute($sql)) {
      return false;
    }
    return $this->fetchRow();
  }

/**
 * Creates a database sequence
 *
 * @param string $sequence
 * @return bool
 * @access public
 */
  public function createSequence($sequence) {
    $sql = "CREATE SEQUENCE $sequence";
    return $this->execute($sql);
  }

/**
 * Create trigger
 *
 * @param string $table
 * @return mixed
 * @access public
 */
  public function createTrigger($table) {
    $sql = "CREATE OR REPLACE TRIGGER pk_$table" . "_trigger BEFORE INSERT ON $table FOR EACH ROW BEGIN SELECT pk_$table.NEXTVAL INTO :NEW.ID FROM DUAL; END;";
    return $this->execute($sql);
  }

/**
 * Returns an array of tables in the database. If there are no tables, an error is
 * raised and the application exits.
 *
 * @return array tablenames in the database
 * @access public
 */
  public function listSources($data = null) {
    $cache = parent::listSources();
    if ($cache != null) {
      return $cache;
    }
    $sql = 'SELECT view_name AS name FROM all_views  where owner= \''.strtoupper($this->config['login']).'\'';
     $sql.='
            UNION
            SELECT table_name AS name FROM all_tables  where owner= \''.strtoupper($this->config['login']).'\'';

    if (!$this->execute($sql)) {
      return false;
    }
    $sources = array();

    while($r = $this->fetchRow()) {
      $sources[] = strtolower($r[0]['name']);
    }
    parent::listSources($sources);
    return $sources;
  }

/**
 * Returns an array of the fields in given table name.
 *
 * @param object instance of a model to inspect
 * @return array Fields in table. Keys are name and type
 * @access public
 */
  public function describe($model) {
    $table = $this->fullTableName($model, false);

    if (!empty($model->sequence)) {
      $this->_sequenceMap[$table] = $model->sequence;
    } elseif (!empty($model->table)) {
      $this->_sequenceMap[$table] = $model->table . '_seq';
    }

    $cache = parent::describe($model);

    if ($cache != null) {
      return $cache;
    }

    $sql = 'SELECT COLUMN_NAME, DATA_TYPE, DATA_LENGTH FROM all_tab_columns WHERE table_name = \'';
    $sql .= strtoupper($this->fullTableName($model)) . '\'';

    if (isset($this->config['schema'])) {
      $sql .= ' AND owner = \'' . strtoupper($this->config['login']) . '\'';
    }

    if (!$this->execute($sql)) {
      return false;
    }

    $fields = array();

    for ($i = 0; $row = $this->fetchRow(); $i++) {
      $fields[strtolower($row[0]['COLUMN_NAME'])] = array(
        'type'=> $this->column($row[0]['DATA_TYPE']),
        'length'=> $row[0]['DATA_LENGTH']
      );
    }
    #$this->__cacheDescription($this->fullTableName($model, false), $fields);

    return $fields;
  }

/**
 * Deletes all the records in a table and drops all associated auto-increment sequences.
 * Using DELETE instead of TRUNCATE because it causes locking problems.
 *
 * @param mixed $table A string or model class representing the table to be truncated
 * @param integer $reset If -1, sequences are dropped, if 0 (default), sequences are reset,
 *            and if 1, sequences are not modified
 * @return boolean  SQL TRUNCATE TABLE statement, false if not applicable.
 * @access public
 *
 */
  public function truncate($table, $reset = 0) {

    if (empty($this->_sequences)) {
      $sql = "SELECT sequence_name FROM all_sequences";
      $this->execute($sql);
      while ($row = $this->fetchRow()) {
        $this->_sequences[] = strtolower($row[0]['sequence_name']);
      }
    }

    $this->execute('DELETE FROM ' . $this->fullTableName($table));
    if (!isset($this->_sequenceMap[$table]) || !in_array($this->_sequenceMap[$table], $this->_sequences)) {
      return true;
    }
    if ($reset === 0) {
      $this->execute("SELECT {$this->_sequenceMap[$table]}.nextval FROM dual");
      $row = $this->fetchRow();
      $currval = $row[$this->_sequenceMap[$table]]['nextval'];

      $this->execute("SELECT min_value FROM all_sequences WHERE sequence_name = '{$this->_sequenceMap[$table]}'");
      $row = $this->fetchRow();
      $min_value = $row[0]['min_value'];

      if ($min_value == 1) $min_value = 0;
      $offset = -($currval - $min_value);

      $this->execute("ALTER SEQUENCE {$this->_sequenceMap[$table]} INCREMENT BY $offset MINVALUE $min_value");
      $this->execute("SELECT {$this->_sequenceMap[$table]}.nextval FROM dual");
      $this->execute("ALTER SEQUENCE {$this->_sequenceMap[$table]} INCREMENT BY 1");
    } else {
      //$this->execute("DROP SEQUENCE {$this->_sequenceMap[$table]}");
    }
    return true;
  }

/**
 * Enables, disables, and lists table constraints
 *
 * Note: This method could have been written using a subselect for each table,
 * however the effort Oracle expends to run the constraint introspection is very high.
 * Therefore, this method caches the result once and loops through the arrays to find
 * what it needs. It reduced my query time by 50%. YMMV.
 *
 * @param string $action
 * @param string $table
 * @return mixed boolean true or array of constraints
 */
  function constraint($action, $table) {
    if (empty($table)) {
      trigger_error(__('Must specify table to operate on constraints', true));
    }

    $table = strtoupper($table);

    if (empty($this->_keyConstraints)) {
      $sql = "SELECT
            table_name,
            c.constraint_name
          FROM all_cons_columns cc
          LEFT JOIN all_indexes i ON (cc.constraint_name = i.index_name)
          LEFT JOIN all_constraints c ON(c.constraint_name = cc.constraint_name)";
      $this->execute($sql);
      while ($row = $this->fetchRow()) {
        $this->_keyConstraints[] = array($row[0]['table_name'], $row['c']['constraint_name']);
      }
    }

    $relatedKeys = array();
    foreach ($this->_keyConstraints as $c) {
      if ($c[0] == $table) {
        $relatedKeys[] = $c[1];
      }
    }

    if (empty($this->_constraints)) {
      $sql = "SELECT
            table_name,
            constraint_name,
            r_constraint_name
          FROM
            all_constraints";
      $this->execute($sql);
      while ($row = $this->fetchRow()) {
        $this->_constraints[] = $row[0];
      }
    }

    $constraints = array();
    foreach ($this->_constraints as $c) {
      if (in_array($c['r_constraint_name'], $relatedKeys)) {
        $constraints[] = array($c['table_name'], $c['constraint_name']);
      }
    }

    foreach ($constraints as $c) {
      list($table, $constraint) = $c;
      switch ($action) {
        case 'enable':
          $this->execute("ALTER TABLE $table ENABLE CONSTRAINT $constraint");
          break;
        case 'disable':
          $this->execute("ALTER TABLE $table DISABLE CONSTRAINT $constraint");
          break;
        case 'list':
          return $constraints;
          break;
        default:
          trigger_error(__('DboOracle::constraint() accepts only enable, disable, or list', true));
      }
    }
    return true;
  }

/**
 * Returns an array of the indexes in given table name.
 *
 * @param string $model Name of model to inspect
 * @return array Fields in table. Keys are column and unique
 */
  function index($model) {
    $index = array();
    $table = $this->fullTableName($model, false);
    if ($table) {
      $indexes = $this->query('SELECT
        cc.table_name,
        cc.column_name,
        cc.constraint_name,
        c.constraint_type,
        i.index_name,
        i.uniqueness
      FROM all_cons_columns cc
      LEFT JOIN all_indexes i ON(cc.constraint_name = i.index_name)
      LEFT JOIN all_constraints c ON(c.constraint_name = cc.constraint_name)
      WHERE cc.table_name = \'' . strtoupper($table) .'\'');
      foreach ($indexes as $i => $idx) {
        if ($idx['c']['constraint_type'] == 'P') {
          $key = 'PRIMARY';
        } else {
          continue;
        }
        if (!isset($index[$key])) {
          $index[$key]['column'] = strtolower($idx['cc']['column_name']);
          $index[$key]['unique'] = intval($idx['i']['uniqueness'] == 'UNIQUE');
        } else {
          if (!is_array($index[$key]['column'])) {
            $col[] = $index[$key]['column'];
          }
          $col[] = strtolower($idx['cc']['column_name']);
          $index[$key]['column'] = $col;
        }
      }
    }
    return $index;
  }

/**
 * Generate a Oracle Alter Table syntax for the given Schema comparison
 *
 * @param unknown_type $schema
 * @return unknown
 */
  function alterSchema($compare, $table = null) {
    if (!is_array($compare)) {
      return false;
    }
    $out = '';
    $colList = array();
    foreach($compare as $curTable => $types) {
      if (!$table || $table == $curTable) {
        $out .= 'ALTER TABLE ' . $this->fullTableName($curTable) . " \n";
        foreach($types as $type => $column) {
          switch($type) {
            case 'add':
              foreach($column as $field => $col) {
                $col['name'] = $field;
                $alter = 'ADD '.$this->buildColumn($col);
                if (isset($col['after'])) {
                  $alter .= ' AFTER '. $this->name($col['after']);
                }
                $colList[] = $alter;
              }
            break;
            case 'drop':
              foreach($column as $field => $col) {
                $col['name'] = $field;
                $colList[] = 'DROP '.$this->name($field);
              }
            break;
            case 'change':
              foreach($column as $field => $col) {
                if (!isset($col['name'])) {
                  $col['name'] = $field;
                }
                $colList[] = 'CHANGE '. $this->name($field).' '.$this->buildColumn($col);
              }
            break;
          }
        }
        $out .= "\t" . implode(",\n\t", $colList) . ";\n\n";
      }
    }
    return $out;
  }

/**
 * This method should quote Oracle identifiers. Well it doesn't.
 * It would break all scaffolding and all of Cake's default assumptions.
 *
 * @param unknown_type $var
 * @return unknown
 * @access public
 */
  /*public function name($name) {
    if (strpos($name, '.') !== false && strpos($name, '"') === false) {
      list($model, $field) = explode('.', $name);
      if ($field[0] == "_") {
        $name = "$model.\"$field\"";
      }
    } else {
      if ($name[0] == "_") {
        $name = "\"$name\"";
      }
    }
    return $name;
  }*/

/**
 * Begin a transaction
 *
 * @param unknown_type $model
 * @return boolean True on success, false on fail
 * (i.e. if the database/model does not support transactions).
 */
  public function begin() {
    $this->transactionsCounter += 1;
    $this->__transactionStarted = true;
    return true;
  }

/**
 * Rollback a transaction
 *
 * @param unknown_type $model
 * @return boolean True on success, false on fail
 * (i.e. if the database/model does not support transactions,
 * or a transaction has not started).
 */
  public function rollback() {
    $this->__transactionStarted = false;
    return oci_rollback($this->connection);
  }

/**
 * Commit a transaction
 *
 * @param unknown_type $model
 * @return boolean True on success, false on fail
 * (i.e. if the database/model does not support transactions,
 * or a transaction has not started).
 */
  public function commit() {
    if ($this->transactionsCounter >= 1) {
      //$this->__transactionStarted = true;
      $this->transactionsCounter -= 1;
    }

    if ($this->transactionsCounter === 0) {
      $this->__transactionStarted = false;
      return oci_commit($this->connection);
    }

    return true;
  }

/**
 * Converts database-layer column types to basic types
 *
 * @param string $real Real database-layer column type (i.e. "varchar(255)")
 * @return string Abstract column type (i.e. "string")
 * @access public
 */
  public function column($real) {
    if (is_array($real)) {
      $col = $real['name'];

      if (isset($real['limit'])) {
        $col .= '('.$real['limit'].')';
      }
      return $col;
    } else {
      $real = strtolower($real);
    }
    $col = str_replace(')', '', $real);
    $limit = null;
    if (strpos($col, '(') !== false) {
      list($col, $limit) = explode('(', $col);
    }

    if (in_array($col, array('date', 'timestamp'))) {
      return $col;
    }
    if (strpos($col, 'nvarchar') !== false) {
      return 'text';
    }

    if (strpos($col, 'number') !== false) {
      return 'integer';
    }
    if (strpos($col, 'integer') !== false) {
      return 'integer';
    }
    if (strpos($col, 'char') !== false) {
      return 'string';
    }
    if (strpos($col, 'text') !== false) {
      return 'text';
    }
    if (strpos($col, 'blob') !== false) {
      return 'binary';
    }
    if (in_array($col, array('float', 'double', 'decimal'))) {
      return 'float';
    }
    if ($col == 'boolean') {
      return $col;
    }
    return 'text';
  }

/**
 * Returns a quoted and escaped string of $data for use in an SQL statement.
 *
 * @param string $data String to be prepared for use in an SQL statement
 * @return string Quoted and escaped
 * @access public
 */
  public function value($data, $column = null, $safe = false) {

    if (is_array($data) && !empty($data)) {
      return array_map(
        array(&$this, 'value'),
        $data, array_fill(0, count($data), $column)
      );
    } elseif (is_object($data) && isset($data->type, $data->value)) {
      if ($data->type == 'identifier') {
        return $this->name($data->value);
      } elseif ($data->type == 'expression') {
        return $data->value;
      }
    } elseif (in_array($data, array('{$__cakeID__$}', '{$__cakeForeignKey__$}'), true)) {
      return $data;
    }

    /*$parent = parent::value($data, $column, $safe);

    if ($parent != null) {
      return $parent;
    }*/


    if ($data === null) {
      return 'NULL';
    }

    if ($data === '') {
      return  "''";
    }

    switch($column) {
      case 'date':
        $data_=explode("/",$data);
        if(count($data_)==3){
          $f=explode(" ",$data[2]);
          if(count($f)==2){
            $data="$f[0]-$data_[1]-$data_[0] $f[1]";
          }
          else{
            $data="$data_[2]-$data_[1]-$data_[0]";;
          }
        }
        $data = date('Y-m-d H:i:s', strtotime($data));
        $data = "TO_DATE('$data', 'YYYY-MM-DD HH24:MI:SS')";
      break;
      case 'integer' :
      case 'float' :
      case null :
        if (is_numeric($data)) {
          break;
        }
      default:
        $data = str_replace("'", "''", $data);
        $data = "'$data'";
      break;
    }
    return $data;
  }

/**
 * Returns the ID generated from the previous INSERT operation.
 *
 * @param string
 * @return integer
 * @access public
 */
  public function lastInsertId($source = null) {
    $sequence = $this->_sequenceMap[$source];
    $sql = "SELECT $sequence.currval FROM dual";

    if (!$this->execute($sql)) {
      return false;
    }

    while($row = $this->fetchRow()) {
      return $row[$sequence]['currval'];
    }
    return false;
  }

/**
 * Returns a formatted error message from previous database operation.
 *
 * @return string Error message with error number
 * @access public
 */
  public function lastError(PDOStatement $query = null) {
    return $this->_error;
  }

/**
 * Returns number of affected rows in previous database operation. If no previous operation exists, this returns false.
 *
 * @return int Number of affected rows
 * @access public
 */
  public function lastAffected($source = null) {
    return $this->_statementId ? oci_num_rows($this->_statementId): false;
  }

/**
 * Renders a final SQL statement by putting together the component parts in the correct order
 *
 * @param string $type
 * @param array $data
 * @return string
 */
  public function renderStatement($type, $data) {
    extract($data);
    $aliases = null;

    switch (strtolower($type)) {
      case 'select':
        return "SELECT {$fields} FROM {$table} {$alias} {$joins} {$conditions} {$connect} {$group} {$order} {$limit}";
      break;
      case 'create':
        return "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
      break;
      case 'update':
        if (!empty($alias)) {
          $aliases = "{$this->alias}{$alias} ";
        }
        return "UPDATE {$table} {$aliases}SET {$fields} {$conditions}";
      break;
      case 'delete':
        if (!empty($alias)) {
          $aliases = "{$this->alias}{$alias} ";
        }
        return "DELETE FROM {$table} {$aliases}{$conditions}";
      break;
      case 'schema':
        foreach (array('columns', 'indexes') as $var) {
          if (is_array(${$var})) {
            ${$var} = "\t" . implode(",\n\t", array_filter(${$var}));
          }
        }
        if (trim($indexes) != '') {
          $columns .= ',';
        }
        return "CREATE TABLE {$table} (\n{$columns}{$indexes})";
      break;
      case 'alter':
        break;
    }
  }

/**
 * Enter description here...
 *
 * @param Model $model
 * @param unknown_type $linkModel
 * @param string $type Association type
 * @param unknown_type $association
 * @param unknown_type $assocData
 * @param unknown_type $queryData
 * @param unknown_type $external
 * @param unknown_type $resultSet
 * @param integer $recursive Number of levels of association
 * @param array $stack
 */

 // public function queryAssociation(Model $model, &$linkModel, $type, $association, $assocData, &$queryData, $external, &$resultSet, $recursive, $stack) {
 //    if (isset($stack['_joined'])) {
 //      $joined = $stack['_joined'];
 //      unset($stack['_joined']);
 //    }

 //    if ($query = $this->generateAssociationQuery($model, $linkModel, $type, $association, $assocData, $queryData, $external, $resultSet)) {
 //      if (!is_array($resultSet)) {
 //        throw new CakeException(__d('cake_dev', 'Error in Model %s', get_class($model)));
 //      }
 //      if ($type === 'hasMany' && empty($assocData['limit']) && !empty($assocData['foreignKey'])) {
 //        $ins = $fetch = array();
 //        foreach ($resultSet as &$result) {
 //          if ($in = $this->insertQueryData('{$__cakeID__$}', $result, $association, $assocData, $model, $linkModel, $stack)) {
 //            $ins[] = $in;
 //          }
 //        }

 //        if (!empty($ins)) {
 //          $ins = array_unique($ins);
 //          $fetch = $this->fetchAssociated($model, $query, $ins);
 //        }

 //        if (!empty($fetch) && is_array($fetch)) {
 //          if ($recursive > 0) {
 //            foreach ($linkModel->associations() as $type1) {
 //              foreach ($linkModel->{$type1} as $assoc1 => $assocData1) {
 //                $deepModel = $linkModel->{$assoc1};
 //                $tmpStack = $stack;
 //                $tmpStack[] = $assoc1;

 //                if ($linkModel->useDbConfig === $deepModel->useDbConfig) {
 //                  $db = $this;
 //                } else {
 //                  $db = ConnectionManager::getDataSource($deepModel->useDbConfig);
 //                }
 //                $db->queryAssociation($linkModel, $deepModel, $type1, $assoc1, $assocData1, $queryData, true, $fetch, $recursive - 1, $tmpStack);
 //              }
 //            }
 //          }
 //        }
 //        if ($queryData['callbacks'] === true || $queryData['callbacks'] === 'after') {
 //          $this->_filterResults($fetch, $model);
 //        }
 //        return $this->_mergeHasMany($resultSet, $fetch, $association, $model, $linkModel);
 //      } elseif ($type === 'hasAndBelongsToMany') {
 //        $ins = $fetch = array();
 //        foreach ($resultSet as &$result) {
 //          if ($in = $this->insertQueryData('{$__cakeID__$}', $result, $association, $assocData, $model, $linkModel, $stack)) {
 //            $ins[] = $in;
 //          }
 //        }
 //        if (!empty($ins)) {
 //          $ins = array_unique($ins);
 //          if (count($ins) > 1) {
 //            $query = str_replace('{$__cakeID__$}', '(' . implode(', ', $ins) . ')', $query);
 //            $query = str_replace('= (', 'IN (', $query);
 //          } else {
 //            $query = str_replace('{$__cakeID__$}', $ins[0], $query);
 //          }
 //          $query = str_replace(' WHERE 1 = 1', '', $query);
 //        }

 //        $foreignKey = $model->hasAndBelongsToMany[$association]['foreignKey'];
 //        $joinKeys = array($foreignKey, $model->hasAndBelongsToMany[$association]['associationForeignKey']);
 //        list($with, $habtmFields) = $model->joinModel($model->hasAndBelongsToMany[$association]['with'], $joinKeys);
 //        $habtmFieldsCount = count($habtmFields);
 //        $q = $this->insertQueryData($query, null, $association, $assocData, $model, $linkModel, $stack);

 //        if ($q !== false) {
 //          $fetch = $this->fetchAll($q, $model->cacheQueries);
 //        } else {
 //          $fetch = null;
 //        }
 //      }

 //      $modelAlias = $model->alias;
 //      $modelPK = $model->primaryKey;
 //      foreach ($resultSet as &$row) {
 //        if ($type !== 'hasAndBelongsToMany') {
 //          $q = $this->insertQueryData($query, $row, $association, $assocData, $model, $linkModel, $stack);
 //          $fetch = null;
 //          if ($q !== false) {
 //            $joinedData = array();
 //            if (($type === 'belongsTo' || $type === 'hasOne') && isset($row[$linkModel->alias], $joined[$model->alias]) && in_array($linkModel->alias, $joined[$model->alias])) {
 //              $joinedData = Hash::filter($row[$linkModel->alias]);
 //              if (!empty($joinedData)) {
 //                $fetch[0] = array($linkModel->alias => $row[$linkModel->alias]);
 //              }
 //            } else {
 //              $fetch = $this->fetchAll($q, $model->cacheQueries);
 //            }
 //          }
 //        }
 //        $selfJoin = $linkModel->name === $model->name;

 //        if (!empty($fetch) && is_array($fetch)) {
 //          if ($recursive > 0) {
 //            foreach ($linkModel->associations() as $type1) {
 //              foreach ($linkModel->{$type1} as $assoc1 => $assocData1) {
 //                $deepModel = $linkModel->{$assoc1};

 //                if ($type1 === 'belongsTo' || ($deepModel->alias === $modelAlias && $type === 'belongsTo') || ($deepModel->alias !== $modelAlias)) {
 //                  $tmpStack = $stack;
 //                  $tmpStack[] = $assoc1;
 //                  if ($linkModel->useDbConfig == $deepModel->useDbConfig) {
 //                    $db = $this;
 //                  } else {
 //                    $db = ConnectionManager::getDataSource($deepModel->useDbConfig);
 //                  }
 //                  $db->queryAssociation($linkModel, $deepModel, $type1, $assoc1, $assocData1, $queryData, true, $fetch, $recursive - 1, $tmpStack);
 //                }
 //              }
 //            }
 //          }
 //          if ($type === 'hasAndBelongsToMany') {
 //            $merge = array();

 //            foreach ($fetch as $data) {
 //              if (isset($data[$with]) && $data[$with][$foreignKey] === $row[$modelAlias][$modelPK]) {
 //                if ($habtmFieldsCount <= 2) {
 //                  unset($data[$with]);
 //                }
 //                $merge[] = $data;
 //              }
 //            }
 //            if (empty($merge) && !isset($row[$association])) {
 //              $row[$association] = $merge;
 //            } else {
 //              $this->_mergeAssociation($row, $merge, $association, $type);
 //            }
 //          } else {
 //            $this->_mergeAssociation($row, $fetch, $association, $type, $selfJoin);
 //          }
 //          if (isset($row[$association])) {
 //            $row[$association] = $linkModel->afterFind($row[$association], false);
 //          }
 //        } else {
 //          $tempArray[0][$association] = false;
 //          $this->_mergeAssociation($row, $tempArray, $association, $type, $selfJoin);
 //        }
 //      }
 //    }
 //  }

  // public function queryAssociation_ORalce(Model $model, &$linkModel, $type, $association, $assocData, &$queryData, $external = false, &$resultSet, $recursive, $stack) {
  //   if ($query = $this->generateAssociationQuery($model, $linkModel, $type, $association, $assocData, $queryData, $external, $resultSet)) {
  //     if (!isset($resultSet) || !is_array($resultSet)) {
  //       throw new CakeException(__d('cake_dev', 'Error in Model %s', get_class($model)));
  //       /*if (Configure::read() > 0) {
  //         echo '<div style = "font: Verdana bold 12px; color: #FF0000">' . sprintf(__('SQL Error in model %s:', true), $model->alias) . ' ';
  //         if (isset($this->error) && $this->error != null) {
  //           echo $this->error;
  //         }
  //         echo '</div>';
  //       }
  //       return null;
  //       */
  //     }
  //     $count = count($resultSet);

  //     if ($type === 'hasMany' && (!isset($assocData['limit']) || empty($assocData['limit']))) {
  //     /*  $ins = $fetch = array();
  //       foreach ($resultSet as &$result) {
  //         if ($in = $this->insertQueryData('{$__cakeID__$}', $result, $association, $assocData, $model, $linkModel, $stack)) {
  //           $ins[] = $in;
  //         }
  //       }

  //       if (!empty($ins)) {
  //         $ins = array_unique($ins);
  //         $fetch = $this->fetchAssociated($model, $query, $ins);
  //       }

  //       if (!empty($fetch) && is_array($fetch)) {
  //         if ($recursive > 0) {
  //           foreach ($linkModel->associations() as $type1) {
  //             foreach ($linkModel->{$type1} as $assoc1 => $assocData1) {
  //               $deepModel = $linkModel->{$assoc1};
  //               $tmpStack = $stack;
  //               $tmpStack[] = $assoc1;

  //               if ($linkModel->useDbConfig === $deepModel->useDbConfig) {
  //                 $db = $this;
  //               } else {
  //                 $db = ConnectionManager::getDataSource($deepModel->useDbConfig);
  //               }
  //               $db->queryAssociation($linkModel, $deepModel, $type1, $assoc1, $assocData1, $queryData, true, $fetch, $recursive - 1, $tmpStack);
  //             }
  //           }
  //         }
  //       }
  //       if ($queryData['callbacks'] === true || $queryData['callbacks'] === 'after') {
  //         $this->_filterResults($fetch, $model);
  //       }
  //       return $this->_mergeHasMany($resultSet, $fetch, $association, $model, $linkModel);*/


  //       $ins = $fetch = array();
  //       for ($i = 0; $i < $count; $i++) {
  //         if ($in = $this->insertQueryData('{$__cakeID__$}', $resultSet[$i], $association, $assocData, $model, $linkModel, $stack)) {
  //           $ins[] = $in;
  //         }
  //       }

  //       if (!empty($ins)) {
  //         $fetch = array();
  //         $ins = array_chunk($ins, 1000);
  //         foreach ($ins as $i) {
  //           $q = str_replace('{$__cakeID__$}', implode(', ', $i), $query);
  //           $q = str_replace('= (', 'IN (', $q);
  //           $res = $this->fetchAll($q, $model->cacheQueries, $model->alias);
  //           $fetch = array_merge($fetch, $res);
  //         }
  //       }

  //       if (!empty($fetch) && is_array($fetch)) {
  //         if ($recursive > 0) {

  //           foreach ($linkModel->__associations as $type1) {
  //             foreach ($linkModel->{$type1} as $assoc1 => $assocData1) {
  //               $deepModel =& $linkModel->{$assoc1};
  //               $tmpStack = $stack;
  //               $tmpStack[] = $assoc1;

  //               if ($linkModel->useDbConfig === $deepModel->useDbConfig) {
  //                 $db =& $this;
  //               } else {
  //                 $db =& ConnectionManager::getDataSource($deepModel->useDbConfig);
  //               }
  //               $db->queryAssociation($linkModel, $deepModel, $type1, $assoc1, $assocData1, $queryData, true, $fetch, $recursive - 1, $tmpStack);
  //             }
  //           }
  //         }
  //       }
  //       return $this->_mergeHasMany($resultSet, $fetch, $association, $model, $linkModel, $recursive);
  //     } elseif ($type === 'hasAndBelongsToMany') {
  //       $ins = $fetch = array();
  //       foreach ($resultSet as &$result) {
  //         if ($in = $this->insertQueryData('{$__cakeID__$}', $result, $association, $assocData, $model, $linkModel, $stack)) {
  //           $ins[] = $in;
  //         }
  //       }
  //       if (!empty($ins)) {
  //         $ins = array_unique($ins);
  //         if (count($ins) > 1) {
  //           $query = str_replace('{$__cakeID__$}', '(' . implode(', ', $ins) . ')', $query);
  //           $query = str_replace('= (', 'IN (', $query);
  //         } else {
  //           $query = str_replace('{$__cakeID__$}', $ins[0], $query);
  //         }
  //         $query = str_replace(' WHERE 1 = 1', '', $query);
  //       }

  //       $foreignKey = $model->hasAndBelongsToMany[$association]['foreignKey'];
  //       $joinKeys = array($foreignKey, $model->hasAndBelongsToMany[$association]['associationForeignKey']);
  //       list($with, $habtmFields) = $model->joinModel($model->hasAndBelongsToMany[$association]['with'], $joinKeys);
  //       $habtmFieldsCount = count($habtmFields);
  //       $q = $this->insertQueryData($query, null, $association, $assocData, $model, $linkModel, $stack);

  //       if ($q !== false) {
  //         $fetch = $this->fetchAll($q, $model->cacheQueries);
  //       } else {
  //         $fetch = null;
  //       }


  //       /*for ($i = 0; $i < $count; $i++) {
  //         if ($in = $this->insertQueryData('{$__cakeID__$}', $resultSet[$i], $association, $assocData, $model, $linkModel, $stack)) {
  //           $ins[] = $in;
  //         }
  //       }

  //       $foreignKey = $model->hasAndBelongsToMany[$association]['foreignKey'];
  //       $joinKeys = array($foreignKey, $model->hasAndBelongsToMany[$association]['associationForeignKey']);
  //       list($with, $habtmFields) = $model->joinModel($model->hasAndBelongsToMany[$association]['with'], $joinKeys);
  //       $habtmFieldsCount = count($habtmFields);

  //       if (!empty($ins)) {
  //         $fetch = array();
  //         $ins = array_chunk($ins, 1000);
  //         foreach ($ins as $i) {
  //           $q = str_replace('{$__cakeID__$}', '(' . implode(', ', $i) .')', $query);
  //           $q = str_replace('= (', 'IN (', $q);
  //           $q = str_replace('  WHERE 1 = 1', '', $q);

  //           $q = $this->insertQueryData($q, null, $association, $assocData, $model, $linkModel, $stack);
  //           if ($q != false) {
  //             $res = $this->fetchAll($q, $model->cacheQueries, $model->alias);
  //             $fetch = array_merge($fetch, $res);
  //           }
  //         }
  //       }*/
  //     }

  //     for ($i = 0; $i < $count; $i++) {
  //       $row =& $resultSet[$i];

  //       if ($type !== 'hasAndBelongsToMany') {
  //         $q = $this->insertQueryData($query, $resultSet[$i], $association, $assocData, $model, $linkModel, $stack);
  //         if ($q != false) {
  //           $fetch = $this->fetchAll($q, $model->cacheQueries, $model->alias);
  //         } else {
  //           $fetch = null;
  //         }
  //       }

  //       if (!empty($fetch) && is_array($fetch)) {
  //         if ($recursive > 0) {

  //           foreach ($linkModel->__associations as $type1) {
  //             foreach ($linkModel->{$type1} as $assoc1 => $assocData1) {

  //               $deepModel =& $linkModel->{$assoc1};
  //               if (($type1 === 'belongsTo') || ($deepModel->alias === $model->alias && $type === 'belongsTo') || ($deepModel->alias != $model->alias)) {
  //                 $tmpStack = $stack;
  //                 $tmpStack[] = $assoc1;
  //                 if ($linkModel->useDbConfig == $deepModel->useDbConfig) {
  //                   $db =& $this;
  //                 } else {
  //                   $db =& ConnectionManager::getDataSource($deepModel->useDbConfig);
  //                 }
  //                 $db->queryAssociation($linkModel, $deepModel, $type1, $assoc1, $assocData1, $queryData, true, $fetch, $recursive - 1, $tmpStack);
  //               }
  //             }
  //           }
  //         }
  //         if ($type == 'hasAndBelongsToMany') {
  //           $merge = array();
  //           foreach($fetch as $j => $data) {
  //             if (isset($data[$with]) && $data[$with][$foreignKey] === $row[$model->alias][$model->primaryKey]) {
  //               if ($habtmFieldsCount > 2) {
  //                 $merge[] = $data;
  //               } else {
  //                 $merge[] = Set::diff($data, array($with => $data[$with]));
  //               }
  //             }
  //           }
  //           if (empty($merge) && !isset($row[$association])) {
  //             $row[$association] = $merge;
  //           } else {
  //             $this->_mergeAssociation($resultSet[$i], $merge, $association, $type);
  //           }
  //         } else {
  //           $this->_mergeAssociation($resultSet[$i], $fetch, $association, $type);
  //         }
  //         $resultSet[$i][$association] = $linkModel->afterfind($resultSet[$i][$association]);

  //       } else {
  //         $tempArray[0][$association] = false;
  //         $this->_mergeAssociation($resultSet[$i], $tempArray, $association, $type);
  //       }
  //     }
  //   }
  // }

/**
   * Genera un array representando una sentencia o parte de una sentencia de un sólo modelo o dos modelos
   * asociados.
   *
   * @param  Model  $model       [description]
   * @param  [type] $linkModel   [description]
   * @param  [type] $type        [description]
   * @param  [type] $association [description]
   * @param  [type] $assocData   [description]
   * @param  [type] $queryData   [description]
   * @param  [type] $external    [description]
   * @param  [type] $resultSet   [description]
   * @return [type]              [description]
   */
  public function generateAssociationQuery(Model $model, $linkModel, $type, $association, $assocData, &$queryData, $external, &$resultSet) {
    $queryData = $this->_scrubQueryData($queryData);
    $assocData = $this->_scrubQueryData($assocData);
    $modelAlias = $model->alias;

    if (empty($queryData['fields'])) {
      $queryData['fields'] = $this->fields($model, $modelAlias);
    } elseif (!empty($model->hasMany) && $model->recursive > -1) {
      $assocFields = $this->fields($model, $modelAlias, array("{$modelAlias}.{$model->primaryKey}"));
      $passedFields = $queryData['fields'];
      if (count($passedFields) === 1) {
        if (strpos($passedFields[0], $assocFields[0]) === false && !preg_match('/^[a-z]+\(/i', $passedFields[0])) {
          $queryData['fields'] = array_merge($passedFields, $assocFields);
        } else {
          $queryData['fields'] = $passedFields;
        }
      } else {
        $queryData['fields'] = array_merge($passedFields, $assocFields);
      }
      unset($assocFields, $passedFields);
    }

    if ($linkModel === null) {
      return $this->buildStatement(
        array(
          'fields' => array_unique($queryData['fields']),
          'table' => $this->fullTableName($model),
          'alias' => $modelAlias,
          'limit' => $queryData['limit'],
          'offset' => $queryData['offset'],
          'joins' => $queryData['joins'],
          'conditions' => $queryData['conditions'],
          'order' => $queryData['order'],
          'group' => $queryData['group'],
          'connect' => $queryData['connect']
        ),
        $model
      );
    }
    if ($external && !empty($assocData['finderQuery'])) {
      if (!empty($assocData['conditions'])) {
        $conditions = $this->conditions($assocData['conditions'], true, false, $model);
        return str_replace('{$__conditions__$}', $conditions, $assocData['finderQuery']);
      } else {
        return str_replace('{$__conditions__$}', ' 1 = 1', $assocData['finderQuery']);
      }
      return $assocData['finderQuery'];
    }

    $self = $model->name === $linkModel->name;
    $fields = array();

    if ($external || (in_array($type, array('hasOne', 'belongsTo')) && $assocData['fields'] !== false)) {
      $fields = $this->fields($linkModel, $association, $assocData['fields']);
    }
    if (empty($assocData['offset']) && !empty($assocData['page'])) {
      $assocData['offset'] = ($assocData['page'] - 1) * $assocData['limit'];
    }
    $assocData['limit'] = $this->limit($assocData['limit'], $assocData['offset']);

    switch ($type) {
      case 'hasOne':
      case 'belongsTo':
        $conditions = $this->_mergeConditions(
          $assocData['conditions'],
          $this->getConstraint($type, $model, $linkModel, $association, array_merge($assocData, compact('external', 'self')))
        );

        if (!$self && $external) {
          foreach ($conditions as $key => $condition) {
            if (is_numeric($key) && strpos($condition, $modelAlias . '.') !== false) {
              unset($conditions[$key]);
            }
          }
        }

        if ($external) {
          $query = array_merge($assocData, array(
            'conditions' => $conditions,
            'table' => $this->fullTableName($linkModel),
            'fields' => $fields,
            'alias' => $association,
            'group' => null
          ));
          $query += array('order' => $assocData['order'], 'limit' => $assocData['limit']);
        } else {
          $join = array(
            'table' => $linkModel,
            'alias' => $association,
            'type' => isset($assocData['type']) ? $assocData['type'] : 'LEFT',
            'conditions' => trim($this->conditions($conditions, true, false, $model))
          );
          $queryData['fields'] = array_merge($queryData['fields'], $fields);

          if (!empty($assocData['order'])) {
            $queryData['order'][] = $assocData['order'];
          }
          if (!in_array($join, $queryData['joins'])) {
            $queryData['joins'][] = $join;
          }
          return true;
        }
      break;
      case 'hasMany':
        $assocData['fields'] = $this->fields($linkModel, $association, $assocData['fields']);
        if (!empty($assocData['foreignKey'])) {
          $assocData['fields'] = array_merge($assocData['fields'], $this->fields($linkModel, $association, array("{$association}.{$assocData['foreignKey']}")));
        }
        $query = array(
          'conditions' => $this->_mergeConditions($this->getConstraint('hasMany', $model, $linkModel, $association, $assocData), $assocData['conditions']),
          'fields' => array_unique($assocData['fields']),
          'table' => $this->fullTableName($linkModel),
          'alias' => $association,
          'order' => $assocData['order'],
          'limit' => $assocData['limit'],
          'group' => null,
          'connect' => $queryData['connect']
        );

      break;
      case 'hasAndBelongsToMany':
        $joinFields = array();
        $joinAssoc = null;

        if (isset($assocData['with']) && !empty($assocData['with'])) {
          $joinKeys = array($assocData['foreignKey'], $assocData['associationForeignKey']);
          list($with, $joinFields) = $model->joinModel($assocData['with'], $joinKeys);

          $joinTbl = $model->{$with};
          $joinAlias = $joinTbl;

          if (is_array($joinFields) && !empty($joinFields)) {
            $joinAssoc = $joinAlias = $model->{$with}->alias;
            $joinFields = $this->fields($model->{$with}, $joinAlias, $joinFields);
          } else {
            $joinFields = array();
          }
        } else {
          $joinTbl = $assocData['joinTable'];
          $joinAlias = $this->fullTableName($assocData['joinTable']);
        }
        $query = array(
          'conditions' => $assocData['conditions'],
          'limit' => $assocData['limit'],
          'table' => $this->fullTableName($linkModel),
          'alias' => $association,
          'fields' => array_merge($this->fields($linkModel, $association, $assocData['fields']), $joinFields),
          'order' => $assocData['order'],
          'group' => null,
          'joins' => array(array(
            'table' => $joinTbl,
            'alias' => $joinAssoc,
            'conditions' => $this->getConstraint('hasAndBelongsToMany', $model, $linkModel, $joinAlias, $assocData, $association)
          )),
          'connect' => $queryData['connect']
        );
      break;
    }
    if (isset($query)) {
      return $this->buildStatement($query, $model);
    }
    return null;
  }

/**
   * Construye y genera la sentencia SQL desde un arreglo. Soporta la clausula connect.
   *
   * @param array $query An array defining an SQL query
   * @param Model $model The model object which initiated the query
   * @return string An executable SQL statement
   * @see DboSource::renderStatement()
   */
  public function buildStatement($query, $model) {
    //debug($query['joins']);
    $query = array_merge($this->_queryDefaults, $query);
    if (!empty($query['joins'])) {
      $count = count($query['joins']);
      for ($i = 0; $i < $count; $i++) {
        if (is_array($query['joins'][$i])) {
          /**
           * Si el join incluye la opción 'fields', se concatenarán a los campos que ya se encuentran en $query.
           */
          $join = $query['joins'][$i];
          if (!empty($join['fields'])) {
            $query['fields'] = array_merge($query['fields'], $join['fields']); // Aquí concatena
            unset($join['fields']);
          }
          $query['joins'][$i] = $this->buildJoinStatement($join);
        }
      }
    }

       if(empty($query['connect'])){
      $query['connect'] =array();
    }

    //debug($query['joins']);
    return $this->renderStatement('select', array(
      'conditions' => $this->conditions($query['conditions'], true, true, $model),
      'fields' => implode(', ', $query['fields']),
      'table' => $query['table'],
      'alias' => $this->alias . $this->name($query['alias']),
      'order' => $this->order($query['order'], 'ASC', $model),
      'limit' => $this->limit($query['limit'], $query['offset']),
      'joins' => implode(' ', $query['joins']),
      'group' => $this->group($query['group'], $model),
      'connect' => $this->connectBy($query['connect'], $model)
    ));
  }

  /**
   * Soporte para la clausula connect by en ORACLE.
   * @param  array  $data  [description]
   * @param  [type] $model [description]
   * @return [type]        [description]
   */
  public function connectBy($data = array(), $model = null) {
    if ($data) {
      return (!empty($data['start with']) ?
        ' START WITH ' . $data['start with'] : '') . ' CONNECT BY ' . $data['by'];
    }
    return null;
  }

  /**
   * Helper privado que elimina datos extra del array. Soporte para clausula connect.
   *
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  protected function _scrubQueryData($data) {
    static $base = null;
    if ($base === null) {
      $base = array_fill_keys(array('conditions', 'fields', 'joins', 'order', 'limit', 'offset', 'group', 'connect'), array());
      $base['callbacks'] = null;
    }
    return (array)$data + $base;
  }

/**
 * Generate a "drop table" statement for the given Schema object
 *
 * @param object $schema An instance of a subclass of CakeSchema
 * @param string $table Optional.  If specified only the table name given will be generated.
 *            Otherwise, all tables defined in the schema are generated.
 * @return string
 */
  public function dropSchema(CakeSchema $schema, $table = null) {
    if (!is_a($schema, 'CakeSchema')) {
      trigger_error(__('Invalid schema object', true), E_USER_WARNING);
      return null;
    }
    $out = '';

    foreach ($schema->tables as $curTable => $columns) {
      if (!$table || $table == $curTable) {
        $out .= 'DROP TABLE ' . $this->fullTableName($curTable) . "\n";
      }
    }
    return $out;
  }

  public function hasResult() {
    return get_resource_type($this->_statementId) === 'oci8 statement';
  }
}