
  <div class="modal-header">
    <h3 id="myModalLabel">Evento</h3>
  </div>
  <div class="modal-body container-fluid">
    <div class="row-fluid">
      <div class="span7 info-evento">
        <h5>
          <strong data-name="evaluacion-title">
                  
          </strong>
        </h5>

        <strong class="block" data-name="evento-name">          
        </strong>
        <span class="block" data-name="evento-type">
        </span>
        <div class="preview-pane">
          <h5 class="preview-title">
            Descripción          </h5>
          <div data-name="evento-desc">
            
          </div>
        </div>


        <div class="preview-pane">
          <h5 class="preview-title">
            Lugar          </h5>
          <span class="block" data-name="evento-calle"></span>
          <span class="block" data-name="evento-dir"> </span>
        </div>

        <div class="preview-pane">
        <h5 class="preview-title">
          Duración          </h5>
            <span class="block" data-name="evento-start"></span>
            <span class="block" data-name="evento-end"></span>
          </div>

       
      </div>
      <div class="span5">
        <div id="map-container">
          <div id="map-canvas" style="width:100%;height:340px;"></div>
        </div>

        <div class="span3_pennant pull-right">
          <span class="info-evento">
            <div class="content">
                        Si deseas mayor información del evento, puedes comunicarte con:<br>              
                  <br>
                   <strong data-name="contacto"></strong>
                  <br>    
                  <a href="#"  data-name="correo" ></a>      
                  <br>
                  <a href="#"  data-name="telefono" ></a>     
                  <br>

            </div>
         
    
          </span>
         
         
      </div>

   

      </div>
    </div>

  </div>

<?php
  $this->Html->script(array(
    'http://maps.googleapis.com/maps/api/js?key=' . Configure::read('google_api_key') . '&region=MX&sensor=false'
  ), array(
    'inline' => false
  ));

  $this->AssetCompress->addScript(array(
    'trentrichardson/jQuery-Timepicker-Addon/dist/jquery-ui-timepicker-addon.js',
    'trentrichardson/jQuery-Timepicker-Addon/dist/i18n/jquery-ui-timepicker-es.js',
    'vendor/fullcalendar/fullcalendar.min.js',
    'app/candidatos/calendar.js'
  ),
    'calendar_previa.js'
  );
?>