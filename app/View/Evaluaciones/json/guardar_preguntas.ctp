<?php 
		  $time= 2*60*1000;

		  $start=time()*1000;
		  $end= $start+$time;


		$this->_results= compact("time","start","end");
	
?>