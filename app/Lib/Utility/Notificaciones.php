
<?php

	class Notificaciones {

		public static function notificacion_formato($data=array(),$options=array(),$role='guest',$user=array()){

		   $results=array();
		   if(empty($data)){
		   		return $results;
		   }
		    $tipo= isset($options['tipo']) ? $options['tipo'] :"notificacion";
		    $tn=array(
		                "evento" =>array(
		                                    "name" => "Evento",
		                                    "id" =>"evento_cve",
		                                    "title"=>"evento_nombre",
		                                    "descrip" =>"evento_resena",
		                                    "params" => array(
		                                    					"ciudad_cve",
		                                    					"est_cve"
		                                    					),
		                                	"to_model"=> array(
		                                                        "name" => "Receptor",
		                                                        "id"=> "id" ,
		                                                        "type" => $role ==='empresa' ? '1':'0',
		                                      )

		                  ),
		                "mensaje" =>array(
		                                    "name" => "Mensaje",
		                                    "id" =>"msj_cve",
		                                    "title"=>"msj_asunto",
		                                    "descrip" =>"msj_texto",
		                                    "controller" => array(
		                                        "to_candidato" =>"/mensajeCan/ver",
		                                        "to_empresa" => "/mis_mensajes/ver"
		                                      ),
		                                    "to_model"=> array(
		                                                        "name" => "Receptores",
		                                                        "id"=>"receptor_cve",
		                                                        "type" => "receptor_tipo"
		                                      )
		                  ),
		                "evaluacion" => array(
		                                    "name" => "Evaluacion",
		                                    "id" =>"evaluacion_cve",
		                                    "title"=>"evaluacion_nom",
		                                    "descrip" =>"evaluacion_descrip",
		                                    "controller" => array(
		                                        "to_candidato" =>"/evaluaciones/aplicar",
		                                        "to_empresa" => "/mis_evaluaciones/resultado"
		                                      ),

		                                    "to_model"=> array(
		                                                        "name" => "EvaCan",
		                                                        "id"=> $role ==='empresa' ? 'candidato_cve':'cu_cve',
		                                                        "type" => $role ==='empresa' ? '1':'0',
		                                                        'id_sec' =>  'evaxcan_cve'
		                                      )

		                  ),
		                "notificacion" =>array(
		                                    "name" => "Notificacion",
		                                    "id" =>"id",
		                                    "title"=>"title",
		                                    "descrip" =>"texto",
		                                    "controller" => array(),
		                                    "to_model"=> array(
		                                                        "name" => "Para",
		                                                        "id"=>"id",
		                                                        "type" => "type"
		                                      )
		                  )
		    );
		    $base=$tn[$tipo];
		    $model_name=$base["name"];
		    $data_iter= $data[$model_name];
		    $id=$data_iter[$base['id']];
		    $type=$tipo;
		    $status=isset($base['status']) ? $base['status'] :0 ;
		    $status=isset($options['status'] ) ? $options['status'] :$status ;
		    $title=$data_iter[$base['title']];
		    $descrip=$data_iter[$base['descrip']];
		    $emisor_tipo= $role =='empresa' ? 0:1;
		    $emisor_id= $role=='empresa' ?$user['cu_cve'] :$user['candidato_cve']  ;
		    $emisor_id=  (int) $emisor_id;
		   // $controller = !isset($base['controller']) ?  false : ( $role==='empresa'? $base['controller']['to_candidato']): $base['controller']['to_empresa'];
		    $params=array();
		    if(isset($base["params"])){
		    		foreach ($base["params"] as $param) {
		    			if (!empty($data_iter[$param])) {
		    			 $params[$param] = $data_iter[$param];
		    			}
		    		}
		    }
		    $to=array();
		    if(isset($base['to_model'])){
		      $to_model=$base['to_model'];
		      $arr_to=$data[$to_model['name']];
		        foreach ($arr_to as $iter) {
		          $controller='';
		          $receptor_tipo= isset($iter[$to_model['type']]) ? $iter[$to_model['type']] :$to_model['type'];
		          if(!empty($base['controller'])  ){
		            $controller=$receptor_tipo==0 ? $base['controller']['to_empresa']: $base['controller']['to_candidato'];
		          }

		          else if (!empty($data_iter['controller']) ){
		          		$controller=$data_iter['controller'];
		          }

		          $to[]=array(
		                      "receptor_id" => $iter[$to_model['id']],
		                      "receptor_tipo" =>$receptor_tipo,
		                      'controlador' => $controller ,
		                      "accion" =>  !empty($controller) ? $controller."/".$id : "#"
		            );
		          if( isset($to_model['id_sec']) && !empty($to_model['id_sec']) ){
		              $to[count($to)-1]['id_sec']=$iter[$to_model['id_sec']];
		              $to[count($to)-1]['accion']= $controller  ?   $controller."/".$iter[$to_model['id_sec']] : "#" ;

		          }
		        }
		    }

		    $style=Notificaciones::getStyle($status);
		    $title=Notificaciones::truncate_str($title,60 );
		    $descrip=Notificaciones::quitar_etiquetas($descrip);
		    $descrip=Notificaciones::truncate_str($descrip,255 );
		    $results=compact('id','type','status','style','emisor_id','params','emisor_tipo','title','descrip','to');
		    return $results;
		 }

		 public static function format_ntfy($data=array(),$type='notificacion',$id_key){

		 		// $results=array();

		 		// if($type=='notificacion'){


		 		// }



		 }

		 public static function simple_format($data=array(),$role='guest',$user=array()){

		 		if(empty($data)){
		 				return array();
		 		}

		 	 $data= array(
                    "Notificacion" =>array(
                                          "title" => $data['title'],
                                          "texto"=> "",
                                          "id" => null,
                                          "controller" => false,
                      ),
                      "Para" => array(
                                                        array(
                                                                "id" => $data['id'],
                                                                "type"=>$data['typeUser'],

                                                          )

                                            )
          );
			return	Notificaciones::notificacion_formato($data,array("tipo" =>"notificacion"),$role,$user);

		 }

		 public static function quitar_etiquetas($descrip=""){
					$descrip = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2',$descrip);
				    $descrip=strip_tags( $descrip);
				    return  $descrip;

				}

		public static function truncate_str($string, $length, $stopanywhere=false) {
		    //truncates a string to a certain char length, stopping on a word if not specified otherwise.
		    if (strlen($string) > $length) {
		        //limit hit!
		        $string = substr($string,0,($length -3));
		        if ($stopanywhere) {
		            //stop anywhere
		            $string .= '...';
		        } else{
		            //stop on a word.
		            $string = substr($string,0,strrpos($string,' ')).'...';
		        }
		    }
		    return $string;
		}





		  public static function getStyle($status=0){

		      $colection_=array(
		               0=> array(
		                    "icon"=> "warning-sign",
		                    "clazz"=> "advertencia"
		                    ),
		               1=> array(
		                    "icon"=> "ok-circle",
		                    "clazz"=> "aceptada"
		                    ),
		               2=>array(
		               		'icon' =>"minus-sign",
		               		'clazz' =>'finalizada'
		               	)
		        );

		    return $colection_[$status];

		  }


		}


?>