  <?php
  $c = $candidato['CandidatoEmpresa'];
  $id = (int)$c['candidato_cve'];
  $nombre = $candidato['CandidatoEmpresa']['candidato_nom'] .
    ' ' . $candidato['CandidatoEmpresa']['candidato_pat'] .
    ' ' . $candidato['CandidatoEmpresa']['candidato_mat'];

  $direccion = implode(', ', array(
    $c['ciudad_nom'],//$value['Direccion']['ciudad'],
    $c['est_nom'],//$value['Direccion']['estado'],
    $c['pais_nom'],//$value['Direccion']['pais'],
  ));
?>

  <p>
      <table class="separate" style="width:100%">
        <tr>
          <td colspan="3">  
            <h1  style="text-align: center;" ><?= htmlentities( $c['candidato_perfil']); ?></h1> 
          </td>
        </tr>
        <tr>
          <td style="width:20%">
            <?php  
              $url_img = (file_exists(WWW_ROOT . "documentos/candidatos/$id/foto.jpg")) ?
                "documentos/candidatos/" . $id . "/foto.jpg" :
                "img/candidatos/default.jpg"
            ?>
            <img src="<?=$url_img?>" width="100" height="130" />
          </td>
          <td style="width:33%">
            <strong>Datos Personales:</strong>
            <div class="pre">
              <div  class="name" >
                <?= htmlentities($nombre); ?>
              </div>
              <div>
                <?= htmlentities($direccion); ?>
              </div>
              <div>
                C.P. <?= $c['cp_cp']; ?>
              </div>
              <div>
                <?= htmlentities($c['edad']); ?>a&ntilde;os
              </div>
              <div>Sueldo deseado: <?= $c['elsueldo_ini']; ?></div>
            </div>
          </td>
          <td style="width:33%">
            <br/>
            <strong>Datos de contacto:</strong>
            <div class="pre">
              <div>
              <?= $c['cc_email']; ?>
              </div> 
              <div>Celular: <?= $c['candidato_movil']; ?></div> 
              <div>Tel&eacute;fono: <?= $c['candidato_tel']; ?></div>
            </div>
          </td> 
        </tr>         
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php if (!empty($candidato['ExpeLaboral'])): ?>
            <tr>
              <td valign="top" colspan="2" style="text-align:center;" class="tit">Experiencia profesional</td>
            </tr>
            <?php foreach ($candidato['ExpeLaboral'] as $v): ?>
              <tr>
                <td valign="top" style="padding:10px;width:30%"> 
                  <strong>
                    <?= $this->Time->rango($v['inicio'], $v['fin']); ?>
                  </strong> 
                </td>
                <td valign="top" style="padding:10px;width:70%" class="border">
                  <strong>
                    <?= htmlentities($v['puesto']); ?>
                  </strong>
                  <br>
                  <?= htmlentities($v['empresa']); ?> - <?= htmlentities($v['giro_nombre']); ?>
                  <br>
                  <?= htmlentities($v['funciones']); ?>
                </td>
              </tr>      
            <?php endforeach ?>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php  if (!empty($candidato['Estudios'])): ?>
            <tr>
              <td valign="top" colspan="2" style="text-align:center;" class="tit">Educaci&oacute;n</td>
            </tr>
            <?php foreach ($candidato['Estudios'] as $v): ?>
              <?php
                $titulo = "";
                $titulado = "";
                if ($v['nivel_esc'] > 0 && $v['nivel_esc'] <= 3) {
                  $titulo = $v['nivel_escolar'];
                } else if ($v['nivel_esc'] >= 4 && $v['nivel_esc'] <= 8) {
                  $titulo = $v['carrera'];
                  if ($v['nivel_esc'] >= 6 && $v['nivel_esc'] <= 8) {
                    $titulado = ($v['nivel_esc'] == 8) ? "Titulado.":  "No titulado.";
                  }            
                } else {
                  $titulo = $v['especialidad'];
                }
              ?>
              <tr>
                <td valign="top" style="padding:10px;width:30%"> 
                  <strong>
                    <?= $this->Time->rango($v['inicio'], $v['fin']); ?>
                  </strong>
                </td>        
                <td valign="top" style="padding:10px;width:70%" class="border">
                  <?= htmlentities($titulo); ?>
                  <br />
                  <?= htmlentities($v['instituto']); ?>. <?= $titulado; ?>
                </td>
              </tr>        
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php if (!empty($candidato['Cursos'])): ?>
            <tr>
              <td valign="top" colspan="2" style="text-align:center;" class="tit">Cursos</td>
            </tr>
            <?php foreach ($candidato['Cursos'] as $v): ?>
              <tr>
                <td valign="top" style="padding:10px;width:30%"> 
                  <strong>
                    <?= $this->Time->rango($v['inicio'], $v['fin']); ?>
                  </strong>  
                </td>
                <td valign="top" style="padding:10px;width:70%" class="border">
                  <?= htmlentities($v['nombre']); ?>
                  <br />
                  <?= htmlentities($v['institucion']); ?>.
                </td>
              </tr>
            <?php endforeach ?>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php  if (!empty($candidato['AreasInteres'])): ?>
            <tr>
              <td valign="top" style="padding:10px;;width:30%" >
                <strong>&Aacute;reas de inter&eacute;s: </strong>
              </td>
              <td valign="top" class="border" style="width:70%" >
                <ul>
                  <?php foreach ($candidato['AreasInteres'] as $v): ?>
                    <li> 
                      <?= htmlentities($v['area']); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php if (!empty($candidato['Habilidades'])): ?>
            <tr>
              <td valign="top" style="padding:10px;width:30%">
                <strong>Habilidades:</strong> 
              </td>
              <td valign="top" class="border" style="width:70%">
                <ul>
                  <?php foreach ($candidato['Habilidades'] as $v): ?> 
                    <li> 
                      <?= htmlentities($v['habilidad']); ?>
                    </li>
                  <?php endforeach; ?>
                </ul> 
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php if (!empty($candidato['Conocimientos'])): ?>
            <tr>
              <td valign="top" style="padding:10px;width:30%">
                <strong>Conocimientos adicionales:</strong> 
              </td>
              <td valign="top" class="border" style="width:70%">
                <ul>
                  <?php foreach ($candidato['Conocimientos'] as $v): ?>
                    <li>
                      <?= htmlentities($v['conoc_descrip']); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php if (!empty($candidato['Idiomas'])): ?>
            <tr>
              <td valign="top" style="padding:10px;width:30%">
                <strong>Idiomas:</strong> 
              </td>
              <td valign="top" style="padding:10px;width:70%" class="border">
                <ul>
                  <?php foreach ($candidato['Idiomas'] as $v): ?>
                    <li>
                      <?= htmlentities($v['idioma']); ?> <?= htmlentities($v['nivel']); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </p>
    <p>
      <table class="separate" style="width:100%">
        <tbody>
          <?php if (!empty($candidato['Referencias'])): ?>
            <tr>
              <td valign="top" colspan="2" style="text-align:center;" class="tit">Referencias personales</td>
            </tr>
            <?php foreach ($candidato['Referencias'] as $v): ?>
              <tr>
                <td valign="top" colspan="2" style="padding:10px;">
                  <strong>
                    <?= htmlentities($v['nombre']); ?> 
                  </strong>
                  <div>
                    <?= htmlentities($v['email']); ?> / Tel&eacute;fono:  <?=$v['tipo_movil'] == 1 ? 'Movil' : "Fijo"; ?>  <?= htmlentities($v['tel']); ?>
                  </div>
                </td>
              </tr>
            <?php endforeach  ?>
          <?php endif; ?>
        </tbody>
      </table>
    </p>