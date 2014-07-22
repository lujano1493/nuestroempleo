<div class="question panel panel-default collapsable" data-question={{= it.__q}}>
  <div class="panel-heading">
    <h4 class="panel-title">
      <a class="accordion-toggle" data-parent="#evaluacion-preguntas" href="#pregunta-{{= it.__q }}">
        Pregunta <span data-component='sequence'>{{= it.__q }}</span>.- <span data-name="question{{= it.__q}}-title"></span>
      </a>
    </h4>
    <div class="toolbar">
      <!-- <div class="input inline text percent-q">
        <label for="pregunta{{= it.__q}}">Porcentaje</label>
        <input name="data[Preguntas][{{= it.__q}}][pregunta_porc]" class="" data-rule-required="true" data-msg-required="Ingresa el porcentaje."
          type="number">
      </div> -->
      <div class="input inline text question-time">
        <label for="pregunta{{= it.__q}}">Tiempo</label>
        <input name="data[Preguntas][{{= it.__q}}][pregunta_tiempo]" class="form-control xs" value="1" min="1" type="number" placeholder="Tiempo">
      </div>
      <div class="btn-group">
        <a class="btn btn-danger" href="#delete-{{= it.__q }}" data-action-role="delete" data-question-id={{= it.__q}}>
          <i class="icon icon-trash"></i>
        </a>
      </div>
    </div>
  </div>
  <div id="pregunta-{{= it.__q }}" class="panel-body" data-action-role="answer">
    <div class="accordion-inner">
      <div class="row">
        <div class="col-xs-12">
          <div class="input text ">
            <!-- <label for="pregunta{{= it.__q}}">Pregunta</label> -->
            <input name="data[Preguntas][{{= it.__q}}][pregunta_nom]" class="question-text form-control input-sm input-block-level" placeholder="Ingresa tu pregunta"
              data-target-name="question{{= it.__q}}-title:keyup" data-rule-required="true" data-msg-required="Ingresa la pregunta."
              maxlength="500" type="text" id="pregunta{{= it.__q}}">
          </div>
        </div>
      </div>
      <ul class="answers clearfix" data-question-id="{{= it.__q }}" data-answers-count=1>
        <li>
          <a href="#" class="add-answer">
            <?php echo __('+ Agregar Respuesta'); ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>