{{? it.detalles }}
  <div class="credits nowrap">
    {{~it.detalles :det:index}}
      <a href="#" class='btn btn-sm btn-default' title='{{= det.servicio }}' data-component='tooltip'>
        <i class="icon-credit {{= det._class }}"></i>{{= det.creditos === 'infinity' ? '&infin;' : det.creditos }}
      </a>
    {{~}}
  </div>
{{?}}