<?php



class UploadsController extends AppController {
	public $name = 'Uploads';
  public $helpers = array(
    'Cropimage',
    'VisualCaptcha'
  );

  public $components = array(
    'JqImgcrop',
    'VisualCaptcha',
    'Upload'
  );

  public $uses = array('Candidato');

  public $useTable = false;

  public function index() {
    $this->autoRender = false;
  }

  public function upload($param = null) {
    $this->autoRender = false;
    $this->Upload->upload();
    if ($param != null && $param == 'save') {
      //ClassRegistry::init('DocxCan')
    }
  }

	public function delete() {
    $this->autoRender = false;    
    if($this->request->query('file')){
      $this->Upload->upload();
    }
    if( isset($this->user['candidato_cve'] )){
       $id=$this->user['candidato_cve'];
        $path=WWW_ROOT . "/documentos/candidatos/$id/foto.jpg";
        if(file_exists(  $path )){
          unlink($path);
        }
    }
   

  }

  public function imageSave() {
    $this->autoRender = false;
  }

  public function imageCrop_step_1() {
    $this->autoRender = false;

    if (!empty($this->data)) {
      $uploaded = $this->JqImgcrop->uploadImage($this->data['photo'], '/img/upload/', '');
    } else{
      $uploaded = array("sts"=>"error","msg"=>"petición vacia");
    }
    echo json_encode(array("0"=>$uploaded ));
  }


  public function server($php) {
    $this->autoRender = false;
    error_reporting(E_ALL | E_STRICT);
    $upload_handler = new UploadHandler();
  }

  public function pruebaCrop() {
    $user=$this->Auth->user();
    $path= Funciones::check_picture($user['persona_cve'],$this->webroot);
    $this->set("inicio", true);
    $this->set("mensaje", "");
    $this->layout = "sube_imagen";
    $this->set("path_image", $path);
  }

  public function createimage_step2() {
    $this->layout = 'sube_imagen';
    if (!empty($this->data)) {
      $uploaded = $this->JqImgcrop->uploadImage($this->data['ImageCrop']['image'], '/img/upload/', '');
      if ($uploaded === false) {
        $this->set('inicio', true);
        $this->set('mensaje', 'Error al intentar subir la imagen asegurese que el archivo sea de una extension conocida');
      } else {
        $this->set('subido', true);
      }
      $this->set('uploaded',$uploaded);
    }
  }

  /**
   * [cropimage description]
   * @return [type] [description]
   */
	public function cropimage() {
		$this->autoRender = false;
		$data = $this->request->data;
		$file_img = 'temporales' . DS . $data['img_info']['name'];

		$result=$this->JqImgcrop->cropImage(250,
      $this->data['x'],
      $this->data['y'],
      $this->data['x2'],
      $this->data['y2'],
      $this->data['w'],
      $this->data['h'],
      $file_img,
      $file_img
    );

    $filename = 'foto.jpg';
		$imagePath = $file_img;
		$path = substr($this->webroot, 0, strlen($this->webroot) - 1);

		$user = $this->Auth->user();

    /**
     * Dependiendo del rol del usuario logueado, guardará en la carpeta que
     * le corresponde.
     */
    if ($this->Acceso->is() === 'empresa') {
      $folder = DS . 'documentos' . DS . 'empresas' . DS . $user['Empresa']['cia_cve'];
      $filename = 'logo.jpg';
      $this->Session->write('Auth.User.Empresa.logo', $folder . DS . $filename . '?version=' . time());
    } else {
      $folder = DS . 'documentos' . DS . 'candidatos' . DS . $user['candidato_cve'];

      $doccan= $this->Candidato->DocCanFoto;
      $doccan->tipo_doc = '1';
      $doccan->is_fotoperfil = true;
      /*tipo de archivo jpeg*/
      $tipo = '1';

      $doccan->recursive = -1;

      /*realizamos consulta*/
      $rs=$doccan->findByCandidatoCveAndTipodocCve($user['candidato_cve'], $tipo);

      /*verificamos si la fotografia que vamos a subir es nueva o se  va actualizar :P*/
      if(!empty($rs[$doccan->alias])){
        $doccan->id = $rs[$doccan->alias][$doccan->primaryKey];
      } else {
        $doccan->create();
      }
      $doccan->save(array(
        'candidato_cve' => $user['candidato_cve'],
        'tipodoc_cve' => $tipo,
        'docscan_descrip' => 'Fotografía de candidato',
        'docscan_nom' => 'foto'
      ));
    }

		$current_file = "/" . $file_img;
		$new_file = $folder . "/" . substr($imagePath, strrpos($imagePath, "/") + 1);
		$this->JqImgcrop->moveImage($folder, $current_file, $filename);
		$imagePath = $new_file;

		echo json_encode(array(
      "file_img" => $folder. "/" . $filename
    ));
	}

