<?php
  echo $this->Form->create('Evento', array(
    'class' => 'modal hide fade',
    'id' => 'event-form',
    'url' => array(
      'controller' => 'mis_eventos',
      'action' => 'registrar'
    )
  ));
?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
          <div class="preview-pane"  id="panel-sociales" >
            <h5 class="preview-title">
              Redes Sociales
            </h5>
            <div style="text-align:center; margin-top:20px"  id="sociales-01" >              

            </div>
          </div>
      </div>
      <div class="span5">
        <div id="map-container">
          <div id="map-canvas" style="width:100%;height:340px;"></div>
        </div>

        <div class="span3_pennant pull-right">
          <span class="info-evento">
            <?php  if($isAuthUser) :?>
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
            <?php  endif;?>                                
          </span>                
      </div>

   

      </div>
    </div>

  </div>
  <div class="modal-footer">
    <button class="btn_color" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
<?php
  echo $this->Form->end();
?>
