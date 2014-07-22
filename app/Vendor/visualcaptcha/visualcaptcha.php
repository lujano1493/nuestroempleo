<?php
/**
 * visualCaptcha HTML class by emotionLoop - 2013.06.22
 *
 * This class handles the HTML for the main visualCaptcha class.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license GNU GPL v3
 * @version 4.1.0
 */
class HTML {
	
	public function __construct() {
	}
	
	public static function get( $type, $fieldName, $accessibilityFieldName, $formId, $captchaText, $options ) {
		$html = '';
		
		ob_start();
		?>
		<script>
		window.vCVals = {
			'f': '<?php echo $formId; ?>',
			'n': '<?php echo $fieldName; ?>',
			'a': '<?php echo $accessibilityFieldName; ?>'
		};
		</script>		
		<div class="eL-captcha type-<?php echo $type; ?> clearfix" >
	
			<p class="eL-explanation type-<?php echo $type; ?>"><span class="desktopText"><?php echo 'Arrastra '; ?> <strong><?php echo $captchaText; ?></strong> <?php echo 'hacia el lugar indicado'; ?>.</span><span class="mobileText"><?php echo 'Touch the'; ?> <strong><?php echo $captchaText; ?></strong> <?php echo 'to move it to the circle on the side'; ?>.</span></p>
			<div class="eL-possibilities type-<?php echo $type; ?> clearfix">
				<?php
				$limit = count( $options );

				for ( $i = 0; $i < $limit; $i++ ) {
					$name = $options[ $i ];
					?>
					<img src="<?php echo Captcha::$imageFile; ?>?i=<?php echo ($i + 1); ?>&amp;r=<?php echo time(); ?>" class="vc-<?php echo ($i + 1); ?>" data-value="<?php echo $name; ?>" alt="" title="">
					<?php
				}
				?>
			</div>
			<div class="eL-where2go type-<?php echo $type; ?> clearfix">
				<p><?php echo 'Arrastra<br>Aquí'; ?></p>
			</div>
				
				</div>
				<?php
				$html = ob_get_clean();
				return $html;
			}
		}


/**
 * visualCaptcha Captcha class by emotionLoop - 2013.06.22
 *
 * This class handles a visual image captcha system.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license GNU GPL v3
 * @version 4.1.0
 */

class Captcha {
	private $formId = 'frm_captcha';
	private $type = 0;
	private $fieldName = 'captcha-value';
	private $accessibilityFieldName = 'captcha-accessibility-value';
	private $html = '';
	private static $hash = '';
	private static $hashSalt = '';
	private $answers = array();
	private $options = array();
	private $optionsProperties = array();
	private $accessibilityOptions = array();
	private $accessibilityFile = '';
	private $accessibilityAnswer = '';
	private $value = '';
	private $valueProperties = array();
	private $htmlClass = 'visualcaptcha.class.html.php';
	public static $imagesPath = 'img/visualcaptcha/';
	public static $audiosPath = 'audio/visualcaptcha/';
	public static $imageFile = '/uploads/image_captcha';
	public static $audioFile = 'audio.php';



