<form action="/mis_mensajes/{{= it.id }}/responder" class="nofication-emit">
  <fieldset class="row">
    <input type="hidden" name="data[Mensaje][to_user]" value="{{= it.emisor.id }}" id="MensajeToUser">
    <input type="hidden" name="data[Mensaje][user_type]" value="{{= it.emisor.tipo }}" id="MensajeUserType">
    <div class="col-xs-12">
      <div class="input text">
        <input name="data[Mensaje][msj_asunto]" class="form-control input-sm input-block-level" placeholder="Asunto" value="Re: {{= it.asunto }}" maxlength="512" type="text" id="MensajeMsjAsunto" required="required">
      </div>
    </div>
    <div class="col-xs-12">
      <div class="input text">
        <textarea name="data[Mensaje][msj_texto]" class="form-control input-sm input-block-level" style="max-height: 100px; overflow-y:auto;" id="MensajeMsjTexto" placeholder="Escribe tu mensaje.">
        {{= it.contenido }}
        </textarea>
      </div>
    </div>
  </fieldset>
  <div class="btn-actions">
    <a href='/mis_mensajes/{{= it.id }}/responder' class="btn-sm btn-primary">
      <i class="icon-edit"></i>Abrir Editor
    </a>
    <button class="btn btn-sm btn-success" type="submit" data-submit="1">
      <i class="icon-share-alt"></i>¡Enviar!
    </button>
    <a href='/mis_mensajes' class="btn btn-sm btn-warning" data-table-row-dismiss>Cancelar</a>
  </div>
</form>