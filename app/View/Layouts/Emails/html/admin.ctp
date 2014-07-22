<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Correo informativo de Nuestro Empleo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <style>
    body {
      background-color:#e8e4e3;
      text-align: center;
      font-family: 'Open Sans', Helvetica, Arial, sans-serif;
      /*color: #888;*/
      font-size: 13px;
    }
    a {
      color:#8a48d1; text-decoration:none; font-weight:bold;
    }
    ul.list-unstyled {
      list-style: none;
    }
    .text-left {
      text-align: left;
    }
    .block {
      display: block;
    }
  </style>
</head>
<body>
  <table style="width:759px; background-color:#fff;margin:auto;">
    <tr>
      <td colspan="2">
        <?php echo $this->fetch('content'); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="background-color:#666; color:#FFF; text-align:center; padding:10px;">
        Este correo está generado de manera automática con fines informativos, por favor no responda a este mensaje.
        <br>
        Si desea contactarnos puede hacerlo a través de:
        <p><a style="color:#FFF;" href="mailto:contacto.ne@nuestroempleo.com.mx">contacto.ne@nuestroempleo.com.mx</a></p>
      </td>
    </tr>
    <tr style="background-color::; ">
      <td colspan="2" style="padding:10px; color:#FFF; text-align:left;">
        D.R. ©; iGenter México S. de R.L. de C.V., Nuevo León No. 202 Piso 5, Colonia Hipódromo Condesa, C.P. 06170, Delegación Cuauhtémoc, México, D.F., 2014.
Prohibida la reproducción total o parcial de esta obra sin la previa autorización de su titular.
      </td>
    </tr>
  </table>
</body>
</html>

