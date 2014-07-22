 $(document).on('click',"[data-toggle*=modal-ajax]",function(event) {
            event.preventDefault();
              var $this=$(this), url = $this.attr("href"), $div=$this.closest("div");
                var $target= $($this.data("target"));                      
                if($target.length==0){
                    $(document).
                        find("body").
                          prepend(
                                   $.template("#tmpl-modaloferta",{id:$this.data("target").substring(1)})                                     

                            );
                    $target=$($this.data("target"));
                }
                 if(!$target.data('modal')){
                    $target.modal({
                      keyboard: false,
                      backdrop: 'static'
                    });
                 }              
                $target.modal('show').off("shown").on("shown",function (){
                        focus_scroll($target);
                }).off("hidden").on("hidden",function (){
                        $area_refresh.empty();
                        focus_scroll($div);                        
                });;
                var $area_refresh=$target.find(".modal-body .refresh-area");
                $area_refresh.trigger("create-background-wait.ajax");
                $.get(url,{time: (new Date()).getTime() } ,function(data) {
                  $area_refresh.trigger("remove-background-wait.ajax");
                  $area_refresh.html(data).show("fade",500);

                   /*agregamos botenes de like y de compartir para facebook */
                        FB &&FB.XFBML.parse();
                        /*agregamos los botones +1 para google plus*/
                        gapi&&gapi.plusone.go();
                    /*refrescamos y cargamos botones dinamicamente twetter */
                      $.ajax({ url: '//platform.twitter.com/widgets.js', dataType: 'script', cache:true}); 
                  var name_component=['validationform','ajaxform','slideform','comentcan','socialelement'];
                  $(name_component).each(function (index,value){
                    $.component(value,$area_refresh);    
                  });
                }).success(function() { 
                 });

        });