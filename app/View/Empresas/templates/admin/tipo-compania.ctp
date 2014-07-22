<p>
  <span class="block">{{= it.tipo.text }}</span>
  {{? it.status && it.status.text }}
    <strong>{{= it.status.text }}</strong>
  {{? }}
</p>