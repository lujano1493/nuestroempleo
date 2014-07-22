<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title> <?=$title_for_layout?> </title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<style>
body {
background-color:#e8e4e3;
text-align: center;
font-family: 'Open Sans', Helvetica, Arial, sans-serif;
/*color: #888;*/
font-size: 13px; color:#4e4f53;
}
a { color:#2f72cb;
    text-decoration:none; 
    font-weight:bold;
 }
.tit{ background-color:#2f72cb; padding:3px; color:#FFF; font-weight:bold; font-size:16px;}
.usuario{  font-weight:bold;}
.destacar{color:#2f72cb; font-weight:bold; font-size:16px;}
.fondo{ background-color:#ddd; padding:10px;}
</style>
</head>

<body>
<table cellspacing="0" style="width:759px; background-color:#fff;" align="center">
<tbody>
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
  <p style="background-color:#2f72cb;text-align:center;padding:3px;color:#FFF;font-weight:bold;font-size:16px"><?=$title_for_layout?>  </p></td>
</tr>

 <?=$this->fetch("content")?>

 <?php if (!isset($correo_automatico) || $correo_automatico !== false): ?>
      <tr>
        <td colspan="2" style="background-color:#666; color:#FFF; text-align:center; padding:10px;font-size:10px;">Este correo está generado de manera automática con fines informativos, por favor no responda a este mensaje.<br>
          Si desea contactarnos puede hacerlo a través de:
          <p>
            <a  style="color:#FFFFFF;font-size:12px;font-weight:bold" href="mailto:contacto.ne@nuestroempleo.com.mx" target="_blank">
              contacto.ne@nuestroempleo.com.mx
            </a>
          </p>

        </td>
      </tr>
    <?php endif ?>
<tr style="background-color:#2f72cb; ">
<td colspan="2" style="padding:10px; color:#FFF;font-size:10px">D.R. ©; iGenter México S. de R.L. de C.V., Nuevo León No. 202 Piso 5, Colonia Hipódromo Condesa, C.P. 06170, Delegación Cuauhtémoc, México, D.F., 2014.
Prohibida la reproducción total o parcial de esta obra sin la previa autorización de su titular.
</td>
</tr>
</tbody>
</table>
</body>
</html>
