<?php

App::import('Vendor',array('funciones'));
class ArchivosCanController extends AppController {
		public $name = 'ArchivosCan';
    	public $uses=array("DocCan"); 

    	public function ver($id=null){


			if($id==null&& !$this->user &&!array_key_exists("candidato_cve",$this->user)  ){
					$this->redirect("/");
					$this->error("No es posible realizar acción.");
					return;    					
			}

			$info=$this->DocCan->read(null,$id)["DocCan"];	

			if($info['candidato_cve']!==$this->user['candidato_cve']){
						$this->redirect("/Candidato");
					$this->error("No es posible descargar archivo.");
					return; 

			}

			$path_file=funciones::verdocumento($this->user['candidato_cve'],$info['docscan_nom']);


		$this->autoRender=false;

		if ($path_file) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($path_file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($path_file));
		    ob_clean();
		    flush();
		    readfile($path_file);
		}
		

    	}





	}