	public function __construct( $formId = NULL, $type = NULL, $fieldName = NULL, $accessibilityFieldName = NULL ) {
		Captcha::$hashSalt = 'emotionLoop::' . $_SERVER['REMOTE_ADDR'] . '::visualCaptcha::';
		Captcha::$hash = sha1( Captcha::$hashSalt . $this->nonceTick(1800) . '::tick' );
		
		if ( ! is_null($formId) ) {
			$this->formId = $formId;
		}
		
		if ( ! is_null($type) ) {
			$this->type = (int) $type;
		} else {
			$this->type = 0;
		}

		if ( ! is_null($fieldName) ) {
			$this->fieldName = $fieldName;
		}

		if ( ! is_null($accessibilityFieldName) ) {
			$this->accessibilityFieldName = $accessibilityFieldName;
		}

		// Setup Image Names here: stringID, array(ImagePath, ImageName/Text to show)
		$this->answers = array(
		   'airplane' => array(self::$imagesPath . 'airplane.png', 'el Avión'),
		   'balloons' => array(self::$imagesPath . 'balloons.png', 'los Globos'),
		   'camera'   => array(self::$imagesPath . 'camera.png',   'la Cámara'),
		   'car'   => array(self::$imagesPath . 'car.png',   'el Carro'),
		   'cat'   => array(self::$imagesPath . 'cat.png',   'el Gato'),
		   'chair' => array(self::$imagesPath . 'chair.png', 'la Silla'),
		   'clip'  => array(self::$imagesPath . 'clip.png',  'el Clip'),
		   'clock' => array(self::$imagesPath . 'clock.png', 'el Reloj'),
		   'cloud' => array(self::$imagesPath . 'cloud.png', 'la Nube'),
		   'computer' => array(self::$imagesPath . 'computer.png', 'la Computadora'),
		   'envelope' => array(self::$imagesPath . 'envelope.png', 'la Carta'),
		   'eye'   => array(self::$imagesPath . 'eye.png',   'el Ojo'),
		   'flag'  => array(self::$imagesPath . 'flag.png',  'la Bandera'),
		   'folder'   => array(self::$imagesPath . 'folder.png',   'la Carpeta'),
		   'foot'  => array(self::$imagesPath . 'foot.png',  'el Pie'),
		   'graph' => array(self::$imagesPath . 'graph.png', 'la Gráfica'),
		   'house' => array(self::$imagesPath . 'house.png', 'la Casa'),
		   'key'   => array(self::$imagesPath . 'key.png',   'la Llave'),
		   'lamp'  => array(self::$imagesPath . 'lamp.png',  'el Foco'),
		   'leaf'  => array(self::$imagesPath . 'leaf.png',  'la Hoja'),
		   'lock'  => array(self::$imagesPath . 'lock.png',  'el Candado'),
		   'magnifying-glass' => array(self::$imagesPath . 'magnifying-glass.png', 'la Lupa'),
		   'man'   => array(self::$imagesPath . 'man.png',   'el Hombre'),
		   'music-note' => array(self::$imagesPath . 'music-note.png', 'la Nota Musical'),
		   'pants' => array(self::$imagesPath . 'pants.png', 'el Pantalón'),
		   'pencil'   => array(self::$imagesPath . 'pencil.png',   'el Lápiz'),
		   'printer'  => array(self::$imagesPath . 'printer.png',  'la Impresora'),
		   'robot' => array(self::$imagesPath . 'robot.png', 'el Robot'),
		   'scissors' => array(self::$imagesPath . 'scissors.png', 'las Tijeras'),
		   'sunglasses' => array(self::$imagesPath . 'sunglasses.png', 'las Gafas'),
		   'tag'   => array(self::$imagesPath . 'tag.png',   'la Etiqueta'),
		   'tree'  => array(self::$imagesPath . 'tree.png',  'el Árbol'),
		   'truck' => array(self::$imagesPath . 'truck.png', 'el Camión'),
		   'tshirt'   => array(self::$imagesPath . 'tshirt.png',   'la Camiseta'),
		   'umbrella' => array(self::$imagesPath . 'umbrella.png', 'la Sombrilla'),
		   'woman' => array(self::$imagesPath . 'woman.png', 'la Mujer'),
		   'world' => array(self::$imagesPath . 'world.png', 'el Globo Terráqueo'),


		);

		// Setup Accessibility Questions here: array(Answer, MP3 Audio file). You can repeat answers, but it's safer if you don't.
		// You can generate MP3 & Ogg audio files easily using http://stuffthatspins.com/stuff/php-TTS/index.php
		$this->accessibilityOptions = array(
			array('10', self::$audiosPath . '5times2.mp3'),
			array('20', self::$audiosPath . '2times10.mp3'),
			array('6', self::$audiosPath . '5plus1.mp3'),
			array('7', self::$audiosPath . '4plus3.mp3'),
			array('4', self::$audiosPath . 'add3to1.mp3'),
			array('green', self::$audiosPath . 'addblueandyellow.mp3'),
			array('white', self::$audiosPath . 'milkcolor.mp3'),
			array('2', self::$audiosPath . 'divide4by2.mp3'),
			array('yes', self::$audiosPath . 'sunastar.mp3'),
			array('no', self::$audiosPath . 'yourobot.mp3'),
			array('12', self::$audiosPath . '6plus6.mp3'),
			array('100', self::$audiosPath . '99plus1.mp3'),
			array('blue', self::$audiosPath . 'skycolor.mp3'),
			array('3', self::$audiosPath . 'after2.mp3'),
			array('24', self::$audiosPath . '12times2.mp3'),
			array('5', self::$audiosPath . '4plus1.mp3'),
		);
	}
	
	public function show() {
		$this->setNewValue();
		
		// Include visualCaptcha HTML class
		$this->html = HTML::get( $this->type, $this->fieldName, $this->accessibilityFieldName, $this->formId, $this->getText(), $this->options );

		echo $this->html;
	}

	public function only_show() {
		
		// Include visualCaptcha HTML class
		$this->html = HTML::get( $this->type, $this->fieldName, $this->accessibilityFieldName, $this->formId, $this->getText(), $this->options );

		echo $this->html;
	}
	public function init_value(){
		$this->setNewValue();
	}
	
	public function isValid() {
		// "Normal" option
		if ( isset($_POST[$this->fieldName]) && isset($_SESSION[Captcha::$hash]) && ($_POST[$this->fieldName] === $_SESSION[Captcha::$hash]) ) {
			return true;
		}

		// Accessibility option
		if ( isset($_POST[$this->accessibilityFieldName]) && isset($_SESSION[Captcha::$hash.'::accessibility']) && ($this->encrypt( mb_strtolower($_POST[$this->accessibilityFieldName]) ) === $_SESSION[Captcha::$hash.'::accessibility']) ) {
			return true;
		}
		return false;
	}


