/* global doT: true */

(function ($, undefined) {
  "use strict";

  $.validator.addMethod('checkedone', function (value, el, args) {
    var $el = $(el)
      , $answers = $el.closest('ul.answers')
      , $checkboxes = $answers.find('input[type=checkbox]')
      , checkedAtLeastOne = false;

    $checkboxes.each(function () {
      if ($(this).is(":checked")) {
        checkedAtLeastOne = true;
      }
    });

    return checkedAtLeastOne;
  }, 'Debes seleccionar al menos una opción');

})(jQuery);

(function ($, undefined) {
  "use strict";

  var $doc = $(document);

  var Test = function (opts) {
    this.opts = opts;
    this.$el = $(opts.$el);

    this.init();
  }, test = Test.prototype;

  test.on = function (event, handler) {
    this.$el.on(event, handler);
    return this;
  };

  test.init = function () {
    var tmpls = this.opts.templates;
    this.questions = [];
    this.$questions = this.$el.find('[data-role=questions-section]');

    if (this.opts.preview) {
      this.$preview = $(this.opts.preview);
    }

    /**
     * Esteblece como renderer la función que retorna doT.
     * @type {[type]}
     */
    Question.prototype.renders = {
      fn: doT.template($(tmpls.question).html()),
      preview: doT.template($(tmpls.question + '-preview').html())
    };

    Answer.prototype.renders = {
      fn:  doT.template($(tmpls.answer).html()),
      preview: doT.template($(tmpls.answer + '-preview').html())
    };

    this.bindEvents();
  };

  test.bindEvents = function () {
    this.$el.on('click', '[data-action-role=new-question]', $.proxy(this.addQuestion, this));
    //this.$questions.on('keyup', 'input.question-text', $.proxy(this.updateQuestion, this));
    this.$questions.on('click', '[data-action-role=delete]', $.proxy(this.removeQuestion, this));
    this.$questions.on('click', 'a.add-answer', $.proxy(this.addAnswer, this));
    this.$questions.on('click', 'a.delete-answer', $.proxy(this.removeAnswer, this));
  };

  test.initQuestions = function (callback) {
    var self = this
      , $questions = this.$questions.find('.question');

    $questions.each(function (index) {
      var $q = $(this)
        , q = new Question($q, self.$questions);
      self.questions.push(q);
      $q.data('question', q);

      self.$questions.trigger('questionAdded', [q]);
      q.initAnswers();
    });

    callback && callback();
  };

  test.addQuestion = function (event) {
    var id = $.u.rndm()
      , q = new Question(id, this.$questions);

    event.preventDefault();
    this.questions.push(q);
    q.renderToParent();
  };

  // test.updateQuestion = function (event) {
  //   var $input = $(event.target)
  //     , $question = $input.closest('.question')
  //     , $title = $question.find('.question-title');

  //   $title.text($input.val());
  // };

  test.removeQuestion = function (event) {
    var $target = $(event.target)
      , question = this.getQuestionFromDom($target);

    event.preventDefault();
    question.remove();
  };

  test.addAnswer = function (event) {
    var $target = $(event.target)
      , question = this.getQuestionFromDom($target);

    event.preventDefault();
    question.addAnswer();
  };

  test.removeAnswer = function (event) {
    var $target = $(event.target)
      , question = this.getQuestionFromDom($target);

    event.preventDefault();
    question.removeAnswer($target);
  };

  test.getQuestionFromDom = function ($dom) {
    return $dom.closest('.question').data('question');
  };

  /**
   * [Question description]
   * @param {[type]} id [description]
   */
  var Question = function (id, $parent) {
    this.$parent = $parent;
    this.answers = [];

    if (id instanceof jQuery) {
      this.$el = id;
      this.id = this.$el.find('input[data-question-id]').data('question-id');
    } else {
      this.id = id;
      this.$el = null;
    }
  }, question = Question.prototype;

  /**
   * [renderer description]
   * @param  {[type]} data [description]
   * @return {[type]}      [description]
   */
  question.renders = {
    fn: function (data) { return ""; },
    preview: function (data) { return ""; }
  };

  question.render = function (data, _render) {
    var html = "";

    data = data || {};
    data.__q = this.id;

    html = $.trim(this.renders.fn(data));
    this.$el = $($.parseHTML(html));
    this.$answers = this.$el.find('.answers');

    return this.$el.data('question', this);
  };

  question.renderToParent = function (data) {
    this.render(data).appendTo(this.$parent);
    this.$parent.trigger('questionAdded', [this]);
    this.addAnswer();

    return this;
  };

  question.initAnswers = function () {
    var self = this
      , $answerContainer = this.$answers = this.$el.find('.answers')
      , $answers = this.$el.find('li.answer');

    $answers.each(function (index) {
      var $a = $(this)
        , a = new Answer($a, self.id, $answerContainer);
      self.answers.push(a);

      $a.data('answer', a);
      self.$answers.trigger('answerAdded', [a]);
    });
  };

  question.remove = function () {
    this.$el.remove();
    this.$parent.trigger('questionRemoved', [this]);
  };

  question.addAnswer = function () {
    var id = $.u.rndm(4)
      , a = new Answer(id, this.id, this.$answers);

    event.preventDefault();
    this.answers.push(a);

    a.renderToParent();
  };

  question.removeAnswer = function ($target) {
    var answer = this.getAnswerFromDom($target);

    answer.remove();
  };

  question.getAnswerFromDom = function ($dom) {
    return $dom.closest('.answer').data('answer');
  };

  question.preview = function (data) {
    var html = "";

    data = data || {};
    data.__q = this.id;

    html = $.trim(this.renders.preview(data));
    return $.parseHTML(html);
  };

  var Answer = function (id, questionId, $parent) {
    if (id instanceof jQuery) {
      this.$el = id;
      this.id = this.$el.find('input[data-answer-id]').data('answer-id');
    } else {
      this.id = id;
      this.$el = null;
    }

    this.$parent = $parent;
    this.questionId = questionId;
  }, a = Answer.prototype;

  a.renders = question.renders;

  a.render = function (data) {
    var html = "";
    data = data || {};
    data.__q = this.questionId;
    data.__r = this.id;
    html = $.trim(this.renders.fn(data));

    this.$el = $($.parseHTML(html));

    return this.$el.data('answer', this);
  };

  a.renderToParent = function (data) {
    this.$parent
      .find('li:last-child')
      .before(this.render(data));

    this.$parent.trigger('answerAdded', [this]);

    return this;
  };

  a.remove = function () {
    this.$el.remove();
    this.$parent.trigger('answerRemoved', [this]);
  };

  a.preview = function (data) {
    var html = "";
    data = data || {};
    data.__q = this.questionId;
    data.__r = this.id;
    html = $.trim(this.renders.preview(data));

    return $.parseHTML(html);
  };

  var $e = $('#evaluacion')
    , $pregs = $e.find('#evaluacion-preguntas');

  $doc.on('ready', function () {
    if ($e.size() > 0) {
      var test = new Test({
        $el: '#evaluacion',
        preview: '#evaluacion-preview',
        templates: {
          question: '#tmpl-pregunta',
          answer: '#tmpl-respuesta'
        }
      }), $pregsContainer = test.$preview.find('.preguntas-container');

      test.on('questionAdded', function (event, question) {
        $pregsContainer.append(question.preview());
        $.component('sequence');
      }).on('questionRemoved', function (event, question) {
        var $question = $pregsContainer.find('[data-question-id='+ question.id +']')
          , id = question.$el.find('input[data-question-id]').val()
          , inputData = $('#evaluacion').data('input-data') || {
            questions: [],
            answers: []
          };

        id && inputData.questions && inputData.questions.push(id);

        $question.remove();
        $('#evaluacion').data('input-data', inputData);

        $.component('sequence');
      }).on('answerAdded', function (event, answer) {
        $pregsContainer
          .find('[data-question-id='+ answer.questionId +'] > .respuestas-container')
          .append(answer.preview());
      }).on('answerRemoved', function (event, answer) {
        var $answer = $pregsContainer.find('[data-question-id='+ answer.questionId +']').find('[data-answer-id='+ answer.id +']')
          , id = answer.$el.find('input[data-answer-id]').val()
          , inputData = $('#evaluacion').data('input-data') || {
            questions: [],
            answers: []
          };

        id && inputData.answers && inputData.answers.push(id);

        $answer.remove();
        $('#evaluacion').data('input-data', inputData);

      });

      test.initQuestions(function () {
        $('#evaluacion')
          .find('input').change()
          .filter('[data-target-name]').trigger('focus');
      });
    }
  });

  $('[data-eval-option]').on('change', 'input[type=radio]', function (event) {
    var $radio = $(this).filter(':checked')
      , value = $radio.val();

    if (value === 'n') {
      $e.addClass('no-t-time no-q-time');
    } else if (value === 'e') {
      $e.removeClass('no-t-time').addClass('no-q-time');
    } else if (value === 'p') {
      $e.removeClass('no-q-time').addClass('no-t-time');
    }
  });
})(jQuery);