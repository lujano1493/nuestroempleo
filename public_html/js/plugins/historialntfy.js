/* jshint camelcase: false */
(function ($, undefined) {
  'use strict';

  /*var select_panel ={
    evento : 'eventos',
    mensaje :'mensajes',
    evaluacion : 'notificaciones',
    notificacion : 'notificaciones'
  };*/

  /*var callback = {
    'ntfy_to_candidato': function (data) {
      var historialntfy = $('[data-component*="historialntfy"]').data('historialntfy');

      if (!historialntfy) {
        return false;
      }

      var ntfy = data.data
        , from = data.from
        , info = {
          id : ntfy.notificacion_cve,
          no_leido : true,
          link : ntfy.accion,
          titulo : ntfy.notificacion_titulo,
          texto : ntfy.notificacion_texto,
          fecha : ntfy.created,
          cia_nombre : from.cia_nombre,
          cia_logo : from.logo,
          email : from.email,
          tipo : ntfy.tipo,
          icon : ntfy.style.icon,
          clazz : ntfy.style.clazz
        };

      var id_tmpl = '#tmpl-notificacion-historial'
        , html = $.template(id_tmpl, info)
        , id_panel = select_panel[ntfy.tipo]
        , content = $('#' + id_panel + ' .content');

      content.prepend(html);
      content.find('table:first').addClass('nuevo');
      var offset = content.data('offset') || 1;
      content.data('offset', ++offset);

    },
    'ntfy_to_empresa' : function (data) {

    }
  };*/

  var HistorialNtfy = function (el, opts) {
      var $el = this.$el = $(el);

      this.$link = $el.find('.more-ntfy');
      this.role = $el.data('role') || 'candidato';
      this.init();
    }
    , historialntfy = HistorialNtfy.prototype;

  HistorialNtfy.defaults = {

  };

  historialntfy.init = function () {
    var self=this;

    self.$el.find('li.active > a').each(function () {
      self.cargar_div(this);
    });
    self.bind();
  };

  historialntfy.bind = function () {
    var self = this;

    this.$link.on('click',function (event) {
      event.preventDefault();
      self.cargar($(this).closest('.panel'));
    });

    this.$el.find('a[data-toggle="tab"]').each(function (index, a) {
      if (index === 0) {
        return;
      }
      $(this).one('shown', function (e) {
        self.cargar_div(this);
      });
    });
  };

  historialntfy.cargar_div=function(a){
    var $div = $($(a).attr('href'));
    this.cargar($div);
  };

  historialntfy.cargar = function ($div, callback) {
    var self = this
      , $content = $div.find('.content')
      , limit = $content.data('limit') || 10
      , offset = $content.data('offset') || 0
      , tipo = $content.data('type') || ''
      , data = {
          type: tipo,
          limit: limit,
          offset: offset,
          all: 1
        }
      , time = new Date();

    $.ajax({
      type : 'GET',
      dataType : 'json',
      url :     (  self.$el.data("url") ||'/notificaciones/index' ) +"?time=" + time.getTime(),
      data : data,
      beforeSend: function (xhr) {
        $div.trigger('create-background-wait.ajax');
      }
    })
    .done(function (data, textStatus, jqXHR) {
      callback && callback();
      self.done(data, $content);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {

    })
    .always(function (data, textStatus, jqXHR) {
      $div.trigger('remove-background-wait.ajax');
    });
  };

  historialntfy.done=function (data, $content) {
    var items = data.results.items
      // , totales = data.results.totales
      , count = items.length
      , tmpl_id = '#tmpl-notificacion-historial'
      , offset = $content.data('offset') || 0;

    offset += count;

    $content.data('offset', offset);
    $.each(items, function (index, element) {
      var html = $.template(tmpl_id, element);
      $content.append(html);
    });

    var panel = $content.closest('.panel');
    if(count === 0){
      panel.find('a.more-ntfy').remove();
    } else{
      panel.find('a.more-ntfy').show('fast');
    }
  };

  historialntfy.redirect = function (url) {
    if (url) {
      window.location.href = url;
    }
  };

  historialntfy.leido = function (extraData, callback) {
    var self = this
      , data = extraData || {};

    $.ajax({
      type  : 'GET',
      dataType: 'json',
      url   : '/notificaciones/' + data.id + '/leido',
      data  : {},
      beforeSend: function (xhr){

      }
    })
    .done(function (ss, textStatus, jqXHR) {
      callback && callback();
      self.redirect(data.redirect );
    })
    .fail(function (jqXHR, textStatus, errorThrown) {

    })
    .always(function(data, textStatus, jqXHR){

    });
  };


  $(document).on('receiver-ntfy.ntfy', function (event, data) {
    //callback['ntfy_to_' + data.data.para_tipo](data);
  });

  $(document).on('click', '.link-historial', function (event) {
    event.preventDefault();
    var $this = $(this)
      , id = $this.data('id')
      , historialntfy = $this.closest('[data-component*="historialntfy"]').data('historialntfy');

    if (!historialntfy) {
      return false;
    }

    var data= {
      id: id,
      redirect:$this.attr('href')
    };

    historialntfy.leido(data, function () {
      $('a[data-id=' + id + '].ntfy-link').removeClass('no-leido');
      $this.closest('.element').find('.no-leido').hide('fast');
    });
  });

  $.fn.historialntfy = function (opts, args) {
    var options = 'object' === typeof opts && $.extend({}, HistorialNtfy.defaults, opts);

    return this.each(function (index) {
      var $this = $(this)
        , historialntfy = $this.data('historialntfy');

      if (!historialntfy) {
        $this.data('historialntfy', (historialntfy = new HistorialNtfy(this, options)));
      }

      if ('string' === typeof opts) {
        historialntfy[opts].apply(historialntfy, args || []);
      }
    });
  };

  $.component('historialntfy');
})(jQuery);