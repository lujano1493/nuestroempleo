<?php

App::import('Utility', array('Utilities','Security'));
App::import('Vendor',array('funciones'));
App::import('controller', 'BaseCandidato');

class BusquedaOfertaController extends BaseCandidatoController {
    public $name = 'BusquedaOferta';
    public $uses=array("OfertaB","OfertaBE"); 

    public $helpers = array( "OfertasB" );
    private function  data_filtro(){
         $conditions=array();
        $param_query=array();
        $params_name=array(
                            "tipo",
                            "escolaridad",
                            "genero",
                            "estado_civil",
                            "disponibilidad",
                            "sueldo",
                            "ciudad",
                            "publicacion",
                            "estado",
                            "area",
                            "categoria"

          );
        $datos_agrupados=false;
        if($this->request->is("Get") ){
            // debug($this->request->query);            
           $param_query=$this->request->query;
           $datos_agrupados=  $this->OfertaB->agrupar($param_query);
        }
        $this->set(compact("conditions","param_query","datos_agrupados","params_name"));


    }

    private function ofertas_($status=1){
    $datos=array();
      if($this->request->is("Get") ){      
              $options_=array(
              'params' => $this->request->query,
              'is_group' => false,
              'search_acum' =>false,
              'conditions' => array("oferta_status" =>  array( $status))
            );
             $datos=  $this->OfertaB->realizar($options_);
      }
    $this->set(compact("datos"));
    }
    public function destacadas(){
      $this->ofertas_(3);
      $this->render("ofertas_");
    }
    public function recomendadas(){
      $this->ofertas_(2);
      $this->render("ofertas_");
    }


    public function autocomplete(){



    }


    public function index( ){
     $this->data_filtro();
     /*genarar hisotrial de busquedas */
    $data=$this->request->query;
          if( !isset($data['busqueda_avanzada'])   &&  isset($data['dato']) && !empty($data['dato']) ){
                  $dato=$this->request->query['dato'];
                  $historial_busqueda_oferta=$this->Session->read("historial_busqueda_oferta");
                 if  (!$historial_busqueda_oferta ){

                       $count=1;
                       $datos=array(
                                        $dato
                        );
                 }
                 else{  
                        $count=$historial_busqueda_oferta['count'];
                        $datos=$historial_busqueda_oferta['datos'];

                          /*si no se encuetra en el arreglo*/
                        if(!in_array($dato, $datos)){

                            if($count >5){
                              $count=1;
                            }
                            $datos[$count]=$dato;
                            $count++;

                        }


                      

                 }
                 $this->Session->write("historial_busqueda_oferta",  array(
                                                                      "count" => $count,
                                                                      "datos"=>$datos  
                  ));

          }

    }
    public  function filtros(){
          $this->data_filtro();

    }
    public function ofertas(){

        $conditions=array();
        $data=$this->OfertaB->realizar(array("params" =>$this->request->query));  

        $this->set(compact("data"));        

    }

  public function beforeFilter(){
    parent::beforeFilter();
    $this->Auth->allow();  
      $this->OfertaB->micrositio=$this->micrositio;

  }

} 