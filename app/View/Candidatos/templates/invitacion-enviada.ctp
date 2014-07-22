{{##def.completo:user:
  <div class="clearfix col-xs-4">
    <img class="pull-left" src="{{=user.foto_url}}" alt="" width="50" style="margin:5px;">
    <h4>
      <a href="/candidatos/{{=user.perfil.slug}}/perfil" style="color:inherit;" data-component="ajaxlink" data-magicload-target="#main-content">
        {{=user.perfil.nombre}}
        <small class="block">{{=user.nombre}}</small>
        <span class="label label-success">{{=user.email}}</span>
      </a>
    </h4>
  </div>
#}}

{{##def.incompleto:user:
  <div class="clearfix col-xs-3">
    <h4>
      {{=user.nombre}}
      <span class="label label-warning">{{=user.email}}</span>
    </h4>
  </div>
#}}

{{##def.inactivo:user:
  <div class="clearfix col-xs-3">
    <h4>
      {{=user.nombre}}
      <span class="label label-danger">{{=user.email}}</span>
    </h4>
  </div>
#}}

{{##def.sin_registro:user:
  <div class="clearfix col-xs-3">
    <h4>
      {{=user.nombre}}
      <span class="label label-info">{{=user.email}}</span>
    </h4>
  </div>
#}}

{{ var types = {
    sin_registro : {
      'class': 'alert-info',
      'title': 'Candidatos sin Registro en Nuestro Empleo'
    },
    inactivos   : {
      'class':'alert-danger',
      'title': 'Candidatos Inactivos'
    },
    incompletos : {
      'class':'alert-warning',
      'title': 'Candidatos con perfil incompleto'
    },
    completos   : {
      'class':'alert-success',
      'title': 'Candidatos con perfil completo'
    }
  };
}}

{{?it.users.length > 0}}
  <div class="alert {{=types[it.type]['class']}}">
    {{=types[it.type]['title']}}
    <div class="row" style="margin-bottom:0px;">
      {{~it.users :user:i}}
        {{? it.type === "sin_registro"}}
          {{#def.sin_registro:user}}
        {{??it.type === "incompletos"}}
          {{#def.incompleto:user}}
        {{??it.type === "inactivos"}}
          {{#def.inactivo:user}}
        {{??it.type === "completos"}}
          {{#def.completo:user}}
        {{?}}
      {{~}}
    </div>
  </div>
{{?}}