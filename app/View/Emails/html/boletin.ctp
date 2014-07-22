<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">
  </td>
</tr>
<tr>
    <td style="width:50%; vertical-align:top;">

		<?=$this->Html->image("email/boletin_articulos.jpg",
		array(
			"fullBase"=>true,
			"width" => "381px",
			"height" =>"194px"
			))?>
    </td>
	<td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
		Artículos de interés
	</td>
</tr>
<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">
  </td>
</tr>
<tr>
	<td style="padding-top:20px">

	</td>
</tr>


<tr>
    <td colspan="2">

		<p style="text-align:center">
			Averígualo y revisa los artículos, novedades y noticias de interés publicados en el portal, y aplícalo en tu vida diaria.
			<br><br>Estos son los artículos publicados en esta semana:
		</p>

		<?php foreach ($data['articulos'] as $key=> $value ) :?>

			<?=$this->element("email/articulo",compact("value") )?>

		<?php  endforeach;?>

		<?php foreach ($data['semblanzas'] as $key=> $value ) :?>

			<?=$this->element("email/articulo",compact("value") )?>

		<?php  endforeach;?>

	     <p style="color:#2f72cb; font-weight:bold;text-align:center">Síguenos a través de: <br>
			<div style="text-align:center" >
					<?=$this->Html->image("email/face.jpg",array("fullBase"=>true ,"url"=> "https://www.facebook.com/NuestroEmpleo",
						"width" =>"52px",
						"height"=>"48px" )) ?>
					<?=$this->Html->image("email/tw.jpg",array("fullBase"=>true ,"url"=> "https://twitter.com/NuestroEmpleo",
						"width" =>"52px",
						"height"=>"48px" )) ?>
					<?=$this->Html->image("email/in.jpg",array("fullBase"=>true ,"url"=> "http://mx.linkedin.com/company/nuestro-empleo",
						"width" =>"52px",
						"height"=>"48px" )) ?>
					<?=$this->Html->image("email/google.jpg",array("fullBase"=>true ,"url"=> "https://plus.google.com/111610607829310871158/posts",
						"width" =>"52px",
						"height"=>"48px" )) ?>

			</div>
	   	</p>

	</td>
</tr>