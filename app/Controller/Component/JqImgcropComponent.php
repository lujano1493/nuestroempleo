<?php  
class JqImgcropComponent  extends Object { 
	public  $name_file="";
    function uploadImage($uploadedInfo, $uploadTo, $prefix){ 
        $webpath = $uploadTo; 
        $upload_dir = WWW_ROOT.str_replace("/", DS, $uploadTo); 
        $upload_path = $upload_dir.DS; 
        $max_file = "34457280";                         // Approx 30MB 
        $max_width = 400; 
		
        $userfile_name = $uploadedInfo['name']; 
		$name_file=$uploadedInfo['name']; 
        $userfile_tmp =  $uploadedInfo["tmp_name"]; 
        $userfile_size = $uploadedInfo["size"]; 
        $filename = $prefix.basename($uploadedInfo["name"]); 
        $file_ext = strtolower (  substr($filename, strrpos($filename, ".") + 1)); 
        $uploadTarget = $upload_path.$filename; 

        if(empty($uploadedInfo)) { 
                  return array("sts"=>"error","msg"=>"no hay archivo"); 
                }  
		if ($userfile_size<=0){
			    return array("sts"=>"error","msg"=>"archivo vacio"); 
		} 
		if($file_ext!= "jpg" &&$file_ext!="jpeg"&&$file_ext!="png"  ){
			 return array("sts"=>"error","msg"=>"extensión de archivo desconocido"); 
        } 
						
				

		try{

        if (isset($uploadedInfo['name'])){ 
            	move_uploaded_file($userfile_tmp, $uploadTarget ); 
            	chmod ($uploadTarget , 0777); 
            	$width = $this->getWidth($uploadTarget); 
            	$height = $this->getHeight($uploadTarget); 
            	// Scale the image if it is greater than the width set above 
            	if ($width > $max_width){ 
                $scale = $max_width/$width; 
                	$uploaded = $this->resizeImage($uploadTarget,$width,$height,$scale); 
            	}else{ 
                	$scale = 1; 
                	$uploaded = $this->resizeImage($uploadTarget,$width,$height,$scale); 
            	} 
        	} 
		} catch (Exception $e){
			 return array("sts"=>"error","msg"=>"error al redimensionar imagen"); 
			
		}
        return array("sts"=>"ok" ,'imagePath' => $webpath.$filename, 'imageName' => $filename, 'imageWidth' => $this->getWidth($uploadTarget), 'imageHeight' => $this->getHeight($uploadTarget)); 
    } 

    function getHeight($image) { 
        $sizes = getimagesize($image); 
        $height = $sizes[1]; 
        return $height; 
    } 
    function getWidth($image) { 
        $sizes = getimagesize($image); 
        $width = $sizes[0]; 
        return $width; 
    } 

    function resizeImage($image,$width,$height,$scale) { 
        $newImageWidth = ceil($width * $scale); 
        $newImageHeight = ceil($height * $scale); 
        $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight); 
$ext = strtolower(substr(basename($image), strrpos(basename($image), ".") + 1)); 
        $source = ""; 
        if($ext == "png"){ 
            $source = imagecreatefrompng($image); 
        }elseif($ext == "jpg" || $ext == "jpeg"){ 
            $source = imagecreatefromjpeg($image); 
        }elseif($ext == "gif"){ 
            $source = imagecreatefromgif($image); 
        } 
        imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height); 
      /*  if($ext == "png" || $ext == "PNG"){ 
            imagepng($newImage,$image,0); 
        }elseif($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG"){ 
            imagejpeg($newImage,$image,90); 
        }elseif($ext == "gif" || $ext == "GIF"){ 
            imagegif($newImage,$image); 
        } */
		
		imagejpeg($newImage,$image,90); 
        chmod($image, 0777); 
        return $image; 
    } 

    function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){ 
        $newImageWidth = ceil($width * $scale); 
        $newImageHeight = ceil($height * $scale); 
        $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight); 
        $ext = strtolower(substr(basename($image), strrpos(basename($image), ".") + 1)); 
        $source = ""; 
        if($ext == "png"){ 
            $source = imagecreatefrompng($image); 
        }elseif($ext == "jpg" || $ext == "jpeg"){ 
            $source = imagecreatefromjpeg($image); 
        }elseif($ext == "gif"){ 
            $source = imagecreatefromgif($image); 
        }
		
		
	//	 $source = imagecreatefromjpeg($image); 
        imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);

      /*  if($ext == "png" || $ext == "PNG"){ 
            imagepng($newImage,$thumb_image_name,0); 
        }elseif($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG"){ 
            imagejpeg($newImage,$thumb_image_name,90); 
        }elseif($ext == "gif" || $ext == "GIF"){ 
            imagegif($newImage,$thumb_image_name); 
        } 
		*/
		imagejpeg($newImage,$thumb_image_name,90); 
		
        chmod($thumb_image_name, 0777); 
        return $thumb_image_name; 
    } 

	function initialize(){
		}
	function startup(){
		}
		function beforeRender(){}
		
	function shutdown(){}

  function cropImage($thumb_width, $x1, $y1, $x2, $y2, $w, $h, $thumbLocation, $imageLocation){ 
    $scale = $thumb_width/$w; 
    $cropped = $this->resizeThumbnailImage(WWW_ROOT.str_replace("/", DS,$thumbLocation),WWW_ROOT.str_replace("/", DS,$imageLocation),$w,$h,$x1,$y1,$scale);
    return $cropped; 
  } 

	function moveImage($folder,$current_file,$name_image ){	
  	/*
    	folder=C:\xampp\htdocs\nuestroempleo\public_html\documentos\candidatos\candidato_1
      current_file=/img/upload/37855.png 
      new_file=/documentos/candidatos/candidato_1/37855.png 
      path=C:\xampp\htdocs\nuestroempleo\public_html 
      current=C:\xampp\htdocs\nuestroempleo\public_html\img\upload\37855.png 
      new=C:\xampp\htdocs\nuestroempleo\public_html\documentos\candidatos\candidato_1\37855.png 
      folder=C:\xampp\htdocs\nuestroempleo\public_html\documentos\candidatos\candidato_1 
    */
	
		$path = substr(WWW_ROOT, 0, strlen(WWW_ROOT) - 1);
	  $current = $path . str_replace("/", DS, $current_file); 
	  $folder = $path . str_replace("/", DS, $folder);		 
	  $name_file_new = $folder . DS . $name_image;
		 
		try{ 
		 	if (!file_exists ( $folder )) {
			  mkdir($folder);					  		
			}
		} catch (Exception $e) {

		}
		
    rename($current, $name_file_new );

    return $name_file_new;
	}
	
} 