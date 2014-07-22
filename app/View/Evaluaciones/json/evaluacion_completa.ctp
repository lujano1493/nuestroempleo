
<?php 


$ticket="";
$eva=$evaluacion;

$preguntas=$eva['Preguntas'];

?>

<?php  $index=0;
	   $numPreg=count($preguntas);
?>



<?php foreach ($preguntas as $pregunta )  :?>

	<?=$this->element("candidatos/sesion_pregunta",compact("pregunta","index","numPreg"))?>

	<?php  $index++;?>

<?php endforeach; ?>




<?php 
		$time=(int) $time;
		$start= time()*1000;
		$this->_results= compact("time","start","question_solve","total_preguntas");
	
?>