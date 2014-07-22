
<div class="work <?=$span?>  <?=$pull?>">	
	<img id="img" src="<?=$value['src']?>" alt="" width="170px" height="113px">
	<p>

			<?=$this->Html->link ($value['title'],array(
			            "controller" => "articulos",
			            "action" => "destacados",
			            "id" => $value['id']
			          ), array(
			            "target"=> "_blank"

			          ) ) ?>	
		<br>
		<?=$value['descrip']?>
		<br>
		<?=$this->Html->link ("Leer más...",array(
			            "controller" => "articulos",
			            "action" => "destacados",
			            "id" => $value['id']
			          ), array(
			            "target"=> "_blank"

			          ) ) ?>	
	</p>
</div>