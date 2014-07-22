{{? it.para.candidatos }}
  <div class="users">
    {{~it.para.candidatos :u:index}}
      <span class="block">
        <small>{{= u.email}}</small>
        <span class="block">{{= u.nombre}}</span>
      </span>
    {{~}}
  </div>
{{?}}