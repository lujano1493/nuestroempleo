<?php
class EvaCanRes extends AppModel {
  public $name='EvaCanRes';
  public $useTable = 'tevaxcanresp';
  public $primaryKey="evaxcanresp_cve";

  public $belongsTo = array(

  );

  public $hasMany= array(
   
  );

  public $findMethods = array(
    'data'    => true
  );

  protected function _findData($state, $query, $results = array()) {
    if ($state == 'before') {
     
      return $query;
    }
    return $results;
  }



}