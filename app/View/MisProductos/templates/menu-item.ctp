{{
  var label = 'info';
  switch (it.factura.status.value) {
    case 2: label = 'success';break;
    case 1: label = 'warning';break;
    case -1: label = 'danger';break;
  }
}}
<a href="#" class="{{= it.factura.classId }}">
  <span class="pull-right label label-{{= label}}">{{= it.factura.status.text }}</span>
  {{= it.factura.nombre }}
  <small class="block">Activación: {{= it.factura.fecha.inicio }}</small>
  <small class="block">Vence: {{= it.factura.fecha.vencimiento }}</small>
  <strong class="block">Folio: {{= it.factura.folio }}</strong>
</a>
