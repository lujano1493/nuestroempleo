<span>
  {{= it.status.str }}
  {{? it.fecha_timbrado }}
    <strong class="block">
      <a href="#" data-action-role='open-in-table' data-table-prop='#tmpl-datos-timbrado'>
        {{= it.fecha_timbrado.str }}
      </a>
    </strong>
  {{?}}
</span>