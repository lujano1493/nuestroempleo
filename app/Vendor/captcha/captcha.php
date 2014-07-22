<?php
/*	Captcha Class 1.0
*	Written by Zakir Hyder (http://blog.jambura.com/)
*/
 
class captcha {	
	public function show_captcha_1() {
		if (session_id() == "") {
			session_name("CAKEPHP");
			session_start();
		}

		$path= APP.'Vendor'.DS.'captcha';
		$imgname = 'noise.jpg';
		$imgpath  = $path.DS.'images'.DS.$imgname;			
		$captchatext = md5(time());
		$captchatext = substr($captchatext, 0, 5);
		$_SESSION['captcha']=$captchatext;

		if (file_exists($imgpath) ){
			$im = imagecreatefromjpeg($imgpath); 
			$grey = imagecolorallocate($im, 128, 128, 128);
			$font = $path.DS.'fonts'.DS.'BIRTH_OF_A_HERO.ttf';
			
			imagettftext($im, 20, 0, 10, 25, $grey, $font, $captchatext) ;
			
			header('Content-Type: image/jpeg');
			header("Cache-control: private, no-cache");
			header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
			header("Pragma: no-cache");
			imagejpeg($im);
			
			imagedestroy($im);
			ob_flush();
			flush();
		}
		else{
			echo 'captcha error';
			exit;
		}		 
	}
	
	function show_captcha_2(){
		$path= APP.'Vendor'.DS.'captcha';
		if (session_id() == "") {
			session_name("CAKEPHP");
			session_start();
		}
		
		
		
		$string = '';

		for ($i = 0; $i < 5; $i++) {
			$string .= chr(rand(97, 122));
		}

		$dir = $path.DS.'fonts'.DS;
		$_SESSION['captcha_1']=$string;
		$image = imagecreatetruecolor(165, 50);

		// random number 1 or 2
		$num = rand(1,2);
		if($num==1)
		{
			$font = "Capture it 2.ttf"; // font style
		}
		else
		{
			$font = "Molot.otf";// font style
		}

		// random number 1 or 2
		$num2 = rand(1,2);
		if($num2==1)
		{
			$color = imagecolorallocate($image, 113, 193, 217);// color
		}
		else
		{
			$color = imagecolorallocate($image, 163, 197, 82);// color
		}
		$white = imagecolorallocate($image, 255, 255, 255); // background color white
		imagefilledrectangle($image,0,0,399,99,$white);
		imagettftext ($image, 30, 0, 10, 40, $color, $dir.$font, $string);
		header('Content-Type: image/png');
		header("Cache-control: private, no-cache");
		header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
		header("Pragma: no-cache");			
		imagepng($image);
		imagedestroy($image);
		ob_flush();
		flush();
		
		
		
	}
	
}

 
?>