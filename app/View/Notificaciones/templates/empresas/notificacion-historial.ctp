<div class="row">
  <div class="col-xs-12">
    <div class="row ntfy-history">
      <div class="col-xs-9">
        <img class="user-img" src="{{= it.from.logo }}" alt="" width="80px">
        <div class="">
          <h4 class="alert-ntfy">
            <a href="{{= it.meta.route }}" class="link-historial {{= it.meta.clazz }}" data-id="{{= it.data.id }}" >
              <i class="icon-{{= it.meta.icon }}"></i>&nbsp;{{= it.data.title || '' }}
            </a>
          </h4>
          <div class="text">
            {{= it.data.body || '' }}
          </div>
        </div>
      </div>
      <div class="col-xs-3">
         <div class="date">
          <p>{{= it.meta.created }}</p>
          {{? !!it.meta.unread }}
            <p class="label no-leido">no leido</p>
          {{? }}
        </div>
      </div>
    </div>
  </div>
</div>


