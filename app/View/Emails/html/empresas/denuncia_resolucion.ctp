<table>
  <tr>
<td style="width:50%; text-align:left;">
  <?=
    $this->Html->image("logo.png", array(
      'fullBase' => true,
      'width' => '250px',
      'height' => 'auto',
      'url' => Router::url('/', true)
    ));
  ?>
</td>
<td style="width:50%;">
  <p style="background-color:#49317b;text-align:center;padding:3px;color:#FFF;font-weight:bold;font-size:16px"><?=$title_for_layout?>  </p></td>
</tr>
  
<tr>
  <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
</tr>
<tr>
  <td style="width:50%; vertical-align:top;">

    <?=$this->Html->image("email/invitacion.jpg",
    array(
      "fullBase"=>true,
      "width" => "381px",
      "height" =>"194px"
      ))?>   
  </td>
  <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
    Resolución declinada<br>denuncia de CV
  </td>
</tr>
<tr>
  <td colspan="2" style="background-color:#49317b; height:3px;"></td>
</tr>
<tr>
  <td colspan="2" style="text-align:center">
    <p style="text-align:center">Hemos verificado el perfil de  
      <span style="color: #49317b;font-weight: bold;font-size: 16px"> <?php echo $data['nombre'];?> </span> 
      reportado el día 
      <strong> 
      <?php
          echo $this->Time->dt($data['fecha'] );
      ?>
  
      </strong>
    </p>
    <p style="text-align:center">
      <strong>motivo del reporte</strong>  <?php echo $data['motivo'];?>
    </p> 
    <div  style="text-align:centerbackground-color: #49317b;color: #fff;font-size: 14px;font-weight: bold;padding: 10px 0 10px 0;" >
      Detalles
    </div>
    <div style="background-color: #e2e2e2;text-align: justify !important;vertical-align: top;padding: 10px;margin: 0px;">
      <?php  echo $data['detalles'];  ?>
    </div>

    
      <div style="padding: 20px 10px 20px 10px;">      
        <p>
        <?php   
          if ($resolucion==='declinada'){
              echo " No hemos detectado información que incumpla las condiciones de veracidad en Nuestro Empleo, por lo cual, seguirá activo en la base de datos.";
          }
          else{
            echo "A través del presente, hacemos de su conocimiento que la resolución del caso es <strong style='color:red'> ACEPTADA </strong> por lo cual, el CV ha sido eliminado de la base de datos de Nuestro Empleo.";
          }
        ?> 
        </p>      
        <br>
        <br>
        Si requiere más información  escríbanos a 
        <a style="color: #49317b;text-decoration: none;font-weight: bold;" href="mailto:contacto.ne@nuestroempleo.com.mx">
          contacto.ne@nuestroempleo.com.mx</a> 
        o comuníquese con nosotros al 01800.849.24.87<br><br>
        El equipo de Nuestro Empleo agradece su preferencia.<br>
        <strong>DEPARTAMENTO DE VERIFICACIÓN</strong>
      </div>
  </td>
</tr>



</table>
