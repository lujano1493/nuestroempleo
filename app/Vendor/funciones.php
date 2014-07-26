<?php 

class Funciones {
	public static function generar_clave($longitud){ 
		$cadena="[^A-NP-Z1-9]"; 
		return substr(eregi_replace($cadena, "", md5(rand())) . 
			eregi_replace($cadena, "", md5(rand())) . 
			eregi_replace($cadena, "", md5(rand())), 
			0, $longitud); 
	} 

	public static function parseUtf8ToIso88591(&$string){
		if(!is_null($string)){
			$iso88591_1 = utf8_decode($string);
			$iso88591_2 = iconv('UTF-8', 'ISO-8859-1', $string);
			$string = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');       
		}
	}
	public static function parseHtmlFormat($string){
		$caracter=array(
				'á'=> "&aacute;",
				'é'=> "&eacute;",
				'í'=> "&iacute;",
				'ó'=> "&oacute;",
				'ú'=> "&uacute;",
				'Á'=> "&Aacute;",
				'É'=> "&Eacute;",
				'Í'=> "&Iacute;",
				'Ó'=> "&Oacute;",
				'Ú'=> "&Uacute;",
				"ñ" => "&ntilde;",
				"Ñ"=> "&Ntilde;",
				"¡"=>"&iexcl;",
				"¿"=>"&iquest;"
			);
		foreach ($caracter as $key => $value) {
			$string= str_replace($key,$value,$string);
		}
		
		return $string;
	}

	public static function include_all_php($folder){
    	foreach (glob("{$folder}/*.php") as $filename){
        	include_once $filename;
    	}
	}


