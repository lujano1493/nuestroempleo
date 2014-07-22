  <div class="row">
  	  <div class="  {{=  it.es_pregunta ? 'dudas' : 'dudas_respuesta' }}  {{=  it.es_pregunta ? 'pull-left' : 'pull-right' }}  span6">
    <img id="img" src="{{=it.foto}}" style="width:60px;height:70px" width="60" height="70"> 
      {{=it.mensaje}}
     <div class="pull-right dudas_fecha">
        <label style="font-size:10px">
          Fecha de publicacion:{{=it.fecha}} 
        </label>
        
      </div>
  </div>  
  </div>


