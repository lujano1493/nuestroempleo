<div class="span6 ">
  <table class="table table-bordered element">
    <tbody>
      <tr>
        <td class="span3">
          <img src="{{=it.from.logo}}" alt="{{=it.from.name }}"  width='150px',height='60px'>
        </td>
        <td colspan="2" rowspan="2">
          <div class="title">
            <a href="{{= it.meta.route }}" class="link-historial {{= it.meta.clazz }}" data-id="{{= it.data.id }}" >
                <i class="icon-{{= it.meta.icon }}"></i>&nbsp;
                <strong>{{= it.data.title || ''}}</strong>
            </a>
          </div>
          <div class="text">{{= it.data.body || ''}}</div>
        </td>
      </tr>
      <tr>
        <td class="notificaciones_cursiva">
          {{? !!it.meta.unread }}
            <p class="label no-leido">no leido</p>
          {{? }}
          <p>{{= it.meta.created }}</p>
        </td>
      </tr>
    </tbody>
  </table>
</div>


