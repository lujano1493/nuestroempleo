  var Calendar = {
    $instance  : null,
    init: function (el) {
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
      $.ajax({
        url: $("#calendar").data("url") || "/eventosCan",
        dataType: 'json',
        data: {
          // our hypothetical feed requires UNIX timestamps
          start: Math.round(start.getTime() / 1000),
          end: Math.round(end.getTime() / 1000),
          estadito: $(".estaditos").val()
        }
      }).done(function (data) {
        fn(data.results);
      });
    },
    loading: function (isLoading,view){
        console.log(this);
        if(isLoading){
          $(this).parent().trigger('create-background-wait.ajax');  
        }else{
          $(this).parent().trigger('remove-background-wait.ajax');  
        }
        

    },
    eventClick: function (event, jsEvent, view) {

        alert("Ingresa como candidato para obtener más información");
      
    },
    eventRender: function(event, element) {
      var title= "<div class=\"\" style='color:#3a87ad;text-align:center'>"+event.title+" </div>";
      var  content="";
      content+="<div class='row-fluid'> <div class='span5'> Tipo de Evento: </div>  <div class='span6'> "+ event.tipo_evento+" </div> </div>";
      content+="<div class='row-fluid'> <div class='span5'> Inicio: </div>  <div class='span6'> "+ event.start_f+" </div> </div>";
      content+="<div class='row-fluid' style='text-align:center'> Para obtener más información sobre el evento ingresa como candidato</div> ";
      $(element).popover({title: title, content:content, trigger: 'hover', placement: 'top',html:true });      
    },
    eventDrop: function (event, dayDelta, minuteDelta, allDay, revert) {
  
    },
    eventResize: function (event, dayDelta, minuteDelta, revert) {
      
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

      this.$instance = $(el);
      this.$instance.fullCalendar(defaultOpts);
    },
    validate: function (start, end, allDay) {    

      return true;
    },
    updateEvent: function (event, data, fn) {
     
    }
  };



    $(document).on('ready', function () {
    Calendar.init('#calendar');

    /* combo de estaditos*/

    $(".estaditos").on("change",function (event) {
        $("#calendar").fullCalendar("refetchEvents");
    });

    $(".estaditos").val($("#estadopref01").val()).trigger('change');    



  });