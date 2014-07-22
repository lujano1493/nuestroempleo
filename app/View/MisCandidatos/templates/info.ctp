<div class="span1">
  <img src="{{= it.foto}}" alt="{{= it.datos.nombre }}" width='50'>
</div>
<a href="/candidatos/{{= it.id}}/perfil" data-item-id="{{= it.id}}" data-component='ajaxlink' data-ajaxlink-role='html'>
{{= it.datos.nombre }}<br>
{{= it.datos.edad }}<br>
{{? it.perfil }}
    {{= it.perfil }}
{{?}}
</a><br>
<div class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
    <i class="icon-eye-open"></i>Detalles
  </a>
  <ul class="dropdown-menu_empresas" role="menu" aria-labelledby="dLabel">
    <li><span>Nombre:</span><span>{{= it.datos.nombre }}</span></li>
    <li><span>Edad:</span><span>{{= it.datos.edad }}</span></li>
    <li><span>Edo. Civil:</span><span>{{= it.datos.edo_civil }}</span></li>
    <li><span>Ubicaci&oacute;n:</span><span>{{= it.datos.ubicacion }}</span></li>
    <li><span>Cel.:</span><span>{{= it.datos.telefono }}</span></li>
    <li><span>Email:</span><span>{{= it.datos.email }}</span></li>
    {{? it.adquirido }}
      <li>
        <a href="/mis_candidatos/{{= it.id}}/curriculum.pdf" style="color:#ffffff;text-decoration:underline;" target='_blank'>Currículum</a>
      </li>
    {{?}}
  </ul>
</div>
<div class="badges" data-item-id="{{= it.id }}">
  {{? it.adquirido }}
    <span class="badge badge-important">Adquirido</span>
  {{?}}
  {{? it.favorito }}
    <span class="badge badge-warning">Favorito</span>
  {{?}}
</div>