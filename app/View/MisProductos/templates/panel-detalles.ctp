{{
  var label = 'info';
  switch (it.factura.status.value) {
    case 2: label = 'success';break;
    case 1: label = 'warning';break;
    case -1: label = 'danger';break;
  }
}}
<div class="item slide" data-legend="{{= it.factura.folio }}">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>
        <span class="pull-right label label-{{= label}}">{{= it.factura.status.text }}</span>
        Factura <strong>{{= it.factura.folio }}</strong>
        <small class="block">
          <strong>{{= it.factura.nombre }}</strong>
        </small>
        {{? it.factura.status.value > 0 }}
          <small class="block">
            {{= it.factura.fecha.inicio }} - {{= it.factura.fecha.vencimiento }}
          </small>
        {{? }}
      </h5>
    </div>
    <div class="panel-body">
      {{? it.factura.status.value > 0 }}
        <h5 class="text-center">
          <strong>{{= it.factura.fecha.inicio }} - {{= it.factura.fecha.vencimiento }}</strong>
          <small class="block">Fecha de Activación - Fecha de Vencimiento</small>
        </h5>
      {{? }}
      <div class="btn-actions">
        <a href="/mis_productos/factura/{{= it.factura.folio }}.pdf" class="btn btn-primary btn-sm" target="_blank">
          <?php echo __('Descargar Factura'); ?>
        </a>
      </div>
      <div class="details row">
        <div class="col-xs-4">
          <h5 class="subtitle">
            <i class="icon-list"></i><?php echo __('Datos de Facturación'); ?>
          </h5>
          <ul class="list-unstyled">
            <li>
              <?php echo __('Razon Social:'); ?>
              <span><strong>{{= it.factura.facturacion.empresa }}</strong></span>
            </li>
            <li>
              <?php echo __('RFC:'); ?>
              <span><strong>{{= it.factura.facturacion.rfc }}</strong></span>
            </li>
            <li>
              <?php echo __('Giro:'); ?>
              <span><strong>{{= it.factura.facturacion.giro }}</strong></span>
            </li>
            <li>
              <?php echo __('Ubicación:'); ?>
              <span><strong>{{= it.factura.facturacion.ubicacion }}</strong></span>
            </li>
            <li>
              <?php echo __('Télefono:'); ?>
              <span><strong>{{= it.factura.facturacion.telefono }}</strong></span>
            </li>
          </ul>
        </div>
        <div class="col-xs-4">
          <h5 class="subtitle">
            <i class="icon-list"></i><?php echo __('Información'); ?>
          </h5>
          <ul class="list-unstyled">
            <li>
              <?php echo __('Costo:'); ?>
              <span><strong>{{= it.factura.total }}</strong></span>
            </li>
            <li>
              <?php echo __('Fecha de Contratación:'); ?>
              <span><strong>{{= it.factura.fecha.contratacion }}</strong></span>
            </li>
          </ul>
        </div>
        <div class="col-xs-4">
          {{? it.factura.detalles }}
            <h5 class="subtitle">
              <i class="icon-list"></i><?php echo __('Productos adquiridos'); ?>
            </h5>
            <ul class="list-unstyled">
              {{~ it.factura.detalles :d:i }}
                <li>
                  <h5>
                    <span class="label label-default">{{= d.cant }}</span>&nbsp;&times;
                    {{= d.nombre }}
                  </h5>
                </li>
              {{~}}
            </ul>
          {{? }}
        </div>
      </div>
    </div>
  </div>
</div>