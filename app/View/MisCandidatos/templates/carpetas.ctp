<ul class="folders list-unstyled" data-item-id='{{= it.id }}'>
  {{~it.carpetas :folder:index}}
    <li data-folderito-id="{{= folder.id }}">
      <a href="/mis_candidatos/{{= folder.slug }}/carpeta">{{= folder.nombre}}</a>
      <a class="text-danger btn btn-xs" href="/mis_candidatos/{{= it.id }}/quitar_de/{{= folder.slug }}" data-component="ajaxlink">&times;</a>
    </li>
  {{~}}
</ul>