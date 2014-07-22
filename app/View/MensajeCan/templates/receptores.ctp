  {{? it.para.reclutadores }}
    <div class="users remitente">
      {{~it.para.reclutadores :u:index}}
      {{=u.nombre}}<br/>
          <!-- <span class="label label-info" data-replacement="bottom" ><small>Reclutador</small></span> -->
      {{~}}
    </div>
  {{?}}
  {{? it.para.candidatos }}
    <div class="users">
      {{~it.para.candidatos :u:index}}
        <a href="#">
          <span class="badge badge-info" data-component="tooltip" title="{{=u.nombre}}" data-replacement="bottom" >{{= u.email}}</span>
        </a>
      {{~}}
    </div>
  {{?}}