	public static function hash($sString, $sPsw = null) {
$sDest 				= "";		//* Cadena resultante
$sAsc 				= "";		//* Ascii del caracter
$sPswEnc			= "";		//* Password convertido
$iSec  				= 0;		//* Secuencia en la cadena
$iSecPsw 			= 0;		//* Secuencia en el password
$iCharPsw 		= 0;		//* Caracter de password
$iCharString 	= 0;		//* Caracter de cadena
$iCharRes			= 0;		//* Caracter resultante
$iLenPswEnc		= 0;		//* Longitud del password codificado
$sHexRes			= "";	    //* Hexadecimal resultante

if (!isset($sPsw)) {
	$sPsw = self::token();
}

//var_dump($sPsw); die;
//* Obtener la longitud de la cadena
$iLenPsw = strlen($sPsw);
/*Para todos los caracteres del password*/
for($i = 0; $i < $iLenPsw; $i++) {
	/*Convertir cada caracter en su representacion ASCII*/
	$sAsc = ord($sPsw[$i]); 
	/*Concatenar a la cadena de password*/
	$sPswEnc .= $sAsc;
}

/*Obtener la longitud de la cadena resultante*/
$iLenPswEnc = strlen($sPswEnc);
/*Indicar que revise la cadena desde su comienzo*/
$iSecPsw = 0;
/*Obtener la longitud de la cadena */
$iLenString	= strlen($sString);

/*Para todos los caracteres en la cadena*/
for ($i = 0; $i < $iLenString; $i++) {
	/*Si se ha alcanzado la longitud del password*/
	if($iSecPsw >= strlen($sPswEnc)) {
		$iSecPsw = 0;	/*Indicar que revise la cadena desde su comienzo*/
	}
	/*Obtener un caracter del password*/
	$iCharPsw = ord($sPswEnc[$iSecPsw]);
	/*Siguiente caracter del password*/
	$iSecPsw++;
	if($iSecPsw > $iLenString) {
		$iSecPsw = 0;	/*Indicar que revise la cadena desde su comienzo*/
	}

	/*Obtener un caracter de la cadena*/
	$iCharString = ord($sString[$i]);
	/*Aplicar un xor exclusivo */
	$iCharRes = $iCharPsw ^ $iCharString;
	/*Obtener el hexadecimal en formato cadena*/
	$sHexRes = dechex($iCharRes);
//* Si la longitud es menor a 2
	if(strlen($sHexRes) < 2) {
		/*Agregar un cero al valor*/
		$sHexRes = "0" . $sHexRes;
	}

	/*Agregar al resultado*/
	$sDest .= $sHexRes;
}
return strtoupper($sDest);
}

public static function token() {
	$sCad =  ";";
	$sCad .= "*";
	$Psw = "";
	$sCad .=  "<";
	$Psw = "9" . $sCad;
	$sCad .= "0";
	$Psw = "5" . $sCad;
	$sCad .= "@";
	$Psw = "7" . $sCad;
	$sCad .= "�";
	$Psw = "�" . $sCad;
	$sCad .=  "?";
$sString = "qwerty2000"; //* Anzuelo
$sCad .=  "8";
$sString =  $sCad;
$sCad .=  "�";
$sString =  $sCad;
$sCad .= "K";
$sString =  $sCad;
$sCad .=  "�";
$sString =  $sCad;
$sCad .= "%";
$sString =  $sCad;
$sCad .= "5";

$sString =  $sCad;
return $sString;
}



public static function quitar_etiquetas($descrip=""){
	$descrip = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2',$descrip);      
    $descrip=strip_tags( $descrip); 
    return  $descrip;

}

public static function lista_str($arr=array()){
	$c=count($arr);
	$str="";
	for ($i=0;$i<$c;$i++){
		$str.= $arr[$i]. (  $i+1<$c  ?  ( $i+2<$c ?  ", " :" y " )   :"" ) ;
	}

	return $str;

}


function valueDefault($value,$default){			
	return ($value!=NULL)?$value:$default;

}
/*
* 	element elemento a buscar
$array: arreglo de elementos donde se vuscara
$element_ valor a buscar
$name_model nombew del modelo
$name_field nombre del campo
* 
* */


public static function array_search($array,$element_,$name_field){				
	$array_search= Funciones::array_column($array, $name_field);

	return in_array($element_,$array_search );				

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





public static function array_column($array, $column)
{
	if(empty($array)){
		return array();	
	}

	foreach ($array as $row) $ret[] = $row[$column];
	return $ret;
}

public static function check_picture($id,$webroot="/"){

	$ruta=$webroot."documentos/candidatos/".$id."/foto.jpg";
	$path=substr(WWW_ROOT,0,strlen(WWW_ROOT)-1).str_replace("/",DS,$ruta);	  
	if(file_exists($path)){
		return  $ruta;

	}
	else{
		return $webroot."img/candidatos/default.jpg";
		return $webroot."img/no-logo.jpg";
	}     

}


public static function check_image_cia($id,$webroot="/"){

	$ruta=$webroot."documentos/empresas/".$id."/logo.jpg";
	$path=substr(WWW_ROOT,0,strlen(WWW_ROOT)-1).str_replace("/",DS,$ruta);	  
	if(file_exists($path)){
		return  $ruta;

	}
	else{
		return $webroot."img/no-logo.jpg";
	}     

}




	public static function agregadocumento($id=0,$name="pruebecita",$file_path_url_temp="temporales/pruebecita.jpg" ){
			$docu="documentos";
			$docu_can="candidatos";			
			
	  		$current_path_file = WWW_ROOT.str_replace("/", DS, $file_path_url_temp); 	  		
			if(!file_exists( ROOT.DS.$docu   )){
				if(!mkdir(ROOT.DS.$docu ) ){
					return false;
				}
			}

			if(!file_exists( ROOT.DS.$docu.DS.$docu_can)  ){
				if ( !mkdir(ROOT.DS.$docu.DS.$docu_can ) ){
					return false;
				}
			}

			if(!file_exists( ROOT.DS.$docu.DS.$docu_can.DS.$id )  ){
				if(!mkdir(ROOT.DS.$docu.DS.$docu_can.DS.$id ) ){
					return false;
				}	
			}
			$docum_path=ROOT.DS.$docu.DS.$docu_can.DS.$id;
			$extension = substr($current_path_file, strrpos($current_path_file, '.')+1);
			$new_path_file=$docum_path.DS."$name.$extension";
			return	rename($current_path_file,$new_path_file) ;

	}
	public static function verdocumento($id=0,$name="prueba"){
		$docu="documentos";
		$docu_can="candidatos";	
		$docum_path=ROOT.DS.$docu.DS.$docu_can.DS.$id;

		foreach (glob("$docum_path".DS. "$name.*") as $filename) {
		 		return $filename;
		 	}
		 return null;
		}

	public static function eliminardocumento($id=0,$name="prueba"){
		$docu="documentos";
		$docu_can="candidatos";	
		$docum_path=ROOT.DS.$docu.DS.$docu_can.DS.$id;
		foreach (glob("$docum_path".DS. "$name.*") as $filename) {
		 	if (!unlink($filename)){
		 		return false;
		 	}
		}
		return true;
		
	}



	public static function getNav(){
		$user_agent=$_SERVER['HTTP_USER_AGENT'];
		$navegadores = array(
			'Opera' => 'Opera',
			'Mozilla Firefox'=> '(Firebird)|(Firefox)',
			'Google Chrome'=>'(Chrome)',
			'Galeon' => 'Galeon',
			'Mozilla'=>'Gecko',
			'MyIE'=>'MyIE',
			'Lynx' => 'Lynx',
			'Chrome'=>'Chrome',
			'Netscape' => '(CHROME/23\.0\.1271\.97)|(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
			'Konqueror'=>'Konqueror',			
			'ie10' => '(MSIE 10\.[0-9]+)',
			'ie9' => '(MSIE 9\.[0-9]+)',
			'ie8' => '(MSIE 8\.[0-9]+)'
			);
		foreach($navegadores as $navegador=>$pattern){
			if (eregi($pattern, $user_agent))
				return $navegador;
		}

	}


public static function getPeticion($url=null){
	if(!$url){
		return null;
	}
	$curl = curl_init();
// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url
//  CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
// Send the request & save response to $resp
	$resp = curl_exec($curl);
// Close request to clear up some resources
	curl_close($curl);

	return $resp;


}

public static  function mes_numero_palabra($index=0,$formato='corto'){
	$meses_1=array("Ene.","Feb.","Mar.","Abr.","May.","Jun.","Jul.","Ago.","Sep.","Oct.","Nov.","Dic.");
	$meses_2=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$meses=$formato=='largo'? $meses_2: $meses_1;
	return $meses[$index - 1];
}

public static function formato_fecha_1($fecini,$fecfin=null){
	if(!$fecini && !$fecfin){
		$fecha =  split("/", date("d")."/".date("m")."/".date("Y"));
		$fecha= Funciones::mes_numero_palabra($fecha[1])." ".$fecha[2];
		return $fecha." - ".$fecha; 
	}
	$fecini= split("/",$fecini);
	if($fecfin && $fecfin!=='Actual'){
		$fecfin= split("/",$fecfin);
		$fecfin= Funciones::mes_numero_palabra($fecfin[1])." ".$fecfin[2];
	}
	else{
		$fecfin="Actual";
	}
	return Funciones::mes_numero_palabra($fecini[1])." ".$fecini[2] ." - " .$fecfin;

}

/*funcion para obtener status de candidato*/

public static function getStatusGraf($grafcan=array(),$id){
	$total_percent=0;
	$tablas_restantes="";
	foreach($grafcan as $value){
			if(!empty($grafcan) ){
				$total_percent+= (int) $value['TablaGrafCan']['tabla_porcentaje'];	
			}
			
		}
		$tablas_r=ClassRegistry::init("TablaGrafCan")->getTablasFaltantes($id);
		$total_r=count($tablas_r);

		$tablas_restantes.="<ul class='lista-restante'>";
		for ($i=0; $i<$total_r;$i++ ) {
				$link_json=$tablas_r[$i]['TablaGrafCan']['tabla_link'];
				$link=json_decode($link_json);				

				$tablas_restantes.= '<li> <a  data-url=\'['.$link_json .']\'  data-component=\'viewelementview\'   '.
									'href=\'/'.$link->controller."/".$link->action.'\' >'. 
									 $tablas_r[$i]['TablaGrafCan']['tabla_descripcion'] .'</a> </li> <br/>' ;
			//	$tablas_restantes.= ($i== $total_r-2 ) ? " y "     :(($i+1< $total_r ) ? ", " :"");


		}
		$tablas_restantes.="</ul>";

		$color="";$text="";
		if($total_percent >=0  && $total_percent<=50 ){
			$color="#FF0000";
			$text="¡Tu Currículum no está completo! Ingresa a 'Mi Currículum' y llena los siguientes campos: $tablas_restantes";
		}
		else if ($total_percent  > 50  &&  $total_percent < 99 ){
			$color="#F7FE2E";
			$text="¡Aumenta las visitas a tu Currículum completando los siguientes campos!: $tablas_restantes";


		}
		else if ($total_percent >= 99 ){
				$color="#2784c3";
				$text="¡Perfecto! La información de tu Currículum está completa.";

		}

		$result= compact("color","text","total_percent");
		return $result;

}
}






?>