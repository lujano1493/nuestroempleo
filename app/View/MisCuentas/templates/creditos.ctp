{{? it.creditos }}
  <div class="credits nowrap">
    {{~it.creditos :cred:index}}
      <a href="#" class='btn btn-sm btn-default' title='{{= cred.descripcion}}' data-component='tooltip'>
        <i class="icon-credit {{= cred.id }}"></i>&nbsp;{{= cred.total }}
      </a>
    {{~}}
  </div>
{{?}}