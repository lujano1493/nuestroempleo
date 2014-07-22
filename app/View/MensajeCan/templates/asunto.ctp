 <?php 
        $leido= $this->action!='enviados' ? "{{? !it.leido   }}unread {{?}}":"";
 ?>
 <a href="#" class="asunto  <?=$leido?> "  data-action-role='open-in-table' data-table-prop='#tmpl-contenido' data-on-open-row='mark-msg-as-read' 
 	data-controller-url="<?=$this->Html->url(array("controller" => "mensajeCan", "action" => "index"))?>/"  >
    {{= it.asunto }}
    {{? it.importante }}
      <span class="badge badge-important">!</span>
    {{?}}
    <br/>

	


