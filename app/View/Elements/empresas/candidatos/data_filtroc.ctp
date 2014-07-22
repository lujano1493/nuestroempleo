<?php
  $expresion = !array_key_exists($query_field, $param_query);
  // $expresion=true;
  $class_base = !$is_parent ? "filtro" : "parent-filtro";
  $icon = $is_parent ? "hand-right" : ($expresion ? "hand-right" : "remove");
  $extra_class = $expresion || $is_parent ? "" : "filtro-select";
  $data_option = $is_parent ? "" :($expresion ? "concat" : "remove");
  $href = !$expresion || $is_parent ? "#" : "/{$this->name}/{$this->action}?$query_field=$value";
?>
<div class="" data-component="tooltip" data-placement="bottom" title="<?=$value?>"  >
  <p>
    <div class="item-filter clearfix">
      <div class="item ellipsis">
        <a class="filtro <?=$extra_class?>" data-field-query="<?=$query_field?>" data-value-query="<?=$value?>" data-option="<?=$data_option?>" href="<?=$href?>">
          <i class=" icon-<?=$icon?>"></i>&nbsp;<?= $value; ?>
        </a>
      </div>
      <span class="badge badge-empresas">
        <?= $data; ?>
      </span>
    </div>
  </p>
</div>