	public function setHash($hash=null){
		if($hash==null){
					Captcha::$hash = sha1( Captcha::$hashSalt . $this->nonceTick(1800) . '::tick' );
		}
		Captcha::$hash=$hash;
	}
	
	private function setNewValue() {

		$this->answers = $this->shuffle( $this->answers );

		$i = 0;
		switch ( $this->type ) {
			case 0:// Horizontal
				$limit = 5;
			break;
			case 1:// Vertical
				$limit = 4;
			break;
		}
		
		// Define the index that will have the right answer
		$rnd = rand( 0, $limit - 1 );
		
		foreach ( $this->answers as $answer => $answerProps ) {
			if ( $i >= $limit ) {
				continue;
			}

			$encryptedAnswer = $this->encrypt( $answer );

			$this->options[] = $encryptedAnswer;
			$this->optionsProperties[ $encryptedAnswer ] = $answerProps;

			// Record this option as the answer
			if ( $i === $rnd ) {
				$_SESSION[ Captcha::$hash ] = $encryptedAnswer;
				$this->value = $encryptedAnswer;
				$this->valueProperties = $answerProps;
			}

			++$i;
		}

		// Mess with the ordering
		shuffle( $this->options );

		// Store the options in the session
		$_SESSION[ Captcha::$hash . '::options' ] = $this->options;
		$_SESSION[ Captcha::$hash . '::optionsProperties' ] = $this->optionsProperties;

		// Accessibility option. Set question file and answer, encrypted
		$this->accessibilityOptions = $this->shuffle( $this->accessibilityOptions );

		$limit = count( $this->accessibilityOptions );

		$rnd = rand(0, $limit-1);

		$this->accessibilityAnswer = $this->encrypt( $this->accessibilityOptions[ $rnd ][ 0 ] );
		$this->accessibilityFile = $this->accessibilityOptions[ $rnd ][ 1 ];

		$_SESSION[ Captcha::$hash . '::accessibility' ] = $this->accessibilityAnswer;
		$_SESSION[ Captcha::$hash . '::accessibilityFile' ] = $this->accessibilityFile;
	}
	
	private function getValue() {
		return $this->value;
	}
	
	private function getImage() {
		return  isset($this->valueProperties[ 0 ]) ? $this->valueProperties[ 0 ] :null ;
	}
	
	private function getText() {
		return  isset($this->valueProperties[ 1 ]) ? $this->valueProperties[ 1 ] :null ;
	}
	
	/**
	 * Get the time-dependent variable for nonce creation.
	 * This function is based on Wordpress' wp_nonce_tick().
	 *
	 * @since 1.1
	 * @param $life Integer number of seconds for the tick to be valid. Defaults to 86400 (24 hours)
	 * @return int
	 */
	private function nonceTick( $life = 86400 ) {
		return ceil( time() / $life );
	}
	
	/**
	 * Private shuffle() method. Shuffles an associative array. If $list is not an array, it returns $list without any modification.
	 *
	 * @since 1.1
	 * @param $list Array to shuffle.
	 * @return $random Array shuffled array.
	 */
	private function shuffle( $list ) {
		if ( ! is_array($list) ) {
			return $list;
		}
		$keys = array_keys( $list );
		shuffle( $keys );
		$random = array();
		
		foreach ( $keys as $key ) {
			$random[ $key ] = $list[ $key ];
		}
		
		return $random;
	}

	/**
	 * Private encrypt method. Encrypts a string using sha1()
	 *
	 * @since 4.0
	 * @param $string String to encrypt
	 * @return $encryptedString String encrypted
	 */
	private function encrypt( $string ) {
		$encryptedString = sha1( Captcha::$hashSalt . $this->nonceTick(1800) . '::encrypt::' . $string );
		return $encryptedString;
	}

	/**
	 * Public getAudioFilePath method. Returns the current audio file path in the session, if set
	 *
	 * @since 4.0
	 * @return String with the path to the current acessibility audio file
	 */
	public function getAudioFilePath() {
		return $_SESSION[ Captcha::$hash . '::accessibilityFile' ];
	}

	/**
	 * Public getImageFilePath method. Returns the image file path in the session, for the given index
	 *
	 * @since 4.1
	 * @param $i Integer index number
	 * @param $getRetina Boolean should the images be @2x or not. Defaults to false
	 * @return String with the path to the current image file according to the index
	 */
	public function getImageFilePath( $i, $getRetina = false ) {
		$imageEncryptedValue = $_SESSION[ Captcha::$hash . '::options' ][ $i ];
		$imagePath = $_SESSION[ Captcha::$hash . '::optionsProperties' ][ $imageEncryptedValue ][ 0 ];
		if ( ! $getRetina ) {
			return $imagePath;
		} else {
			$retinaPath = str_replace( '.png', '@2x.png', $imagePath );
			return $retinaPath;
		}
	}
}
?>