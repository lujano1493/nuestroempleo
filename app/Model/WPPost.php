<?php
App::import("Vendor",array( "simple_html_dom","funciones" ));
	class WPPost extends AppModel {
	public $name='WPPost';
	public $useTable = 'wp_posts'; 
	public $primaryKey="id";	
  	public $useDbConfig = 'wordpress';
  	public $actsAs = array('Containable');


	public $findMethods = array(
	    'articulos'    => true
	  );


	public $hasMany=array(
			  'PostMeta' =>    array(
			      	  'className'=> 'WPPostMeta',
				        'foreignKey'   => 'post_id'
				       )
		);

	public $joins=array(
		'articulos_candidato' =>	 array(
						  array(
					        'alias' => 'wptermrelation',
					        'fields' => array( ),
					        'conditions' => array(
					          'wptermrelation.object_id = WPPost.id'
					        ),
					        'table' => 'wp_term_relationships',
					        'type' => 'INNER'
					      ),
					      array(
					        'alias' => 'wptaxoterms',
					        'conditions' => array(
					          'wptaxoterms.term_taxonomy_id = wptermrelation.term_taxonomy_id'
					        ),
					        'fields' => array(),
					        'table' => 'wp_term_taxonomy',
					        'type' => 'INNER'
					      ),
					      array(
					        'alias' => 'wpterms',
					        'conditions' => array(
					          'wpterms.term_id = wptaxoterms.term_id'
					        ),
					        'fields' => array(),
					        'table' => 'wp_terms',
					        'type' => 'INNER'
					      ),



				)

			


		);


	public function articulos_detalles($id,$tipo='Candidatos'){
		$rs=$this->find("articulos",array(
											   "idArticulo" => $id,
											   "tipo_articulo"=>"all"
											  ));

		$result=array();

		foreach ($rs as $value) {
			$info=$value[$this->alias];


			$html= str_get_html($info['post_content'] );

			$img=$html->find("img");

			$src=false;

			if( count($img)>0 ){
				$src= $img[0]->src;
			}			
			$html->clear();
			$result[]=array(								
								'guid' => $info['guid'],
								'title' => $info['post_title'],
								'content_text' =>  strip_tags($info['post_content']) ,
								'content_html' => $info['post_content'],
								"img_src" => $src
				);


		}
		return count($result)>0 ? $result[0] :$result ;
	}


	public function  articulos_liga($limit=null,$tipo='Candidatos',$date=null){
		$options=array();
		if($limit){

			if(!is_array($limit)){
				$options['limit'] = $limit;	
			}
			else{
				$options['limit']=$limit['iDisplayStart'];
				$options['offset']=$limit['iDisplayLength'];
			}
			
		}
		if($date){
			$options['date'] = $date;
		}
		$options['tipo_articulo']=$tipo;

		$result= $this->find("articulos",$options);
		$articulos=array();
		foreach ($result as $index	 => $value) {
			$info=$value[$this->alias];
			// (https?|s?ftp):\/\/

			// if ( preg_match("<img[>]*   >", $value['post_content'], $matches)) {      
          		
   //      		}

			$html= str_get_html($info['post_content'] );

			$img=$html->find("img");

			$src="";
			$parrafo="";

			if( count($img)>0 ){
					$src= $img[0]->src;
			}

			$descrip=Funciones::quitar_etiquetas($info['post_content']);
			$descrip=Funciones::truncate_str($descrip,  $tipo =='Candidatos' ? 120:240 );
			$articulos[]=array(
									"src" => $src,
									"title" => $info['post_title'],
									"descrip" => $descrip,
									"id" => $info['id'],
									"post_date" => $info['post_date']

				);	
			$html->clear();
		}
		if(is_array($limit)){			
			$this->setConditions($options,true);
		}		
		return !is_array($limit) ? $articulos   : array(
				'iTotalDisplayRecords' =>  $this->find("count",$options),	
				'iTotalRecords' =>		 count($articulos),	
				"data" =>$articulos
			)  ;

	}



 	
  	  protected function _findArticulos($state, $query, $results = array()) {
    if ($state == 'before') {

    		$this->setConditions($query);

      return $query;
    }

    return $results;
  }


 private function setConditions(&$query,$count=false){
 		$query['joins']=$this->joins['articulos_candidato'];

    	$tipo_articulo= array_key_exists("tipo_articulo",$query) ? $query['tipo_articulo']  :"Candidatos"  ;



    	$conditions=array(				
						"wptaxoterms.taxonomy" => "category" ,
						"$this->alias.post_status" => 'publish'
    		);

    	if($tipo_articulo!="all"){
    		$conditions["wpterms.name" ]=$tipo_articulo;
    	}

    	$query['conditions'] = $conditions;
    	if(array_key_exists("idArticulo",$query)  ){
    		$query['conditions']["$this->alias.id"]= $query['idArticulo'];
    	}
    	if(array_key_exists("date",$query)  ){
    		$query['conditions']["$this->alias.post_date >"]= $query['date'];
    	}

    	 $field_joins = array(
    								"wptaxoterms.taxonomy",
    								"wptaxoterms.description",
    								"wptaxoterms.parent",
    								"wptaxoterms.count",
    								"wpterms.name",
    								"wpterms.slug"
    	);     
    	 if(!$count){
    	 	$query['order'] = array(
    								"$this->alias.post_date DESC"
    							);

	    	$fields=array_merge(
	    	 							$this->fields
	    	 	);	    	 
	    	$query['fields']= $fields;
    	 }

    	$query['contain']= array();    	



 }




  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    
    		$this->fields=array(
    					 "id"                                     ,
						 "post_author"                            ,
						 "post_date"                              ,
						 "post_date_gmt"                          ,
						 "post_title"                             ,
						 "post_content"							  ,
						 "post_excerpt"                           ,
						 "post_status"                            ,
						 "comment_status"                         ,
						 "ping_status"                            ,
						 "post_password"                          ,
						 "post_name"                              ,
						 "to_ping"                                ,
						 "pinged"                                 ,
						 "post_modified"                          ,
						 "post_modified_gmt"                      ,
						 "post_content_filtered"                  ,
						 "post_parent"                            ,
						 "guid"                                   ,
						 "menu_order"                             ,
						 "post_type"                              ,
						 "post_mime_type"                         ,
						 "comment_count"             

    		);
			foreach ($this->fields as $key=> $value) {	
						$this->fields[$key] = "$this->alias.$value" ;
			}
  
  }




}