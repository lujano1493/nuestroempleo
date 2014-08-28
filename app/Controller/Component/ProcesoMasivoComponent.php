<?php
require_once(ROOT . DS . 'vendor' . DS . 'phpoffice' . DS . 'phpexcel'. DS . 'Classes' . DS . 'PHPExcel'.DS.'IOFactory.php');
/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class ProcesoMasivoComponent extends Component {

  /**
   * [$components description]
   * @var array
   */
  public $components = array('Auth', 'Session');

  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->request->params;
  }

  public function startup(Controller $controller) {    
  }

  private $function=array(
    'masivos_candidato'
    );



  public function file_render($render,$file ){    
    if(in_array($render,$this->function) ){
      return $this->{$render}($file);
    }
    else{
        $this->controller->error(__("No existe proceso a ejecutarse."));
    }

    return false;
  }

  protected function masivos_candidato($file) {
        $layout=array(
          "exp" => array(
                  "/([a-zA-Z0-9_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4}(.[a-zA-Z]{2,3})?)/i"
                ) ,
          "msg_error" => array(
                "formato de correo incorrecto."
            ),
          'num_columns' => 1,
          'process' => array(
              "name_model" => "CorreoProceso",
              "fields" =>array(
                  "correo"
                )
            ) 
          
        );        
      return $file->type==='text/plain' ?  $this->fromTextplan($file->name,$layout) : $this->fromExcel($file->name,$layout);

  }


  private function fromTextplan($name=null,$layout=array()){ 
    $path= WWW_ROOT."temporales".DS.$name;
    $str=file_get_contents($path);
    if( $str===false){
      $this->controller->error(__("Error al procesar archivo"));
      return false;
    }    
    unlink($path);
    $str=trim($str);
    $str_line= explode("\n",$str);
    $txt_error="";
    $flag_error=false;
    $process=$layout['process'];
    $p_model=ClassRegistry::init($process['name_model']);
    $idProceso=$p_model->getIdProceso();

    $p_model->begin();
    foreach ($str_line as $number_line => $line) {
      $line=trim($line);
      if(empty($line)){
        continue;
      }
      $columns=explode("\t",$line);
      if(count($columns) !== $layout['num_columns'] ){
          $line_n=$number_line+1;
          $txt_error=__("error en linea [$line_n]: verifica el numero de columnas deben ser $layout[num_columns]");
          $flag_error=true;
          break;
      }

     
      $array_save=array("proceso_cve" => $idProceso);
      foreach ($columns as $num_column => $value) {         
        if( preg_match($layout['exp'][$num_column],$value ) ){
            $array_save[  $process['fields'][$num_column]  ]=$value;
        }
        else{
          $line_n=$number_line+1;
          $column_n=$num_column+1;
          $txt_error=__("error en linea [$line_n] columna [$column_n] :". $layout['msg_error'][$num_column] ." $value " );
          $flag_error=true;
          break;
        }
      }
      if(!$flag_error){
        $p_model->create();
        $p_model->save( $array_save );  
      }
      else{
          break;
      }
      
    }
    if($flag_error){
      $p_model->rollback();
      $this->controller->error($txt_error);
    }
    else{
      $p_model->commit();
    }
    return $flag_error ? false: $idProceso;
  }

  private function fromExcel($name=null,$layout=array()){
    $path= WWW_ROOT."temporales".DS.$name;

        //  Read your Excel workbook
    try {
        $inputFileType = PHPExcel_IOFactory::identify($path);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($path);
    } catch(Exception $e) {
      $this->controller->error(__("Error al procesar el archivo excel, intentelo más tarde."));
        return false;
    }
    //  Get worksheet dimensions
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn =   PHPExcel_Cell::stringFromColumnIndex($layout['num_columns'] -1);   //$sheet->getHighestColumn();
    $txt_error="";
    $flag_error=false;
    $process=$layout['process'];
    $p_model=ClassRegistry::init($process['name_model']);
    $idProceso=$p_model->getIdProceso();
    $p_model->begin();
    //  Loop through each row of the worksheet in turn
    for ($row = 1; $row <= $highestRow; $row++){ 
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                        NULL,
                                        TRUE,
                                        FALSE);
        
        if( empty($rowData ) || empty( $rowData[0] ) ){
            $this->controller->error(__("Error en la linea [$row]"));
            return false;
        }
        $rowData=$rowData[0]; 
        $num=count( $rowData );
        $flag_error=false;
        $array_save=array("proceso_cve" => $idProceso);
        $msg_error='';
        foreach (  $rowData as $j => $value   ) {    
          if(empty($value)){
            $column=  PHPExcel_Cell::stringFromColumnIndex($j); 
            $txt_error=__("Error en el renglon [{$row}{$column}] : Esta vacío." );
            $flag_error=true;
            break;
          }

          if( preg_match($layout['exp'][$j ],$value ) ){
            $array_save[  $process['fields'][$j]  ]=$value;
          }
          else{
            $column=  PHPExcel_Cell::stringFromColumnIndex($j); 
            $txt_error=__("Error en el renglon [{$row}{$column}] :". $layout['msg_error'][ $j] ." ($value) " );
            $flag_error=true;
            break;
          }
        }            
        if(!$flag_error){
          $p_model->create();
          $p_model->save( $array_save );  
        }
        else{
          break;
        }
    }
    unlink($path);
    if($flag_error){
      $p_model->rollback();
      $this->controller->error($txt_error);
    }
    else{
      $p_model->commit();
    }
    return $flag_error ? false: $idProceso;    
  }
  


}