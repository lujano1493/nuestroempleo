(function ($, undefined) {
  "use strict";

  /*  solucion temporal :P*/




  /*fin*/

  var _templates = {}
    , _utils = {
      stripHtml: function (htmlString) {
        return $("<div/>").html(htmlString).text();
      },
      getKey: function (key, value) {
        var keys = key.split('.');

        for (var i = 0, _len = keys.length; i < _len; i++) {
          value = value[keys[i]];
        }
        return value;
      },
      getParam: function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)")
          , results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
      }
    }, checkboxes = function ($el) {
      var $masterCheckbox = $('[type=checkbox]', $el.find('thead'))
        , $bodyChechboxes = $('input[type=checkbox]', $el.find('tbody td'));

      $masterCheckbox
      .off('click.checkboxes')
      .on('click.checkboxes', function () {
        var $this = $(this);
        $bodyChechboxes.prop('checked', $this.is(':checked'));
      });

      $bodyChechboxes
      .off('click.checkboxes')
      .on('click.checkboxes', function () {
        var totalCheckboxes = $bodyChechboxes.size()
          , totalChecked = $bodyChechboxes.filter(':checked').size();

        $masterCheckbox.prop('checked', totalCheckboxes === totalChecked);
      });
    };

  var _callbacks = {
    msgs: {
      onOpen: function (data) {
        var $anchor = this
          , controller= $anchor.data("controller-url") || '/mis_mensajes/';
        $.ajax({
          type: 'POST',
          dataType: 'json',
          data: {},
          url:  controller + data.id + '/leido',
        }).done(function (response) {
          $anchor.find('.unread').hide('fast').closest('tr').removeClass("unread-candidato");
        });
      },
      onRespond: function (data, $trOpen) {

      }
    }
  };

  var Dynamic = function (el, opts) {

    var $el = this.$el = $(el)
      , server_side = this.server_side = $el.data("server-side") || false
      , optimizepag = this.optimizepag = $el.optimizepag()
      , options = this.initOptions(opts)
      , p_url = window.top.location.href.split('?')
      , params_url = this.params_url = p_url.length > 1 ? p_url[1] : '';

    options = server_side ? $.extend(options, {
      fnServerData: $.proxy(optimizepag.fnDataTablesPipeline, optimizepag),
      bProcessing: true,
      bServerSide: true,
      iDisplayLength: $el.data("display-length") || 10,
      aLengthMenu: $el.data("show-menu-length") || [10],
    }): options;

    this.$el.data("params", this.$el.data("params-ini") || []);

    this.$table = $el.dataTable(options)
      .on('draw', $.proxy(this.initComponents, this))
      .on('page', $.proxy(this.changePage, this));

    this.bindEvents();
  }, dynamic = Dynamic.prototype;

  Dynamic.defaults = {
    'lang' : {
      'sSearch'       : 'Buscar',
      'sProcessing'   : '<label> Descargando información ... </labe>',
      'sLengthMenu'   : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mostrar _MENU_ Registros por página',
      'sZeroRecords'  : 'No hay registros.',
      'sInfo'         : 'Mostrando _START_ a _END_ de _TOTAL_ Registros',
      'sInfoEmpty'    : 'Mostrando 0 a 0 de 0 registros',
      'sInfoFiltered' : '(filtrados de _MAX_ registros)',
      'oPaginate'     : {
        'sFirst'    : '<<',
        'sLast'     : '>>',
        'sNext'     : '>',
        'sPrevious' : '<'
      }
    },
    dataProp: 'results',
    afterDraw: function (oSettings) {

    }
  };

  dynamic.replaceQueryString= function (param,value) {
    var self = this
      , re = new RegExp('([?|&])' + param + '=.*?(&|$)', 'i');
    if (self.params_url.match(re)) {
      return '?' + self.params_url.replace(re, '$1' + param + "=" + value + '$2');
    } else {
      return '?' + self.params_url + (self.params_url.length > 0 ? '&' : '') + param + '=' + value;
    }
  };

  dynamic.initOptions = function (opts) {
    var self = this;
    return {
      iDisplayLength: 5,
      aLengthMenu   : [5,10, 25],
      bDeferRender  : true,
      aoColumns     : this.getColumnsDef(),
      oLanguage     : opts.lang,
      sAjaxSource   : this.getUrl(),
      fnServerParams: function (aoData) {
        var data = self.getParams()
          , dinamy_data = self.$el.data('dynamic-params') || null;
        data =dinamy_data || data;

        $(data).each(function (){
          aoData.push(this);
        });
      },
      sAjaxDataProp : opts.dataProp,
      sDom          : '<"table-filters"flr>t<"table-footer"ip>',
      fnDrawCallback: function (oSettings) {
        opts.afterDraw.call(this, oSettings);
      },
      sPaginationType: 'full_numbers',
      fnPreDrawCallback: function () {
        var $pullRight = this.$el.find('thead tr .pull-right')
          , $filters = this.$el.prev('div.table-filters');

        if ($pullRight.size() > 0 && $filters.size() > 0) {
          $filters.appendTo($pullRight);
        }

      }.bind(this),
      fnInitComplete: function (oSettings, json) {
        var page = _utils.getParam('page') || 1;

        if (page && (+page > 1)) {
          $('[data-table-role=main]').dynamicTable('page', page);
        } else {
          $.h('replace.pages', {page: page}, null, self.replaceQueryString("page",page));
        }
      },
    };
  };

  dynamic.bindEvents = function () {
    var self = this;
    this.$el
    .on('error.ajaxlink', function (event, data) {
      var $link = $(event.target)
        , $tr = $link.closest('tr')
        , action = $link.data('action-role')
        , trPosition = self.$table.fnGetPosition($tr[0]);

        $tr.addClass('error');
        setTimeout(function () {
          $tr.removeClass('error');
        }, 500);
    })
    .on('success.ajaxlink', function (event, data) {
      var $link = $(event.target)
        , $tr = $link.closest('tr')
        , action = $link.data('action-role')
        , trPosition = self.$table.fnGetPosition($tr[0]);

      if (action === 'favorite') {
        $.each(data.results.ids, function (index, itemId) {
          var $bContainer = $('.badges[data-item-id=' + itemId + ']')
            , $aContainer = $('.actions[data-item-id=' + itemId + ']')
            , exists = $bContainer.find('.badge-warning').size() >= 1;

          if (!exists) {
            $bContainer.append(data.results.html);
          }
          $aContainer.find('[data-action-role=favorite]').remove();
        });
      } else if (action === 'acquire') {
        $tr.addClass('success');
      } else if (action === 'delete') {
        $tr.addClass('error').hide('slow', function () {
          self.$table.fnDeleteRow(trPosition);
        });
      }
    })
    .on('click.open-row', 'a[data-table-action=open-in-table]', $.proxy(self.openRow, self));
  };

  dynamic.initComponents = function () {
    var self = this;
    $.component('tooltip', this.$el);
    $.component('tablitaaccion',this.$el);

    // $('tbody tr a[data-table-action=open-in-table]', this.$el)
    // .off('click.open-row')
    // .on('click.open-row', $.proxy(this.openRow, this));

    checkboxes(this.$el);
    this.$el.find(".unread").each(function (index, element) {
      $(this).closest('tr').addClass("unread-candidato");
    });
  };

  dynamic.getTemplate = function (template) {
    var fn = null;
    if ((fn = _templates[template]) && $.isFunction(fn)) {
      return fn;
    } else {
      var $template = $(template);

      if ($template.size() === 0) {
        return this.emptyStr.bind(this, 'Plantilla ' + template + ' no existe');
      } else {
        _templates[template] = doT.template($template.html());
      }

      return _templates[template];
    }
  };

  dynamic.renderTemplate = function (template, data) {
    var fn = null
      , flag = template.substring(0,1);
    if (flag === '#') {
      fn = this.getTemplate(template);
      return fn(data);
    } else {
      return _utils.getKey(template, data);
    }
  };

  dynamic.openRow = function (event) {
    var self = this
      , $target = $(event.target).closest('a')
      , $tr = $target.closest('tr')
      , tr = $tr[0]
      , data = self.$table.fnGetData(tr)
      , rowPosition = self.$table.fnGetPosition(tr)
      , prop = $target.data('table-prop')
      , fnName = $target.data('on-open-row')
      , closeCells = function ($item) {
        $item.find('td .opened-row-container').slideUp(100, function () {
          var $trPrev = $(this).closest('tr').prev();
          self.$table.fnClose($trPrev[0]);
        });

        return false;
      }
      , openCells = function (trEl, data, template, fn) {
        var trOpen = this.$table.fnOpen(trEl, '<div class="opened-row-container">' +
            this.renderTemplate(template, data) +
            '</div>', 'opened-row'
          )
          , $trOpen = $(trOpen)
          , $trContainer = $trOpen.find('.opened-row-container').slideDown(100, function () {
            $(this).addClass('open');
            if ($.isFunction(fn)) fn(data, $trOpen);
          });

        return $trOpen;
      };

    if ($tr.data('open-prop') === prop && self.$table.fnIsOpen(tr)) {
      closeCells($tr.next('tr'));
    } else {
      closeCells(self.$table);
      openCells.call(self, tr, data, prop,
        fnName ? _utils.getKey(fnName, _callbacks).bind($target) : null
      ).delegate('[data-table-row-dismiss]', 'click', closeCells.bind(self, $tr.next('tr')));

      $tr.data('open-prop', prop);
    }

    return false;
  };

  dynamic.changePage = function (event, settings) {
    var page = (settings._iDisplayStart / settings._iDisplayLength) + 1;

    if ($.h('state').data.page !== page && this.$table.data('table-role') === 'main') {
      this.page(page, true);
    }
  };

  dynamic.page = function (page, push) {
    var self = this;

    $('html, body').animate({
      'scrollTop': self.$el.offset().top
    }).promise().done(function () {
      if (push) {
        $.h('push.pages', {page: page}, null,self.replaceQueryString("page",page));
      } else {
        self.$table.fnPageChange(-1 + (+page));
      }
    });
  };

  dynamic.getUrl = function () {
    var url = this.$el.data('source-url');

    return url || (document.URL + '.json');
  };

  dynamic.getParams =function (){
    var data =this.$el.data("params");
    return data || null;
  };


  dynamic.emptyStr = function (data) {
    return data || '---';
  };

  dynamic.template = function (template) {
    var self = this;

    return function (source, type, val) {
      var htmlString = self.renderTemplate(template, source);
      if (type === 'filter') {
        return _utils.stripHtml(htmlString);
      } else if (type === 'sort') {
        var $dataOrder = $('<div/>').html(htmlString).find('[data-order]')
          , orderValue = $dataOrder.data('order') + '';

        return $dataOrder.size() > 0 ? orderValue : _utils.stripHtml(htmlString);
      }

      return htmlString;
    };
  };

  dynamic.dom = function (tag) {
    return function (source, type, val) {
      if (type === 'filter') {
        return '';
      }

      if (tag === ':radio') {
        return '<input name="__radio" type="radio" data-input-value=' + source.id + '>';
      }
      return '<input type="checkbox" data-input-value=' + source.id + '>';
    };
  };

  dynamic.stripHtml = function (data) {
    var self = this;
    return function (source, type, val) {

      if (type === 'display') {
        return _utils.getKey(data, source);
      } else if ((type === 'filter' || type === 'sort') && data) {
        return _utils.stripHtml(_utils.getKey(data, source));
      }
      return data;
    };
  };

  dynamic.json = function (data) {
    return function (source, type, val) {
      // if (type === 'display') {
        return _utils.getKey(data, source);
      // } else if ((type === 'filter' || type === 'sort') && data) {
      //   return _utils.stripHtml(_utils.getKey(data, source));
      // }
      // return data;
    };
  };

  dynamic.getColumnFunction = function (prop) {
    var fn = null
      , flag = prop.substring(0,1);
    if (prop.indexOf('.') > 0) {
      fn = this.json(prop);
    } else if (prop.indexOf(' ') > 0) {
      fn = this.emptyStr.bind(this, prop);
    } else if (flag === '#') {
      fn = this.template(prop);
    } else if (flag === ':') {
      fn = this.dom(prop);
    } else if (prop.search(/html/i) > 0) {
      fn = this.stripHtml(prop);
    } else if (!flag) {
      fn = this.emptyStr.bind(this, undefined);
    }

    return fn || prop;
  };

  dynamic.getColumnsDef = function () {
    var self = this;
    return this.$el.find('thead tr th[data-table-prop]').map(function () {
      var $th = $(this)
        , _class = $th.data('table-class');

      return {
        'mData' : self.getColumnFunction($th.data('table-prop')),
        'sClass' : _class || '',
        'bSortable': $th.data('table-order') !== 'none'
      };
    }).get();
  };

  dynamic.closeRows = function ($item) {
    var self = this;
    $item = $item || self.$el;

    $item.find('td .open-row-container').slideUp(100, function () {
      var $trPrev = $(this).closest('tr').prev();
      self.$table.fnClose($trPrev[0]);
    });
  };

  dynamic.updateRow = function ($_tr, data) {
    var self = this
      , tr = $_tr instanceof jQuery ? $_tr[0] : $_tr;

    self.$table.fnUpdate(data, tr, undefined, false);
  };

  $.fn.dynamicTable = function (opts) {
    if ($.isFunction($.fn.dataTable)) {
      var options = 'object' === typeof opts && $.extend(Dynamic.defaults, opts)
        , args = Array.prototype.slice.call(arguments, 1);

      return this.each(function (index) {
        var $this = $(this)
          , dynamic = $this.data('dynamic-table');

        if (!dynamic) {
          $this.data('dynamic-table', (dynamic = new Dynamic(this, options)));
        }

        if ('string' === typeof opts) {
          dynamic[opts].apply(dynamic, args);
        }

      });
    } else {
      console.error('Datatable plugin not exists');
      return this;
    }
  };

  $.component('data-table');
  $.component('dynamic-table');

  $.h('pages', function (state, type, internal) {
    var page = state.data.page || 1;
    $('[data-table-role=main]').dynamicTable('page', page);

    if (internal) {
      //$.ajaxlink('close');
    }
  });

})(jQuery);