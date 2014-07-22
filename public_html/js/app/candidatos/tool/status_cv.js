 

$(document).ready(function ($){
  /*cargando foto */
  cargarFoto();
  /*porcentaje circular*/


             /*evento ejecutando en los form al detectar que el data a sido obtenido*/

    $(document).on("click","#status-cv",function (event){
        event.preventDefault();
        var $this=$(this);
       $.getJSON( $this.attr("href") + "?time="+ (new Date()).getTime() ,  function (data){ 
                var result=data.results;

                $(".status-candidato .percentage").data("easyPieChart").update(result.porcentaje);
                $(".status-candidato  .text").html(data.content);
                // $(".status-candidato").attr("title",data.text);
                //   if ($(".status-candidato").data('tooltip') != null) {
                //       $(".status-candidato").tooltip('hide');
                //       $(".status-candidato").removeData('tooltip');
                //   }  
                //    $(this).tooltip();



        } );


    });

   
   $(document).on("receiver-ntfy.ntfy",function (event,data){
          var info=data.data;
          if(info.tipo='notificacion' && info.notificacion_titulo=="Han visto tu perfil"){
              $("#visitas-cv01").each (function (){
                 var $this=$(this), inc= $this.data("value") +1 ;
                 $this.attr("data-value",inc).html(inc);
              });
          }


   });


  $("#status-cv").trigger("click");

 $(document).on("success.ajaxform delete-success.ajaxform","form",function (event){
      $("#status-cv").trigger("click");
  });







  $('.percentage').easyPieChart({
                animate: 1000,
                onStep: function(value) {
                    this.$el.find('span').text(Math.round(value));
                }
            });

  //           $('.percentage-light').easyPieChart({
  //               barColor: function(percent) {
  //                   percent /= 100;
  //                   return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(255 * percent) + ", 0)";
  //               },
  //               trackColor: '#666',
  //               scaleColor: false,
  //               lineCap: 'butt',
  //               rotate: -90,
  //               lineWidth: 15,
  //               animate: 1000,
  //               onStep: function(value) {
  //                   this.$el.find('span').text(~~value);
  //               }
  //           });

  //          $('.updateEasyPieChart').on('click', function(e) {
  //             e.preventDefault();
  //             $('.percentage, .percentage-light').each(function() {
  //               $(this).data('easyPieChart').update(Math.round(100*Math.random()));
  //             });
  //           });


});

           