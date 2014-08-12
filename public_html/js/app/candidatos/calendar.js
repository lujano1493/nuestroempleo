(function ($, _g, undefined) {
  "use strict";
  var Form = {
    $instance : null,
    $items: null,
    $pickers: {},
    url: null,
    _get: function (itemRole) {
      return this.$items.filter('[data-name=' + itemRole +']');
    },
    init: function (el, callbacks) {
      var $el=this.$instance = $(el);
      this.$items = this.$instance.find('[data-name]');
      this.url = this.$instance[0].action;
      this.callbacks = callbacks;
      this._get('submit').on('click.calendar', $.proxy(this.process, this));
      this.$instance.on('shown', callbacks.onModalShow);     

      this.initPickers();
    },
    initPickers: function () {
      var self = this
        , now = new Date() 
        , $start = self._get('start').datetimepicker({
          dateFormat: 'D, d \'de\' MM, yy',
          minDateTime: now,
          timeFormat: 'hh:mm tt',
          onSelect: function (str, instance) {
            var date = $start.datetimepicker('getDate');
            self._get('start').data('datetime', date);
            $end.datetimepicker('option', 'minDate', date);
          }
        })
        , $end = self._get('end').datetimepicker({
          dateFormat: 'D, d \'de\' MM, yy',
          timeFormat: 'hh:mm tt',
          minDateTime: now,
          onSelect: function (str, instance) {
            var date = $end.datetimepicker('getDate');
            self._get('end').data('datetime', date);
            $start.datetimepicker('option', 'maxDate', date);
          }
        });

      this.$pickers = {
        start: $start,
        end: $end
      };
    },
    addData: function (data) {    
      this._get("evaluacion-title").html(data.cia); 
      this._get("evento-name").html(data.title);
      this._get("evento-type").html(data.tipo_evento);
      this._get("evento-desc").html(data.desc);
      this._get("evento-calle").html(data.calle);
      this._get("evento-dir").html(data.dir);
      this._get("evento-start").html(data.start_f);
      this._get("evento-end").html(data.end_f);
      this._get("contacto").html(data.nombre);
      this._get("correo").html(data.email);
      this._get("telefono").html(data.telefono || '');
      //this._get("telefono").html(data.t);


      this.dataLatlng={lat:data.lat,lng:data.lng};
     
    },
    showEvent: function (data) {
      this.reset();
      this.addData(data);
      var $s=$("#sociales-01"),$p=$("#panel-sociales");    
      $p.hide();
      $s.empty();
      if(data.network){
        $p.show();
         $s.html($.template( "#tmpl-sociales", { link:data.link,title:data.title,label:' el evento ' }  ) );
      }
      this.$instance.modal('show');
    },
    processData: function (results) {
      // var postalCode = results['postal_code'];
      // if (postalCode) {
      //   alert('Aleluya ' + postalCode + '!');
      // } else {
      //   alert('No se ha encontrado el código postal de esta zona.');
      // }

      // Form._get('cp').val(postalCode);
      // Form._get('lat').val(results['lat']);
      // Form._get('lng').val(results['lng']);
      // Form._get('dir').val(results['formatted_address']);
    },
    reset: function () {
      this.$instance[0].reset();
    },
    close: function () {
      this.$instance.modal('hide');
      this.reset();
    },
    save: function (formData, fn) {
      var self = this;
      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: formData,
        url: this.url,
      }).done(function (data) {
        self.$instance.modal('hide'); 
        fn(formData);
      });
    },
    newEvent: function (start, end, allDay) {
      this.$instance.modal('show');
      this._get('start').data('datetime', start).datetimepicker('setDate', start);
      this._get('end').data('datetime', end).datetimepicker('setDate', end);
    },
    process: function () {
      var self = this
        , title = this._get('title').val()
        , data = {
          title: title,
          start: this._get('start').data('datetime'),
          end: this._get('end').data('datetime'),
          desc: this._get('desc').val(),
          dir: this._get('dir').val(),
          postal_code: this._get('cp').val(),
          latitud: this._get('lat').val(),
          longitud: this._get('lng').val()
        };

      if (title) {
        this.save(data, $.proxy(this.callbacks.onSuccess, this));
      } else {
        alert('El título es necesario');
      }
    }
  };

  var Calendar = {
    $instance  : null,
    init: function (el) {
      this.$instance = $(el);
      this.$instance.fullCalendar(defaultOpts);
    },
    validate: function (start, end, allDay) {
      // var now = new Date();

      // if (allDay) { now.setHours(0,0,0,0); }
      // if (start < now) {
      //   alert('Inicio es menor que la fecha actual');
      //   return false;
      // }

      return true;
    },
    updateEvent: function (event, data, fn) {
      // $.ajax({
      //   type  : 'PUT',
      //   dataType: 'json',
      //   url   : '/eventos/actualizar/' + event.id + '.json',
      //   data  : data
      // }).done(function (data) {
      //   fn(event);
      // }).fail(function () {
      //   console.log('Error');
      // });
    }
  };

  var Map = {
    instance  : null,
    marker    : null,
    geocoder  : null,
    defaultLocation : null,
    callback  : function (location, results) {
      // console.log('Map callback');
      // console.log(results);
    },
    init: function (el, handleResults) {
      var location = this.defaultLocation = new _g.maps.LatLng(19.351153, -99.085693)
        , mapOpts = {
          center: location,
          zoom: 16,
          mapTypeId: _g.maps.MapTypeId.ROADMAP
        };

      Map.instance = new _g.maps.Map(document.getElementById(el), mapOpts);
      Map.marker = new google.maps.Marker({ position: location, map: Map.instance });
      Map.geocoder = new google.maps.Geocoder();
      Map.callback = handleResults;
      //Map.initListeners();
    },
    initListeners: function () {
     /* _g.maps.event.addListener(Map.instance, 'click', function (e) {
        Map.marker.setPosition(e.latLng);
        Map.marker.setVisible(true);
      });

      _g.maps.event.addListener(Map.marker, 'position_changed', function (e) {
        var location = Map.marker.getPosition();
        Map.getData(location);
      });*/
    },
    refresh: function (loc) {
      if (loc && loc.lat && loc.lng) {
        loc = new google.maps.LatLng(loc.lat, loc.lng);
        Map.marker.setPosition(loc);
        Map.marker.setVisible(true);
      } else {
        loc = Map.defaultLocation;
        Map.marker.setVisible(false);
      }

      _g.maps.event.trigger(Map.instance, 'resize');
      Map.instance.setCenter(loc);
    },   
    /*manipulacion de evento click Map */
    getData: function (location) {
      Map.geocoder.geocode({'latLng': location}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          if (results[1]) {
           Map.processResults(location, results);
          } else {
            alert('No results found.');
          }
        } else {
          alert('Geocoder failed due to: ' + status);
        }
      });
    },
    processResults: function (location, results) {
      var a_c = results[0].address_components
        , info = {
          formatted_address: results[0].formatted_address
        };
      for(var i = 0, _len = a_c.length, name = null; i < _len; i++) {
        name = a_c[i].types[0];
        info[name] = a_c[i].long_name;
      }
      info['lat'] = location.lat();
      info['lng'] = location.lng();
      Map.callback(info);
    },
    getUrl: function () {
    // var url = this.$el.data('source-url');
    return  (document.URL + '.json');
  }
  };

  $(document).on('ready', function () {
    Calendar.init('#calendar');

    /* combo de estaditos*/

    $(".estaditos").on("change",function (event) {
        $("#calendar").fullCalendar("refetchEvents");
    });
    var idEvento=$("#idEvento").val();
    idEvento && $(".estaditos").val($("#estadopref01").val()).trigger('change');    
    Form.init('#event-form', {
      onModalShow: function (event,data) {
        // setTimeout(function (){
        //   $("html, body").animate({
        //     scrollTop: 500
        //   });
        // },1000);
        Map.refresh(Form.dataLatlng ? Form.dataLatlng :undefined);          

      },
      onSuccess: function (data) {
        Calendar.$instance.fullCalendar('renderEvent', data, true);
        this.close();
      }
    });
    Map.init("map-canvas", Form.processData);    
    if(idEvento){
        $.ajax({
        url: "/EventosCan",
        dataType: 'json',
        data: {
                idEvento:idEvento
        },
        }).done(function (data) {             
          var event=data.results;
          Form.showEvent(event[0]);
        });
    }
  });

  var defaultOpts = {
    allDayText: 'Día completo',
    aspectRatio:  2,
    buttonText: {
      prev: "<span class='fc-text-arrow'>&lsaquo;</span>",
      next: "<span class='fc-text-arrow'>&rsaquo;</span>",
      prevYear: "<span class='fc-text-arrow'>&laquo;</span>",
      nextYear: "<span class='fc-text-arrow'>&raquo;</span>",
      today: 'Hoy',
      month: 'Mes',
      week: 'Semana',
      day: 'Día'
    },
    editable: false,
    events: function (start, end, fn) {
      var data={
          // our hypothetical feed requires UNIX timestamps
          start: Math.round(start.getTime() / 1000),
          end: Math.round(end.getTime() / 1000),
          estadito: $(".estaditos").val()
        };        
      $.ajax({
        url: $("#calendar").data("url") ||  "/eventosCan",
        dataType: 'json',
        data: data,
      }).done(function (data) {
        fn(data.results);
      });
    },
    loading: function (isLoading,view){
        if(isLoading){
          $(this).parent().trigger('create-background-wait.ajax');  
        }else{
          $(this).parent().trigger('remove-background-wait.ajax');  
        

        }
        

    },
    eventClick: function (event, jsEvent, view) {

      Form.showEvent(event);
    },
    eventRender: function(event, element) {
      var title= "<div class=\"\" style='color:#3a87ad;text-align:center'>"+event.title+" </div>";
      var  content="";
      content+="<div class='row-fluid'> <div class='span4'> Tipo de Evento: </div>  <div class='span6'> "+ event.tipo_evento+" </div> </div>";
      content+="<div class='row-fluid'> <div class='span4'> Inicio: </div>  <div class='span7'> "+ event.start_f+" </div> </div>";
      content+="<div class='row-fluid'> <div class='span4'> Estado: </div>  <div class='span7'> "+ event.estado+" </div> </div>";
      content+="<div class='row-fluid'> <div class='span4'> Ciudad: </div>  <div class='span7'> "+ event.ciudad+" </div> </div>";
      $(element).popover({title: title, content:content, trigger: 'hover', placement: 'top',html:true });      
    },
    eventDrop: function (event, dayDelta, minuteDelta, allDay, revert) {
      // alert(
      //   event.title + " fue movido " +
      //   dayDelta + " días y " +
      //   minuteDelta + " minutos."
      // );

      // if (!confirm("¿Estás seguro del cambio?")) {
      //   revert();
      // } else {
      //   Calendar.updateEvent(event, {
      //     dayDelta: dayDelta,
      //     minuteDelta: minuteDelta,
      //     allDay: allDay,
      //     type: 'drop'
      //   }, function (evento) {
      //     alert('SUCCES');
      //   });
      // }
    },
    eventResize: function (event, dayDelta, minuteDelta, revert) {
      // alert(
      //   "El final de " + event.title + " se ha pospuesto " +
      //   dayDelta + " días y " +
      //   minuteDelta + " minutos."
      // );

      // if (!confirm("¿Estás seguro del cambio?")) {
      //   revert();
      // } else {
      //   Calendar.updateEvent(event, {
      //     dayDelta: dayDelta,
      //     minuteDelta: minuteDelta,
      //     type: 'resize'
      //   }, function (evento) {
      //     alert('SUCCES');
      //   });
      // }
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

      // Form.newEvent(start, end, allDay);
    },
    selectHelper:true,
  };
})(jQuery, google);