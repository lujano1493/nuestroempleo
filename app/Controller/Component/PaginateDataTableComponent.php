<?php
 
App::uses('Component', 'Controller');

/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class PaginateDataTableComponent extends Component {

  private $data_params=array(
            "sEcho",
            "iColumns",
            "sColumns",
            "iDisplayStart",
            "iDisplayLength",
            "mDataProp_0",
            "sSearch",
            "bRegex",
            "sSearch_0",
            "bRegex_0",
            "bSearchable_0",
            "iSortCol_0",
            "sSortDir_0",
            "iSortingCols",
            "bSortable_0"
    );
  
 
  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->params;
  }


  public function paginate($data,$param=array()){
        $iTotal=count($data);

        $start=$param["iDisplayStart"];
        $end=$param["iDisplayLength"];
        $iFilteredTotal=0;
        $info=array();
        $start =     $start > $iTotal  ? 0 : $start;
        for ($i=$start;$i<$iTotal && $i<  ($start+$end) ;$i++) {
            $info[]=$data[$i];
          $iFilteredTotal++;
         
        }

        



        return array(
            "sEcho" => intval($param['sEcho']),
            "iTotalRecords" => $iFilteredTotal,
            "iTotalDisplayRecords" => $iTotal,
            "data" => $info
        );

  }



}