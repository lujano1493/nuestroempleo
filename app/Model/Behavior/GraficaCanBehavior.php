<?php 
	class GraficaCanBehavior extends ModelBehavior  {






/*
    public $mapMethods = array('/do(\w+)/' => 'doSomething');

    public function doSomething(Model $model, $method, $arg1, $arg2) {
       		$created true= is created, false= update

       // debug(func_get_args());
        //do something
    }*/

    public function afterSave(Model $model, $created, $options = array()) {			 
    	
            $model_tabla= ClassRegistry::init("TablaGrafCan");
           if(!$model->checkBeforeInsertGrafCan($options)){     
                return true;
            }
    		$tabla=$model_tabla->findByTablaNombre(strtoupper($model->useTable));
            if(!empty($tabla[$model_tabla->alias])){
                $grafCan=ClassRegistry::init("GrafCan");
                $tabla_cve=$tabla[$model_tabla->alias]['tabla_cve'];
                //$Model->data[$Model->alias][$Model->primaryKey]
                /*verificamos que no aya ningun registro previo de la tabla a insertar*/
                //si el dato fue actualizado solo se debe leer la informacion
                
                $data_s=$model->data[$model->alias];
                $candidato_cve=  isset($data_s ['candidato_cve']) ? $data_s['candidato_cve'] : $model->idCandidato  ;

                $rs=$grafCan->findByTablaCveAndCandidatoCve($tabla_cve,$candidato_cve );
                if(empty( $rs[$grafCan->alias] ) ){     
                    //verificamos condiciones para insertar porcentaje en la tabla                                
                    $grafCan->create();     
                    $grafCan->save( array("tabla_cve" => $tabla_cve,"candidato_cve" =>$candidato_cve  ));    

                }

            }        
    	return true ;

    }


public function beforeDelete(Model $model, $cascade = true){    
        $rs=$model->find("first",array("conditions" => array("{$model->alias}.{$model->primaryKey}"=> $model->id   ) ));
        $model->candidato_cve= $rs[$model->alias]['candidato_cve']; 
            
        return true;


    }

public function afterDelete(Model $model){
         $candidato_cve=$model->candidato_cve;
         $model_tabla= ClassRegistry::init("TablaGrafCan");
    	$tabla= $model_tabla->findByTablaNombre(strtoupper($model->useTable));
        if(!empty($tabla[$model_tabla->alias]) ){
            $rs=$model->findByCandidatoCve($candidato_cve);
            if(empty(  $rs[$model->alias]) ){   
               $tabla_cve= $tabla[$model_tabla->alias]['tabla_cve'];
               $grafCan=ClassRegistry::init("GrafCan");   
               $d= $grafCan->findByTablaCveAndCandidatoCve($tabla_cve,$candidato_cve );
               if(!empty($d[$grafCan->alias])){
                    $grafCan->delete($d[$grafCan->alias][$grafCan->primaryKey],false);   
               }    

            }

        }
           
        $model->candidato_cve=null;


    }

    




}

?>