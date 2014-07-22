/* jshint unused: false */
/* jshint sub: true */
(function ($, undefined) {
  'use strict';

  $(document).on('ready', function () {
    $.getJSON('/info/giros.json').done(function (data) {
      $('#giros').magicSuggest({
        emptyText: 'Selecciona el giro de tu empresa.',
        allowFreeEntries: false,
        data: data,
        maxSelection: 1,
        width: 250,
        'element_extra': function (index, value) {
          $('#EmpresaGiroCve').val(value.id);
          return $();
        },
        maxSelectionRenderer: function(v) {
          return '';
        },
      });
    });
  });

  $.getJSON('/admin/reportes/productos_adquiridos.json').done(function (data) {
    $.fn.chartsito && $('#init-chart')
      .css({'width' : '100%', 'height': '300px'})
      .chartsito('render', data, {
        autoHeight: false
      });
  });

  var inputs = function (index, value) {
    var key = value['servicio_cve']
      , $div = $('<div />', {
        'class' : 'inline input number'
      })
      , $servicio = $('<input>', {
        name  : 'data[Detalle]['+ index +'][servicio_cve]',
        type  : 'hidden',
        value : value['servicio_cve']
      }).appendTo($div)
      , $credits = $('<input>', {
        'class': 'form-control input-sm',
        name  : 'data[Detalle]['+ index +'][credito_num]',
        type  : 'number',
        value : value['credito_num'] || $('input[name="data[Membresia][Detalles]['+ key +'][servicio]"]').val() || 1
      }).appendTo($div).on('change', function () {
        value['credito_num'] = $(this).val();
      }).change();

    return $div;
  };

  $('.checkboxinput input[type=checkbox]').on('change', function () {
    var $this = $(this)
      , $parent = $this.closest('.checkboxinput')
      , $text = $parent.find('input[type=text]');

    $text.prop('disabled', !$this.is(':checked'));
  });

  $(document).on('ready', function () {
    $('#membresiaDetalles').suggestito({
      renderer: inputs
    });
  }).on('success.ajaxform', '#anotaciones form', function (e, data) {
    this.reset();
    if(data.results.is_created){
      var $form = $(this)
        , $container = $form.parent()
        , $anotaciones = $container.find('#lista-anotaciones');

      if ($anotaciones.size() === 0) {
        $container.find('.empty').remove();
        $anotaciones = $('<ul></ul>', {
          'class' : 'list-unstyled',
          'id' : 'lista-anotaciones'
        }).appendTo($container);
      }

      $anotaciones.prepend($.template('#tmpl-notas', data.results));
    }
      else{
            $(this).replaceWith($.template('#tmpl-notas',data.results));

      }
    
  }).on('success.ajaxlink', '#lista-anotaciones .nota', function () {
    $(this).remove();
  }).on('click','#anotaciones .edit',function(event){
      event.preventDefault();
      var $container= $(this).closest('.nota'),data=$container.find(".data").data(),
       replace= $.parseHTML( $.template("#tmpl-form-notas",data) ) ;     
        $container.replaceWith(replace);
        $(replace).find(".cancel-edit").data("container",$container);
  }).on('click',"#anotaciones .cancel-edit",function (event){
      event.preventDefault();
      var $this=$(this),$container=$this.closest('.nota');
      $container.replaceWith($this.data("container"));

  }) ;
})(jQuery);