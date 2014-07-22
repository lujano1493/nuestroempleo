<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">  
  </td>
</tr>
<tr> 
  <td style="width:50%; vertical-align:top;">

  <?=$this->Html->image("email/confirmacion_cuenta_candidatos.jpg",
    array(
      "fullBase"=>true, 
      "height" => "194px",
      "width" => "381px"
      ))?>
    </td>
  <td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
    ¡Gracias por registrarte en
    <br>
    n<span style="color:#4e4f53;">uestro empleo</span>!
    <p style="color:#2f72cb; font-weight:bold; font-size:16px;">Bienvenido</p>
  </td>
</tr>
<tr>
  <td colspan="2" style=" background-color:#2f72cb; height:3px;">  
  </td>
</tr>
<tr>
  <td colspan="2" style="text-align:center;">          
    <p style="margin-top:10px"> 
      Hola <?=$data['nombre']; ?>, Gracias por registrarte en Nuestro Empleo.
      Para confirmar tu cuenta necesitamos que validez tu correo electrónico. 
    </p>
    <p>
      Recuerda conservar tu contraseña para que puedas accesar en cualquier momento.  
    </p>
    <p > <span style="color:#2f72cb; font-weight:bold; font-size:16px;">Tu usuario:</span> 
      
          <a  style="color:#000; font-weight:bold" href="<?=$data['correo']?>" target="_blank">
            <?=$data['correo']?>
          </a>
     </p> 
    <p > <span style="color:#2f72cb; font-weight:bold; font-size:16px;">Tu contraseña:</span> <?=$data['contrasena']?></p>
    <p> 
      Por favor da clic en el siguiente enlace para terminar tu registro:
    </p>


    <?=$this->Html->link("Activar Cuenta",array(
        'controller' => 'Candidato',
        'action' => 'activar',
        '?'=> "email=$data[correo]&pass=$data[contrasena]",
        $data['keycode'],          
        'full_base' => true  
      ),array(
        "class"=>"btn_color btn-large",
        'style' => 'color:#2f72cb; text-decoration:none; font-weight:bold;'
         )  )  ?> 

      <p> 
        El equipo de <strong>nuestro empleo</strong> agradece tu preferencia.
      </p>

  </td>
</tr>

