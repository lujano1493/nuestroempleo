/* global AmCharts */
(function ($, am) {
  'use strict';


  var $chartsitoForm = $('#chartsitoForm')
    , $chartsito = $('#chartsito')
    , Chartsito = function (el, options) {
    var $el = this.$el = $(el);
    this.data = $el.data();
    this.opts = options;

    this.init();
  }, chartsito = Chartsito.prototype;

  Chartsito.defaults = {
    autoHeight: true
  };

  chartsito.init = function () {
    var self = this;

    if (self.data.sourceUrl) {
      $.ajax({
        beforeSend: function () {
          self.$el.spin('large');
        },
        dataType: 'json',
        url: self.data.sourceUrl,
      })
      .done($.proxy(this.render, self));
    }
  };

  chartsito.onSuccess = function (data) {
    this.render(data);
  };

  chartsito.render = function (data, opts) {
    var self = this
      , results = data.results
      , parentChart = true
      , mainChart
      , legend;

    opts = $.extend({}, this.opts, opts || {});

    if (opts.autoHeight && results.dataProvider.length > 8) {
      self.$el.css('height', (results.dataProvider.length * 50) + 'px');
    }

    self.$el.spin(false).data('provider', results.dataProvider);

    mainChart = am.makeChart(this.$el.attr('id'), results);

    if (results.type === 'serial') {
      mainChart.addListener('clickGraphItem', function (event) {
        var chart = event.chart
          , dContext = event.item.dataContext
          , _data = dContext._data;

        if (parentChart && _data) {
          if (dContext._legend) {
            legend = $.extend({}, results.legend, {data: dContext._legend});
            chart.addLegend(legend);
          }

          chart.dataProvider = _data;
          parentChart = false;
        } else {
          chart.dataProvider = self.$el.data('provider');
          chart.addLegend(results.legend);
          parentChart = true;
        }

        chart.validateData();
      });
    } else {

    }
  };

  $.fn.chartsito = function (opts) {
    var options = 'object' === typeof opts && $.extend({}, Chartsito.defaults, opts)
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {
      var $this = $(this)
        , chart = $this.data('chart');

      if (!chart) {
        $this.data('chart', (chart = new Chartsito(this, options)));
      }

      if ('string' === typeof opts) {
        chart[opts].apply(chart, args || []);
      }
    });
  };

  $(document).on('ready', function () {
    var $initMonth = $('#initMonth')
      , $finalMonth = $('#finalMonth')
      , $initDate = $('#initDate')
      , $finalDate = $('#finalDate');


    $initMonth.datepicker({
      beforeShow: function () {
        $('#ui-datepicker-div').addClass('no-calendar');
      },
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      maxDate: '-1M',
      minDate: new Date(2013, 0, 1),
      onClose: function(selectedDate, inst) {
        var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val()
          , year = $('#ui-datepicker-div .ui-datepicker-year :selected').val()
          , date = new Date(year, month, 1)
          , tmpDate = $finalMonth.data('date') || new Date();

        $initMonth.data('date', date)
          .datepicker('option', {defaultDate: date})
          .datepicker('setDate', date);

        $finalMonth
          .datepicker('option', {minDate: date})
          .datepicker('setDate', tmpDate);

        $initDate.val($.datepicker.formatDate('yy-mm-dd', date));
        $finalDate.val($.datepicker.formatDate('yy-mm-dd', tmpDate));
      }
    });

    $finalMonth.datepicker({
      beforeShow: function () {
        $('#ui-datepicker-div').addClass('no-calendar');
      },
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      maxDate: 'today',
      minDate: new Date(2013, 0, 1),
      onClose: function(selectedDate, inst) {
        var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val()
          , year = $('#ui-datepicker-div .ui-datepicker-year :selected').val()
          , date = new Date(year, month, 1)
          , tmpDate = $initMonth.data('date') || new Date();

        $finalMonth.data('date', date)
          .datepicker('option', {defaultDate: date})
          .datepicker('setDate', date);

        $initMonth
          .datepicker('option', {maxDate: date, maxDateTime: date})
          .datepicker('setDate', tmpDate);

        $initDate.val($.datepicker.formatDate('yy-mm-dd', tmpDate));
        $finalDate.val($.datepicker.formatDate('yy-mm-dd', date));
      }
    });
  });

  function addExcelLink() {
    var $ul = $chartsito.find('ul > li > ul')
      , $li = $('<li />')
      , $link = $('<a />', {
        href: '#',
        html: 'EXCEL',
        'class': 'excel-btn'
      }).appendTo($li.appendTo($ul))
      , _location = [
          ( $chartsitoForm.data('controller') || '/mis_reportes/'),
        $chartsitoForm.find(':radio:checked').val(),
        '.xls',
        '?finalDate=' + $chartsitoForm.find('#finalDate').val(),
        '&initDate=' + $chartsitoForm.find('#initDate').val()
      ];

    $link.on('click', function () {
      window.location = _location.join('');

      return false;
    });
  }

  $chartsitoForm.on('success.ajaxform', function (event, data) {
    $chartsito
      .css({'width' : '100%', 'height': '400px'})
      .chartsito('render', data);

    addExcelLink();
  });
})(jQuery, AmCharts);