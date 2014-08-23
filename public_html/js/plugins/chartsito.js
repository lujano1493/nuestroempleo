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
    var options = $.extend({}, Chartsito.defaults, 'object' === typeof opts ? opts : {})
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
      , $finalDate = $('#finalDate')
      , $dateFormat=$('#date-format')
      , optionsInitMoth={
      beforeShow: antesDemostrar,
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      maxDate: '-1M',
      minDate: new Date(2013, 0, 1),
      onClose: function(selectedDate, inst) {
        var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val()
          , year = $('#ui-datepicker-div .ui-datepicker-year :selected').val()
          , format= $dateFormat.val() || 2
          , date = new Date(year, month, +format===2 ? 1: inst.currentDay )
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
    }, 
    optionsEndMoth={
      beforeShow: antesDemostrar,
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      maxDate: 'today',
      minDate: new Date(2013, 0, 1),
      onClose: function(selectedDate, inst) {
        var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val()
          , year = $('#ui-datepicker-div .ui-datepicker-year :selected').val()
          , format= $dateFormat.val() || 2
          , date =  new Date(year, month,  +format===2 ? 1: inst.currentDay )
          , tmpDate = $initMonth.data('date') || new Date();

        $finalMonth.data('date', date)
          .datepicker('option', {defaultDate: date})
          .datepicker('setDate', date);

        $initMonth
          .datepicker('option', {maxDate:date})
          .datepicker('setDate', tmpDate);

        $initDate.val($.datepicker.formatDate('yy-mm-dd', tmpDate));
        $finalDate.val($.datepicker.formatDate('yy-mm-dd', date));
      }
    }; // Si no hay seleccion de formato por default agrega el de meses


    $initMonth.datepicker( optionsInitMoth );

    $finalMonth.datepicker(optionsEndMoth);

    function antesDemostrar(){
        var formatDate=+($dateFormat.val() || 2);        
        $('#ui-datepicker-div')[formatDate===2 ? 'addClass':'removeClass']('no-calendar');    
    }

    $dateFormat.change(function (){
        var formatDate=$(this).val()
        , dateFormat= +formatDate ===2 ? 'MM yy': 'dd MM yy'
        , format={dateFormat:dateFormat};
        /**
          hola si estas viendo este desmadre es por que se supone que namas con cambiariar el formato a nuestro datapicker actual en teoria 
          debe funcionar pero no fue asi pinche datepicker, entonces el codigo que sigue, elimina y crea un nuevo datapicker con las mismas opciones solo cambiando el
          formato a mostrar. 
        */
        $initMonth.datepicker('destroy');
        $finalMonth.datepicker('destroy');
        $initMonth.datepicker($.extend(optionsInitMoth,format) );
        $finalMonth.datepicker($.extend(optionsEndMoth,format) );
        $initMonth.datepicker('setDate',$.datepicker.parseDate( 'yy-mm-dd',$initDate.val()) ); 
        $finalMonth.datepicker('setDate',$.datepicker.parseDate( 'yy-mm-dd',$finalDate.val()) ); 
    }).trigger('change');

    /**
     * control de input dependiendo de la seleccion de reporte
     * @type {[type]}
     */
    var groupRadios= $chartsitoForm.data('radios-group');
    if(!groupRadios){
      return false;
    }
    groupRadios=$(groupRadios);
    var options= groupRadios.data();
    groupRadios.find(':radio').click(function(event) {
      var $check=groupRadios.find(':radio:checked');
      $(options.elementName)[$check.val()===options.option? 'show' :'hide'  ](100);
    });

  });

  function addExcelLink() {
    var $ul = $chartsito.find('ul > li > ul')
      , nameGroup= $chartsitoForm.data('radios-group')||''
      , $li = $('<li />')
      , $link = $('<a />', {
        href: '#',
        html: 'EXCEL',
        'class': 'excel-btn'
      }).appendTo($li.appendTo($ul))
      , _location = [
          ( $chartsitoForm.data('controller') || '/mis_reportes/'),
        $chartsitoForm.find( nameGroup+' :radio:checked').val(),
        '.xls',
        '?finalDate=' + $chartsitoForm.find('#finalDate').val(),
        '&initDate=' + $chartsitoForm.find('#initDate').val()
      ];
      var fd= +( $('#date-format').val() || 2);
      if(fd!==2){
        _location.push('&formatoCalendario='+fd);
      }
      /**
       *  parametros para reportes de internos administración
       */
             
      if( $chartsitoForm.find('.tipo :checked').length >0){
        _location.push('&tipo='+$chartsitoForm.find('.tipo :checked').val());
      }
      if( nameGroup.length >0){
          var group=$(nameGroup),options=group.data(),$f=$(options.elementName);          
          if($f.is(':visible')){
            var val=  $f.find('select').val();
          _location.push('&usuario='+val);  
          }    
      }

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