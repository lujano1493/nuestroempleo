
<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
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
    Resolución de <br>
      Denuncia
  </td>
</tr>

  <tr>
    <td colspan="2" style="background-color:#2f72cb; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <p  style="font-weight: bold;text-align:right; padding-right:10px;">Enviado: <?=$this->Time->dt(date("Y-m-d H:i:s"))?></p>
      <p style="font-weight: bold;padding-left:10px;text-align:left;">Estimado: <?=$data['nombre'] ?></p>

      <p style="text-align:center">Hemos verificado la oferta 
        <span style="color: #2f72cb;font-weight: bold;font-size: 16px;"><?=$data['puesto_nombre'] ?></span> 
        reportada el día 
        <strong><?=$this->Time->dt($data['fecha'])?></strong>,

        <?php 
            if($resolucion==='declinada'){
                echo "y no hemos detectado información que incumpla las condiciones de veracidad en Nuestro Empleo, por lo cual, seguirá activo en la base de datos.";
            }
            else{
                echo " y debido a que incumple los términos y condiciones de Nuestro Empleo, ha sido eliminada del sistema. Agradecemos tu reporte.";
            }
        ?>       
      </p>

      <p style="text-align:center">
        Para mayor información escríbanos a 
        <a href="mailto:contacto.ne@nuestroempleo.com.mx">
          contacto.ne@nuestroempleo.com.mx
        </a>
        <br>o comuníquese con nosotros al 01-800-849-24-87
      </p>

    </td>
  </tr>
  <tr>
    <td colspan="2">
      <br><br>
      <p style="text-align:center">El equipo de Nuestro Empleo agradece su preferencia
        <br>
        <strong>
          DEPARTAMENTO DE VERIFICACIÓN
        </strong>
      </p>
    </td>
  </tr>





