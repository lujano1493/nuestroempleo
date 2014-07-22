(function ($, undefined) {
  'use strict';

  var columnFn = {
    str : function (_str) {
      return _str || '---';
    },
    tmpl: function (_tmpl) {
      return function (source, type, val) {
        var htmlStr = $.template(_tmpl, source);

        if ('filter' === type) {
          return $.u.stripHtml(htmlStr);
        } else if ('sort' === type) {
          var $dataOrder = $('<div />').html(htmlStr).find('[data-order]')
            , orderVal = $dataOrder.data('order') + '';

          return $dataOrder.size() > 0 ? orderVal : $.u.stripHtml(htmlStr);
        }

        return htmlStr;
      };
    },
    dom: function (tag) {
      return function (source, type, val) {
        if ('set' === type) {
          var selectedItems = (this.$el.data('selected-items') + '').split(',')
            , checked = $.inArray(source.id + '', selectedItems) !== -1;

          source.checked = checked ? 'checked' : '';
        } else if ('sort' === type) {
          var isChecked = this.$el.find('[data-input-value=' + source.id +']').is(':checked');
          source.checked = source.checked || (isChecked ? 'checked' : '');

          return source.checked === 'checked' ? 1 : 0;
        } else {
          if (tag === ':radio') {
            return '<input name="__radio" type="radio" data-input-value=' + source.id + ' ' + source.checked +'>';
          } else {
            return '<input type="checkbox" data-input-value=' + source.id + ' ' + source.checked + '>';
          }
        }
      };
    }
  };

  var Dynamic = function (el, opts) {
    var $el = this.$el = $(el)
      , serverSide = this.serverSide = $el.data('server-side') || false
      , options = this.initOptions(opts);

    serverSide && (options = $.extend(options, this.configSideServer()));
    $el.find('[data-table-prop]').each(function (index, element){
      var $this = $(this)
        , order = $this.data('order');

      order && options.aaSorting.push([index, order]);
    });

    options.aaSorting.length === 0 && options.aaSorting.push([0,'asc']);
    this.$table = $el.dataTable(options)
      .on('page', $.proxy(this.changePage, this))
      .on('processing', function (event, instance, show) {
        show && $el.find('.dataTables_processing').spin('small');
        !show && $el.find('.dataTables_processing').spin(false);
      });
    this.bindEvents();
  }, dynamic = Dynamic.prototype;

  Dynamic.defaults = {
    afterDraw: function (settings) {

    },
    dataProp: 'results',
    displayLength: 5,
    dom: '<"table-filters"rfl>t<"table-footer"ip>',
    itemIdProp: 'id',
    lang: {
      'sSearch'       : 'Buscar',
      'sProcessing'   : '<label style="margin-left:35px;"></labe>',
      'sLengthMenu'   : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mostrar _MENU_ Registros por página',
      'sZeroRecords'  : 'No hay registros.',
      'sEmptyTable'   : 'Tabla vacía.',
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
    lengthMenu: [5, 10, 25],
    pagType: 'full_numbers'
  };

  dynamic.callbacks={
    deleteRow: function (event, ids) {
      var self = this
        , $link = $(event.target)
        , $tr = $link.closest('tr')
        , delRow = function ($tr) {
          var pos = self.$table.fnGetPosition($tr[0]);

          $tr.addClass('error').hide('slow', function () {
            self.$table.fnDeleteRow(pos);
          });
        };

      if (ids) {
        for (var i = ids.length - 1; i >= 0; i--) {
          $tr = self.$table.find('tr[data-item-id=' + ids[i] + ']');
          $tr && delRow($tr);
        }
      } else {
        $tr.hasClass('open-row') && ($tr = $tr.prev('tr'), self.closeRows());

        delRow($tr);
      }
    }

  };

  dynamic.configSideServer = function () {
    if(!$.isFunction($.fn.optimizepag)) {
      console.log('falta agregar plugin para optimizar paginación');
      return false;
    }

    var self = this
      , $el = this.$el
      , optimizepag = this.optimizepag = $el.optimizepag()
      //, pUrl = window.top.location.href.split('?')
      //, paramsUrl = this.paramsUrl = pUrl.length > 1 ? pUrl[1] : ''
      , options = {
        fnServerData: $.proxy(optimizepag.fnDataTablesPipeline, optimizepag),
        bProcessing: true,
        bServerSide: true,
        iDisplayLength: $el.data('display-length') || 10,
        aLengthMenu: $el.data('show-menu-length') || [10],
        fnServerParams: function (aoData) {
          var data = self.$el.data('params')
            , dynamicData = self.$el.data('dynamic-params') || null;

          data = dynamicData || data;
          $(data).each(function (){
            aoData.push(this);
          });
        }
      };

    /* obtenemos condiciones inciales para realizar peticiones en la paginacion */
    this.$el.data('params', this.$el.data('params-ini') || []);
    return options;
  };


  dynamic.bindEvents = function () {
    var self = this;

    self.$el
    .on('error.ajaxlink', function (event, data) {
      var $link = $(event.target)
        , $tr = $link.closest('tr');

      $tr.addClass('error');
      setTimeout(function () {
        $tr.removeClass('error');
      }, 500);
    })
    .on('success.ajaxlink', function (event, data) {
      if (data.callback) {
        var fn = self.callbacks[data.callback.fn]
          , args = data.callback.args || [];
        args.unshift(event);
        fn && fn.apply(self, args);
      }
    })
    .on('click', 'a[data-action-role=open-in-table]', function (event) {
      var $link = $(this)
        , $tr = $link.closest('tr')
        , template = $link.data('table-prop');

      $tr.hasClass('open-row') && ($tr = $tr.prev('tr'));

      if ($tr.data('open-prop') === template && self.$table.fnIsOpen($tr[0])) {
        self.closeRows($tr.next('tr'));
      } else {
        self.closeRows();
        self.openRow($tr, template, this);
      }

      return false;
    });
  };

  dynamic.initOptions = function (opts) {
    var self = this;
    return {
      aaSorting: [],
      aLengthMenu: opts.lengthMenu,
      aoColumns: self.getColDefinitions(),
      bDeferRender: true,
      bProcessing: true,
      fnInitComplete: function (oSettings, json) {
        self.$el.trigger('dynamic.init');
      },
      fnDrawCallback: function (oSettings) {
        opts.afterDraw.call(this, oSettings);
        self.$el.trigger('dynamic.draw');
      },
      fnPreDrawCallback: function () {
        var $pullRight = this.$el.find('thead tr .pull-right')
          , $filters = this.$el.prev('div.table-filters');

        if ($pullRight.size() && $filters.size()) {
          $filters.appendTo($pullRight);
        }
        self.$el.find('.dataTables_processing').spin('small');
      }.bind(this),
      fnRowCallback: function (row, data, index, indexFull) {
        var itemId = data[opts.itemIdProp]
          , $row;
        itemId && ($row = $(row).attr('data-item-id', itemId));
      },
      iDisplayLength: opts.displayLength,
      oLanguage: opts.lang,
      sAjaxDataProp : this.$el.data('prop') || opts.dataProp,
      sAjaxSource: this.getSourceURL(),
      sDom: opts.dom,
      sPaginationType: opts.pagType
    };
  };

  dynamic.changePage = function (event, settings) {
    var page = (settings._iDisplayStart / settings._iDisplayLength) + 1;

    if (/*$.h('state').data.page !== page &&*/ this.$table.data('table-role') === 'main') {
      this.page(page, true);
    }
  };

  dynamic.page = function (page, push) {
    var self = this;

    $('html, body').animate({
      'scrollTop': self.$el.offset().top
    }).promise().done(function () {
      /*if (push) {
        $.h('push.pages', {page: page}, null,self.replaceQueryString("page",page));
      } else {
        self.$table.fnPageChange(-1 + (+page));
      }*/
    });
  };

  dynamic.getSourceURL = function () {
    var url = this.$el.data('source-url');
    return url || (document.URL + '.json');
  };

  dynamic.getColType = function (prop) {
    var fn = null
      , flag = prop.substring(0, 1);

    if (prop.indexOf(' ') > 0) {
      fn = columnFn.str.bind({}, prop);
    } else if (flag === '#') {
      fn = columnFn.tmpl(prop);
    } else if (flag === ':') {
      fn = columnFn.dom(prop);
    } /*else if (prop.search(/html/i) > 0) {
      fn = this.stripHtml(prop);
    }*/ else if (!flag) {
      fn = columnFn.str.bind({}, undefined);
    }

    return (fn && fn.bind(this)) || prop;
  };

  dynamic.getColDefinitions = function () {
    var self = this;
    return this.$el.find('thead tr th[data-table-prop]').map(function () {
      var $th = $(this)
        , data = $th.data()
        , _class = data.tableClass
        , type = data.dataType || (data.tableProp.substring(0, 1) === ':' ? 'numeric' : null);

      return {
        'sType' : type,
        'mData' : self.getColType(data.tableProp),
        'sClass' : _class || '',
        'bSortable': data.tableOrder !== 'none'
      };
    }).get();
  };

  dynamic.openRow = function ($tempTr, template, domEl) {
    var self = this
      , $tr = $tempTr instanceof jQuery ? $tempTr : $($tempTr)
      , tr = $tr[0]
      , data = self.getData(tr)
      , $rowContainer = $('<div></div>', {
        'class' : 'open-row-container',
        'html' : $.template(template, data)
      })
      , trOpened = self.$table.fnOpen(tr, $rowContainer, '')
      , $trOpened = $(trOpened);

    $trOpened.addClass('open-row').find('td .open-row-container').slideDown(100, function () {
      $tr.data('open-prop', template).trigger('opened-row.dynamic', [domEl, data]);
    }).delegate('[data-table-row-dismiss]', 'click', function () {
      self.closeRows($trOpened);

      return false;
    });
  };

  dynamic.getDataByID = function (id, callback) {
    var $tr = this.$el.find('tr[data-item-id=' + id +']');

    return this.getData($tr, callback);
  };

  dynamic.getData = function ($tempTr, callback) {
    var tr = $tempTr instanceof jQuery ? $tempTr[0] : $tempTr
      , data = this.$table.fnGetData(tr);

    $.isFunction(callback) && callback(data);
    return data;
  };

  dynamic.closeRows = function ($item) {
    var self = this;
    $item = $item || self.$el;

    $item.find('td .open-row-container').slideUp(100, function () {
      var $trPrev = $(this).closest('tr').prev();
      self.$table.fnClose($trPrev[0]);
    });
  };

  dynamic.updateRow = function ($tempTr, data) {
    var self = this
      , tr = $tempTr instanceof jQuery ? $tempTr[0] : $tempTr;

    self.$table.fnUpdate(data, tr, undefined, false);
  };

  $.fn.dynamicTable = function (opts) {
    if ($.isFunction($.fn.dynamicTable)) {
      var options = $.extend({}, Dynamic.defaults, 'object' === typeof opts ? opts : {})
        , args = Array.prototype.slice.call(arguments, 1);

      return this.each(function (index) {
        var $this = $(this)
          , table = $this.data('dynamic-table');

        if (!table) {
          $this.data('dynamic-table', (table = new Dynamic(this, options)));
        }

        if ('string' === typeof opts) {
          table[opts].apply(table, args || []);
        }
      });
    } else {
      console.error('Datatable plugin not exists.');
      return this;
    }
  };

  $.component('dynamic-table');
})(jQuery);