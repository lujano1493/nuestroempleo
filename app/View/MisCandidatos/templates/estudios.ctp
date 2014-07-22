{{? it.estudios }}
  {{~it.estudios :value:index}}
    <h5 class="title-profile">
      {{= value.institucion}}
      {{? value.carrera }}
        <small>{{= value.carrera}}</small>
      {{?}}
    </h5>
  {{~}}
{{?}}