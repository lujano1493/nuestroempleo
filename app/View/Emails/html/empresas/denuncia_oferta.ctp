<table>
  <tr>
  <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
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
  <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">Tu Oferta ha sido<br>
    reportada<p></p>
  </td>
</tr>
<tr>
<td colspan="2" style="background-color:#49317b; height:3px;">
  
</td>
</tr>
<tr>
    <td colspan="2">
      <p  style="text-align:right; padding-right:10px;font-weight: bold;">Enviado: <?=$this->Time->dt(date("Y-m-d H:i:s"))?> </p>
      <p  style="padding-left:10px;text-align:left;font-weight: bold;">Estimado:  <?=$data['contacto_nombre']?> </p>

      <p style="text-align:center">La siguiente oferta ha sido reportada por un candidato debido anomalías en la publicación. </p>
      <p style="text-align:center">En los próximos días será contactado un por ejecutivo de verificación de Nuestro Empleo para la validación de la información. </p>
      <p style="text-align:center">Por favor, verifique la publicación y si lo desea, escríbanos a 
        <a style="color:#49317b" href="mailto:contacto.ne@nuestroempleo.com.mx">
          contacto.ne@nuestroempleo.com.mx
        </a> 
          o comuníquese con nosotros al 01-800-849-24-87
      </p>

    </td>
</tr>
<tr>
  <td colspan="2">
    <p style="background-color:#ddd;padding:10px;text-align:center">Para consultar la oferta, de clic en el siguiente enlace<br>
      <span style="color: #49317b;font-weight: bold;font-size: 16px;">
            <?=$this->Html->link(__("Ver Oferta"),$data['oferta_link'],array(
                "style" =>"color:#49317b"
            ))?>
      </span> 
    </p>
    <br><br>
    <p style="text-align:center">El equipo de Nuestro Empleo agradece su preferencia<br>
      <strong>DEPARTAMENTO DE VERIFICACIÓN</strong>
    </p>
  </td>
</tr>            

</table>
