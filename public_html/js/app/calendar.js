/* global google */
(function ($, _g, undefined) {
  'use strict';

  var Form = {
    $instance : null,
    $title: null,
    $items: null,
    $pickers: {},
    callbacks: {},
    url: null,
    _get: function (itemRole) {
      return this.$items.filter('[data-calendar-role=' + itemRole +']');
    },
    init: function (el) {
      var self = this;
      self.$instance = $(el);
      self.$title = self.$instance.find('#modal-title');
      self.$items = self.$instance.find('[data-calendar-role]');
      self.url = self.$instance[0].action;
      self._get('submit').on('click.calendar', $.proxy(self.submitFn, self));
      self.$instance.on('shown.slide.modal', function () {
        var fn = self.callbacks.shown
          , action = self.$instance.data('action')
          , now = new Date()
          , $start = self._get('start')
          , $end = self._get('end');

        if (!action) {
          action = 'save';
          self.$instance.data('action', 'save');
        }

        if (action === 'save') {
          $start
            .datetimepicker('option', 'minDate', now)
            .datetimepicker('option', 'minDateTime', now);
          $end
            .datetimepicker('option', 'minDate', now)
            .datetimepicker('option', 'minDateTime', now);
        } else {
          $start
            .datetimepicker('option', 'minDate', null)
            .datetimepicker('option', 'minDateTime', null);
          $end
            .datetimepicker('option', 'minDate', null)
            .datetimepicker('option', 'minDateTime', null);
        }

        if ($.isFunction(fn)) {
          fn.call(self, this);
        }
      });

      self.$instance.on('hidden.slide.modal', function () {
        self.$instance.data('action', null);
        self._get('submit').prop('disabled', false);
        self._get('id').val('');
        self.$instance.find('.alert-danger').remove();
        self.reset();
      });
      self.initPickers();
      return self;
    },
    on: function (event, eventHandler) {
      this.callbacks[event] = eventHandler;
      return this;
    },
    initPickers: function () {
      var self = this
        //, now = new Date()
        , $start = self._get('start').datetimepicker({
          dateFormat: 'D, d \'de\' MM, yy',
          //minDateTime: now,
          timeFormat: 'HH:mm \'hrs\'', //'hh:mm tt',
          onSelect: function (str, instance) {
            var date = $start.datetimepicker('getDate');
            self._get('start').data('datetime', date);
            //$end.datetimepicker('option', 'minDate', date);
            $end
              .datetimepicker('option', 'minDate', date)
              .datetimepicker('option', 'minDateTime', date);
          }
        })
        , $end = self._get('end').datetimepicker({
          dateFormat: 'D, d \'de\' MM, yy',
          //minDateTime: now,
          timeFormat: 'HH:mm \'hrs\'',
          onSelect: function (str, instance) {
            var date = $end.datetimepicker('getDate');
            self._get('end').data('datetime', date);
            //$start.datetimepicker('option', 'maxDate', date);
            $start
              .datetimepicker('option', 'maxDate', date)
              .datetimepicker('option', 'maxDateTime', date);
          }
        });

      this.$pickers = {
        start: $start,
        end: $end
      };
    },
    showEvent: function (event) {
      var now = new Date()
        , canEdit = event.start > now;

      this.$title.text('Editar Evento');

      this.reset().fillForm(event);

      if (!canEdit) {
        this.$instance.find('fieldset:first')
        .prepend('<div class="alert alert-danger">No puedes editar el evento.</div>');
      }
      this.$instance.slidemodal('show').data('action', 'update');
      this._get('submit').prop('disabled', !canEdit);
    },
    processData: function (results) {
      var cpName = 'postal_code'
        , postalCode = results[cpName];
      if (!postalCode) {
        alert('No se ha encontrado el código postal de esta zona.');
      }

      Form._get('cp').val(postalCode);
      Form._get('lat').val(results.lat);
      Form._get('lng').val(results.lng);
      Form._get('dir').val(results.direccion);
    },
    fillForm: function (event) {
      var _i = ['title', 'desc', 'dir', 'calle', 'cp', 'lat', 'lng'];

      for (var i = 0, l = _i.length, item = null; i < l; i++) {
        item = _i[i];
        this._get(item).val(event[item]).trigger('change');
      }

      this._get('id').val(event.id);
      this._get('type').val(event.type);
      this.setDates(event.start, event.end);
    },
    reset: function () {
      if (this.validator) {
        this.validator.resetForm();
      } else {
        this.$instance[0].reset();
      }
      this.$instance.find('[type=hidden]').val('');

      return this;
    },
    close: function () {
      this.$instance.slidemodal('hide');
    },
    updateInCalendar: function (data, eventData) {
      var fn = this.callbacks.success
        , evento = Calendar.$instance.fullCalendar('clientEvents', eventData.id).shift();

      evento = $.extend(evento, eventData);
      Calendar.$instance.fullCalendar('updateEvent', evento);
      if ($.isFunction(fn)) {
        fn.call(this, evento, 'update');
      }
    },
    update: function (formData) {
      var self = this;
      formData.id = this._get('id').val();
      $.ajax({
        type: 'PUT',
        dataType: 'json',
        data: {
          'type': 'data',
          'Evento' : formData
        },
        url: '/mis_eventos/actualizar/' + formData.id + '.json',
      }).done(function (data) {
        if (Calendar.exists()) {
          self.updateInCalendar(data, formData);
        }
        $('.alerts-container').alerto('show', data.message);
        self.$instance.trigger('success.update', [data, formData]);
      });
    },
    save: function (formData) {
      var self = this;
      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: formData,
        url: this.url,
      }).done(function (data) {
        var fn = self.callbacks.success;
        formData.id = data.results.id;
        Calendar.$instance.fullCalendar('renderEvent', formData, true);
        $('.alerts-container').alerto('show', data.message);
        if ($.isFunction(fn)) {
          fn.call(self, data, 'save');
        }
      });
    },
    createEvent: function (start, end, allDay) {
      this.$title.text('Nuevo Evento');
      this.$instance.slidemodal('show').data('action', 'save');
      this.setDates(start, end);
    },
    setDates: function (start, end) {
      var now = new Date()
        , isNew = start > now;

      this._get('start').data('datetime', start)
        .datetimepicker('option', 'maxDate', end)
        .datetimepicker('option', 'minDate', isNew ? now : start)
        .datetimepicker('option', 'minDateTime', isNew ? now : start)
        .datetimepicker('setDate', start);
      this._get('end').data('datetime', end)
        .datetimepicker('option', 'minDate', isNew ? now : start)
        .datetimepicker('option', 'minDateTime', isNew ? now : start)
        .datetimepicker('setDate', end);
    },
    submitFn: function () {
      var self = this
        , data = self.getData()
        , action = self.$instance.data('action');

      self.validator = self.$instance.validate({
        debug:true,
        errorElement: 'div',
        errorClass: 'error-msg',
        invalidHandler: function () {
          self._get('submit').prop('disabled', false);
        }
      });

      self._get('submit').prop('disabled', true);

      if (self.$instance.valid()) {
        self[action](data);
      }
    },
    getData: function () {
      var start = this._get('start').data('datetime')
        , end = this._get('end').data('datetime');
      return {
        id    : this._get('id').val() || null,
        title : this._get('title').val(),
        start : $.fullCalendar.formatDate(start, 'yyyy-MM-dd HH:mm:ss'),
        end   : $.fullCalendar.formatDate(end, 'yyyy-MM-dd HH:mm:ss'),
        desc  : this._get('desc').val(),
        dir   : this._get('dir').val(),
        calle : this._get('calle').val(),
        type  : this._get('type').val(),
        cp    : this._get('cp').val(),
        lat   : this._get('lat').val(),
        lng   : this._get('lng').val()
      };
    }
  };

  var Calendar = {
    $instance  : null,
    init: function (el) {
      this.$instance = $(el);
      this.$instance.fullCalendar(defaultOpts);
    },
    validate: function (start, end, allDay) {
      var now = new Date();

      if (allDay) { now.setHours(0,0,0,0); }
      if (start < now) {
        alert('Inicio es menor que la fecha actual');
        return false;
      }

      return true;
    },
    updateEvent: function (event, data, fn) {
      $.ajax({
        type  : 'PUT',
        dataType: 'json',
        url   : '/mis_eventos/actualizar/' + event.id + '.json',
        data  : data
      }).done(function (data) {
        fn(event);
      }).fail(function () {
        console.log('Error');
      });
    },
    exists: function () {
      return this.$instance.size() >= 1;
    }
  };

  var Map = {
    instance  : null,
    marker    : null,
    geocoder  : null,
    defaultLocation : null,
    callback  : function (location, results) {
      console.log('Map callback');
      console.log(results);
    },
    init: function (el, handleResults) {
      var location = this.defaultLocation = new _g.maps.LatLng(19.351153, -99.085693)
        , mapOpts = {
          center: location,
          zoom: 8,
          mapTypeId: _g.maps.MapTypeId.ROADMAP
        }, previewMapOpts = {
          center: location,
          zoom: 14,
          mapTypeId: _g.maps.MapTypeId.ROADMAP
        };

      Map.instance = new _g.maps.Map(document.getElementById(el), mapOpts);
      Map.previewInstance = new _g.maps.Map(document.getElementById(el + '-preview'), previewMapOpts);
      Map.marker = new google.maps.Marker({ position: location, map: Map.instance });
      Map.previewMarker = new google.maps.Marker({ position: location, map: Map.previewInstance });
      Map.geocoder = new google.maps.Geocoder();
      Map.callback = handleResults;
      Map.initListeners();
    },
    initListeners: function () {
      _g.maps.event.addListener(Map.instance, 'click', function (e) {
        Map.marker.setPosition(e.latLng);
        Map.marker.setVisible(true);
      });

      /*_g.maps.event.addListener(Map.instance, 'dragend', function (e) {
        var center = Map.instance.getCenter();
        Map.previewInstance.setCenter(center);
      });*/

      _g.maps.event.addListener(Map.instance, 'center_changed', function (e) {
        var center = Map.instance.getCenter();
        Map.previewInstance.setCenter(center);
      });


      _g.maps.event.addListener(Map.marker, 'position_changed', function (e) {
        var location = Map.marker.getPosition();
        Map.getDataFromLocation(location);
        Map.previewInstance.setCenter(location);
        Map.previewMarker.setPosition(location);
        Map.previewMarker.setVisible(true);
      });
    },
    refresh: function (opts) {
      var loc = opts && (opts.loc || (opts.lat && opts.lng && opts))
        , zoom = opts && opts.zoom;

      if (loc && loc.lat && loc.lng) {
        loc = new google.maps.LatLng(loc.lat, loc.lng);
        Map.marker.setPosition(loc);
        Map.marker.setVisible(true);
        Map.previewMarker.setPosition(loc);
        Map.previewMarker.setVisible(true);
      } else {
        loc = Map.defaultLocation;
        Map.marker.setVisible(false);
      }

      _g.maps.event.trigger(Map.instance, 'resize');
      _g.maps.event.trigger(Map.previewInstance, 'resize');

      Map.instance.setCenter(loc);
      Map.previewInstance.setCenter(loc);

      if (zoom) {
        Map.instance.setZoom(zoom);
        Map.previewInstance.setZoom(zoom);
      }
    },
    getDataFromLocation: function (location) {
      Map.geocoder.geocode({'latLng': location}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          if (results[1]) {
            Map.processResults(location, results);
          } else {
            alert('Google no encontro resultados.');
          }
        } else {
          alert('Geocoder falló debido a: ' + status);
        }
      });
    },
    getDataFromAddress: function (address) {
      Map.geocoder.geocode({'address': address}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          Map.instance.setCenter(results[0].geometry.location);
          Map.instance.setZoom(14);
          Map.marker.setPosition(results[0].geometry.location);
          Map.marker.setVisible(true);
        } else {
          alert('Geocoder falló debido a: ' + status);
        }
      });
    },
    processResults: function (location, results) {
      var addressComponents = results[0].address_components
        , info = this.getAddress(addressComponents);

      if (info.country !== 'México') {
        Form.$instance.find('.alerts-container').alerto('warning', 'No hemos encontrado ese CP en México', 5000);

        Map.refresh({
          zoom: 6
        });
      } else {
        info.lat = location.lat();
        info.lng = location.lng();
        Map.callback(info);
      }
    },
    getAddress: function (addressComponents) {
      var _comp = ['neighborhood', 'sublocality', 'locality', 'administrative_area_level_2', 'administrative_area_level_1', 'country']
        , direccion = []
        , info = {}
        , i = 0
        , _len = 0
        , name = null;

      for (_len = addressComponents.length; i < _len; i++) {
        name = addressComponents[i].types[0];
        info[name] = addressComponents[i].long_name;
      }

      for (i = 0, _len = _comp.length, name = null; i < _len; i++) {
        name = _comp[i];
        if (info[name]) {
          direccion.push(info[name]);
        }
      }

      info.direccion = direccion.join(', ');

      return info;
    }
  };

  $(document).on('ready', function () {
    Calendar.init('#calendar');
    Form.init('#nuevo-evento').on('shown', function () {
      var lat = this._get('lat').val()
        , lng = this._get('lng').val()
        , loc = (lat && lng) ? {
          lat: lat,
          lng: lng
        } : null;

      Map.refresh(loc);

    }).on('success', function () {
      this.close();
    });

    Map.init('map-canvas', Form.processData);

    $('[data-calendar-role=locate]').on('click', function () {
      var cp = Form._get('cp').val();
      if (cp) {
        Map.getDataFromAddress(cp);
      } else {
        alert('El código postal es requerido.');
      }

      return false;
    });
  }).on('click', '[data-edit-event]', function () {
    var $tr = $(this).closest('tr').prev()
      , $table = $tr.closest('table');

    $table.dynamicTable('getData', $tr, function (data) {
      data.start = new Date(data.start);
      data.end = new Date(data.end);
      Form.showEvent(data);
      $('#nuevo-evento').slidemodal('show')
        .off('success.update')
        .one('success.update', function (e, eData, eventData) {
          data = $.extend(data, eventData, eData.results);
          $table.dynamicTable('updateRow', $tr, data);
          Form.close();
        });
    });

    return false;
  });

  var defaultOpts = {
    allDayText: 'Día completo',
    aspectRatio:  2,
    buttonText: {
      prev: '<span class="fc-text-arrow">&lsaquo;</span>',
      next: '<span class="fc-text-arrow">&rsaquo;</span>',
      prevYear: '<span class="fc-text-arrow">&laquo;</span>',
      nextYear: '<span class="fc-text-arrow">&raquo;</span>',
      today: 'Hoy',
      month: 'Mes',
      week: 'Semana',
      day: 'Día'
    },
    editable: true,
    events: function (start, end, fn) {
      $.ajax({
        url: '/mis_eventos/todos.json',
        dataType: 'json',
        data: {
          // our hypothetical feed requires UNIX timestamps
          start: Math.round(start.getTime() / 1000),
          end: Math.round(end.getTime() / 1000)
        }
      }).done(function (data) {
        fn(data.results);
      });
    },
    eventClick: function (event, jsEvent, view) {
      Form.showEvent(event);
    },
    eventDrop: function (event, dayDelta, minuteDelta, allDay, revert) {
      alert(
        event.title + ' fue movido ' +
        dayDelta + ' días y ' +
        minuteDelta + ' minutos.'
      );

      if (!confirm('¿Estás seguro del cambio?')) {
        revert();
      } else {
        Calendar.updateEvent(event, {
          dayDelta: dayDelta,
          minuteDelta: minuteDelta,
          allDay: allDay,
          type: 'drop'
        }, function (evento) {
          alert('SUCCESS');
        });
      }
    },
    eventResize: function (event, dayDelta, minuteDelta, revert) {
      alert(
        'El final de ' + event.title + ' se ha pospuesto ' +
        dayDelta + ' días y ' +
        minuteDelta + ' minutos.'
      );

      if (!confirm('¿Estás seguro del cambio?')) {
        revert();
      } else {
        Calendar.updateEvent(event, {
          dayDelta: dayDelta,
          minuteDelta: minuteDelta,
          type: 'resize'
        }, function (evento) {
          // alert('SUCCESS');
        });
      }
    },
    header : {
      right: 'month,agendaWeek,agendaDay',
      center: 'title',
      left: 'prev,next today'
    },
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
    dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Miér','Jue','Vie','Sáb'],
    // dayClick : function () {
    //   alert('ola k ase?');
    // },
    selectable: true,
    select: function (start, end, allDay) {
      if (!Calendar.validate(start, end, allDay)) {
        Calendar.$instance.fullCalendar('unselect');
        return false;
      }

      Form.createEvent(start, end, allDay);
    },
    selectHelper:true,
  };
})(jQuery, google);