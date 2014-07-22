<li class="answer">
  <div class="input">
    <input name="data[Preguntas][{{= it.__q}}][Respuestas][{{= it.__r}}][opcpre_nom]" placeholder="Escribe la respuesta"
      data-target-name="question{{= it.__q}}-answer{{= it.__r}}-title:keyup"
      data-rule-required="true" data-msg-required="Este campo no debe estar vacío." class="answer form-control input-block-level input-sm" maxlength="50"
      type="text" id="preg-{{= it.__q}}-resp-{{= it.__r}}" value="" required="required">
  </div>
  <div class="correct-answer">
    <div class="input checkbox inline">
      <input name="data[Preguntas][{{= it.__q}}][Respuestas][{{= it.__r}}][opcpre_cor]"
        data-rule-checkedone="1" class="validate"
        type="checkbox" value="1" id="preg-{{= it.__q}}-resp-{{= it.__r}}-correct">
      <label for="preg-{{= it.__q}}-resp-{{= it.__r}}-correct">
        <?php echo __('¿Respuesta correcta?'); ?>
      </label>
    </div>
    <a href="#" class="delete-answer" data-answer-id='{{= it.__r}}'>
      <i class="icon-remove-circle"></i>
    </a>
  </div>
</li>