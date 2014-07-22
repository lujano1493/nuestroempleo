{{? it.detalles }}
  <div class="detalles">
    <ul>
      {{~it.detalles :u:index}}
        <li>
          <span class="">{{= u.producto}}</span>
          <span class="">{{= u.cant}}</span>
        </li>
      {{~}}
    </ul>
  </div>
{{?}}