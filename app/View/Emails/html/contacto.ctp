
<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">  
  </td>
</tr>
<tr>
    <td style="width:50%; vertical-align:top;">

    <?=$this->Html->image("email/email_foto.jpg",
    array(
      "fullBase"=>true, 
      "width" => "381px",
      "height" =>"194px"
      ))?>
    </td>
  <td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
    Contacto
  </td>
</tr>
<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">  
  </td>
</tr>
<tr>
	<td colspan="2" style="text-align:center; padding-top:15px;">
<div  style="background:#DFDFDF;padding:15px">
    <p>Enviado: <?php echo date("Y-m-d H:i:s"); ?></p>

<?php 
      $c=$data['Contacto'];

?>

<?php if ($is=='educacion'  ): ?>
     <p>
              Nombre de Insttución: <strong>  <?=$c['institucion']?>  </strong>     
      </p>

      <p>
          Tipo de Institución: <strong>  <?=$c['tipo_institucion']?> </strong>
       </p>

      <?php   if  ( !empty($c['otro']) ): ?>
         <p>
              <strong>  <?=$c['otro']?> </strong>
         </p>
     <?php endif;?>
<?php endif;?>
<?php if ($is=='empresa'  ): ?>
     <p>
              Nombre de la Empresa: <strong>  <?=$c['empresa']?>  </strong>     
      </p>
<?php endif;?>
  <p>
           Nombre Completo :       <strong>  <?=$c['nombre']?>  </strong>
  </p>
  <p>
          Teléfono :       <strong>  <?=$c['telefono']?>  </strong>
  </p>
  <p>
          Correo Electrónico :       <strong style="color:black">  <?=$c['correo']?>  </strong>
  </p>
  <p>
     ¿Cómo se enteró de Nuestro Empleo?:  <strong>  <?=$c['medio']?>  </strong>

  </p>
  <h4>Comentario</h4>
  <p>
           <?=$c['comentario']?>  
    
  </p>
  <h4>Dirección</h4>
  <p>
      <?=$c['ciudad']?>  ,<?=$c['estado']?>, <?=$c['pais']?>  

  </p>
</div>




  






	</td>
</tr>