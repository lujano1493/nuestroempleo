{{? it.trabajos }}
  {{~it.trabajos :value:index}}
    <h5 class="title-profile">
      {{= value.puesto}}
      <small>{{= value.empresa}}</small>
    </h5>
    <!-- <p><span>Empresa:</span><span></span></p>
    <p><span>Puesto:</span><span></span></p>
    <p><span>Inicio:</span><span>{{= value.periodo}}</span></p> -->
  {{~}}
{{?}}