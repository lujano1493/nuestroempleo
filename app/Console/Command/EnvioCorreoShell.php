<?php


 App::uses('Email', 'Utility');
App::import('Model', 'ConfigCan');
class EnvioCorreoShell extends AppShell {
  public $uses=array('CandidatoUsuario',"Evento","WPPost","OfertaB");
    public function main() {

       $file ="/home/fernando/debug_tarea.txt";

      $current = file_get_contents($file);

      $current .= "iniciando debug  desde main ".date("Y-m-d H:i:s")."  \n";

      $this->out('hola desde el main.');

      file_put_contents($file, $current);
    }

    public function enviar_correo() {
    try{
      $this->idetifica_entorno();

      $file = getenv("HOME")."/debug_tarea.txt";

      $current = file_get_contents($file);

      $current .= "iniciando debug  enviar_correo".date("Y-m-d H:i:s")."   \n";

      Email::sendEmail("lujano14.93@gmail.com",
                  'Actualización de Currículum',
                  'actualiza_cv',
                array(
                  "data" =>array(
                        "Usuario" => array("Candidato"=> array("nombre_" =>"desde comando") )
                    )
                  ),

              'aviso');
    }catch (Exception $e){
      $current.= "OCurrio una excepcion $e";
      $this->out($e);
    }


      // Write the contents back to the file
    file_put_contents($file, $current);
  }


  private function idetifica_entorno(){
    $env=getenv("NODE_ENV");
    if($env==='pro'){
        $this->OfertaB->useDbConfig= $this->CandidatoUsuario->useDbConfig=$this->Evento->useDbConfig='production';
        Router::fullBaseUrl("http://www.nuestroempleo.com.mx");
    }
    else{
      Router::fullBaseUrl("http://148.243.72.195");
    }

  }

  public function enviar_encuesta(){
     $this->idetifica_entorno();

       Email::sendEmail('javargas@iusacell.com.mx',
                'Encuesta de Referencia',
                'encuesta_referencia',
                array("data"=>array("nombre_referencia"=>'Alejandro Vargas',
                                    'nombre_' => 'ARTURO CAMACHO ROSAS' ,
                                    'keycode' => 'c787199609c50cb78ea23acce0a47f80c29d9320',
                                    "refcan_cve"=>'1625' )),'encuesta');          
  }
  public function enviar_evento(){
    $this->idetifica_entorno();
    $candidatos=$this->CandidatoUsuario->usuariosActivos(ConfigCan::EVENTOS);
    if(empty($candidatos)){
        return ;
      }
    foreach ($candidatos as $v) {
      try{
        $idEstado=$v['CandidatoUsuario']['est_cve'];
        $eventos=$this->Evento->eventosxEstado($idEstado);    
        if( !empty($eventos)){
           Email::sendEmail($v['CandidatoUsuario']['correo'],
                      'Eventos',
                      'eventos',
                    array(
                      "data" =>array(
                            "Usuario" => $v,
                            "Eventos" => $eventos
                        )
                      ),

                  'evento');

        }       
       sleep(3);
      }catch (Exception $e){
        $this->out($e);
      }

    }

  }
  public function enviar_aviso_actualizacv(){
    $this->idetifica_entorno();
    $candidatos=$this->CandidatoUsuario->usuariosInactivos();
    if(empty($candidatos)){
      return ;
    }
    // $articulos= $this->WPPost->articulos_liga(null,'Candidatos',$semana);
    foreach ($candidatos as $v) {
      try{
        Email::sendEmail($v['CandidatoUsuario']['correo'],
                      'Actualización de Currículum',
                      'actualiza_cv',
                    array(
                      "data" =>array(
                            "usuario" => $v
                        )
                      ),

                  'aviso');
        sleep(3);
      }catch (Exception $e){
        $this->out($e);
      }

     }
  }


  public function enviar_boletin(){
      $t_semana=( 60*60*24 * 7 );
      $semana= date( "Y-m-d",time() - $t_semana ) ;
      $primer= mktime(0,0,0,5,10,2014);
      $act=time();
      $no_boletin = round(abs($act -$primer) / $t_semana ) + 1;
      $this->idetifica_entorno();
      $articulos= $this->WPPost->articulos_liga(null,'Candidatos',$semana);
      $semblanzas= $this->WPPost->articulos_liga(2,'Semblanzas',$semana);
      if(empty($articulos) && empty($semblanzas) ){
        return;
      }
      $candidatos=$this->CandidatoUsuario->usuariosActivos(ConfigCan::ARTICULOS);
      if(empty($candidatos)){
        return ;
      }
        foreach ($candidatos as $v) {
           try{
            Email::sendEmail($v['CandidatoUsuario']['correo'],
                      'Boletín semanal No. '.$no_boletin,
                      'boletin',
                    array(
                      "data" => array(
                              "articulos" =>$articulos,
                              "semblanzas" => $semblanzas
                        )
                      ),

                  'boletin');
                  sleep(3);
          }catch (Exception $e){
            $this->out($e);
          }
        }
      $this->out("el correo fue enviado con exito");
  }
  public function enviar_ofertas(){    
    $this->idetifica_entorno();
      $candidatos=$this->CandidatoUsuario->usuariosActivos(ConfigCan::OFERTAS);         
      if(empty($candidatos)){
        return ;
      }
       foreach ($candidatos as $v) {
            $ofertas=$this->OfertaB->busqueda_perfil_candidato($v['CandidatoUsuario']['candidato_cve'] ,5);     
            if(empty($ofertas)){
                continue;
            }    
              Email::sendEmail($v['CandidatoUsuario']['correo'],
                          'Recomendación de Vacantes',
                          'ofertas_perfil',
                           compact("ofertas"),
                      'boletin');
                      sleep(3);
       }

  }


}