  public function admin_cropimage($empresaId, $empresaSlug = null) {
    $this->autoRender = false;
    $data = $this->request->data;
    $file_img = 'temporales' . DS . $data['img_info']['name'];

    $result=$this->JqImgcrop->cropImage(250,
      $this->data['x'],
      $this->data['y'],
      $this->data['x2'],
      $this->data['y2'],
      $this->data['w'],
      $this->data['h'],
      $file_img,
      $file_img
    );

    $filename = 'foto.jpg';
    $imagePath = $file_img;
    $path = substr($this->webroot, 0, strlen($this->webroot) - 1);

    $folder = DS . 'documentos' . DS . 'empresas' . DS . $empresaId;
    $filename = 'logo.jpg';

    $current_file = "/" . $file_img;
    $new_file = $folder . "/" . substr($imagePath, strrpos($imagePath, "/") + 1);
    $this->JqImgcrop->moveImage($folder, $current_file, $filename);
    $imagePath = $new_file;

    echo json_encode(array(
      "file_img" => $folder. "/" . $filename
    ));
  }

	public function getCandidato(){
		$this->autoRender = false;
		if ($this->Session->check('usu.candidato')) {
			$candidato=$this->Session->read('usu.candidato');
			echo json_encode($candidato);
		} else {
			echo json_encode(array());
		}
	}


/*refrecamos el captcha imagen jojojo*/

  public function refresh_captcha_image($frm=null){
    $this->autoRender=false;
    $this->VisualCaptcha->show();

  }

  public function image_captcha(){
    $this->autoRender = false;

    if ( ! isset($_GET['i']) ) {
      $_GET['i'] = 0;
    } else {
      $_GET['i'] = (int) $_GET['i'];
      --$_GET['i'];
    }

    if ( isset($_GET['retina']) && ! empty($_GET['retina']) ) {
      $getRetina = true;
    } else {
      $getRetina = false;
    }

    $image = $this->VisualCaptcha->getImageFilePath( $_GET['i'], $getRetina );
    $this->response->file($image, array("download" => false, "name" => $_GET['i'] ));
  }

  /**
   * Refresca la imagen del captcha.
   * @return [type] [description]
   */
  public function refresh_captcha() {

		$this->autoRender = false;
		$path= APP . 'Vendor' . DS . 'captcha';
		$string = '';

		for ($i = 0; $i < 5; $i++) {
			$string .= chr(rand(65, 90));
		}

		$dir = $path . DS . 'fonts' . DS;
		$this->Session->write('captcha_1', $string);
		$image = imagecreatetruecolor(165, 50);
		// random number 1 or 2
		$num = rand(1, 2);
		if($num==1) {
			$font = "Capture it 2.ttf"; // font style
		} else {
			$font = "Molot.otf";// font style
		}

		// random number 1 or 2
		$num2 = rand(1,2);
		if ($num2==1) {
			$color = imagecolorallocate($image, 113, 193, 217);// color
		} else {
			$color = imagecolorallocate($image, 163, 197, 82);// color
		}

    // $transparent = imagecolorallocatealpha($image, 255,0,0, 100 );

		$delta  = imagecolorallocate($image, 245, 245, 245); // background color white
		imagefilledrectangle($image,0,0,165,55,$delta );
		imagettftext ($image, 30, 0, 10, 40, $color, $dir.$font, $this->Session->read('captcha_1'));
    $file = 'temporales' . DS . 'captcha.png';
    imagepng($image,$file);
    imagedestroy($image);
    $this->response->file($file, array(
      'download' => false,
      'name' => $this->Session->read('captcha_1')
    ));
	}


  public function validate_captcha_image(){
    return $visualCaptcha->isValid();
  }

  /**
   * Valida el captcha.
   * @return [type] [description]
   */
  public function validate_captcha(){
  	$this->autoRender = false;
  	$valido = false;
  	if(empty($this->request->query)) {
  		$valido=false;
  	} else if($this->Session->read('captcha_1') == $this->request->query['data']['Candidato']['codigo']){
  		$valido = true;
  	}
  	echo json_encode($valido);
  }


  function prueba_guardar(){
  		$this->autoRender=false;
  		$this->Candidato->save( array ( "Candidato"=> array ("id"=>"","nombre"=>"GERALDO","apellidom"=>"VISUET","filename"=>"ARCHIVOS" )  ));

  }
  function imprime(){
  	$this->autoRender=false;
  	$prueba=WWW_ROOT."prueba";
  	$prueba=substr ($prueba,strrpos($prueba,DS)+1);
  	echo $prueba."<br/>";
  	echo substr( WWW_ROOT,0,strlen(WWW_ROOT)-1);
  	//mkdir("C:\\xampp\\htdocs\\NuestroEmpleo2_0\\app\\webroot\\Candidatos\\candidato_2");

  }

	/**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();

    /**
      * Acciones que no necesitan autenticación.
      */
    $this->Auth->allow("refresh_captcha","validate_captcha","image_captcha","refresh_captcha_image");
  }
}