<div class='ntfy unread' data-id="{{= it.data.id }}">
  <img src="{{=it.from.logo}}">
  <div class="ntfy-body">
    <strong class="title">{{= it.data.title }}</strong>
    <small>{{= it.data.body }}</small>
  </div>
  <div class="ntfy-footer">
    <a href="{{= it.meta.route }}" class="ntfy-link">
      <i class="icon-time"></i>&nbsp;{{= it.meta.created }}
    </a>
  </div>
</div>