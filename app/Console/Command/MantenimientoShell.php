  <?php


 App::uses('Email', 'Utility');
App::import('Model', 'ConfigCan');
class MantenimientoShell extends AppShell {


  public function email_activacion(){

      $cuenta=ClassRegistry::init('CandidatoUsuario');
      $cuenta->useDbConfig='production';
      Router::fullBaseUrl("http://www.nuestroempleo.com.mx");
      $rs=$cuenta->find("all",array(
        "recursive" =>-1,
        'joins' => array(
            array( 
                'table' => 'tcandidato',
                'alias' => 'Candidato',
                'type' => 'INNER',
                'conditions' => array(
                  'CandidatoUsuario.candidato_cve=Candidato.candidato_cve'
                  ),
                'fields' => array(
                    "Candidato.candidato_nom || ' ' || Candidato.candidato_pat ||' ' || Candidato.candidato_mat  CandidatoUsuario__nombre" 
                  )
              )

          ),
        "conditions" => array(
            'created >=   to_date(\'25/08/2014\',\'DD/MM/YYYY\')' , 
            'created < to_date(\'26/08/2014\',\'DD/MM/YYYY\')',
            'cc_status' => -1 
        ),
        'order' => array(
          'candidato_cve asc'
          ) ));

      Debugger::log($rs);
      foreach ($rs as $k=> $v) {
          $v=$v['CandidatoUsuario'];

             $info= array (
                  'correo'=>$v['cc_email'],
                  'nombre'=>$v['nombre'] ,
                  'contrasena'=>'123456789',
                  'keycode'=>$v['keycode']
                  );
                try{
                  $st= Email::sendEmail($info['correo'],
                                'Activación de Cuenta',
                                'activar_candidato',
                                array("data"=>$info),'activar_cuenta');
                  Debugger::log("Se envio correo de activacion a: $v[cc_email]");
                 } catch (Exception $e){
                    Debugger::log($e);
              }


      }

  }   
  public function  registrar_email(){    
    $quefalta=array(
      array('Victor Manuel','Aguilar Ramírez','m1989victor@hotmail.com'),
      array('Roberto Isaac','Aguilar Rangel','Isaac1111@outlook.es'),
      array('Alan David','Altamirano Moreno','alan_lang95@hotmail.com'),
      array('ROBERTO','ALVARADO','cesaralvaradomz@hotmail.com'),
      array('Francisco','Alvarez Beyza','beyza_86175@hotmail.com'),
      array('allan','aquino davila','nemesis6095@hotmail.com'),
      array('Erica','Avelino Silva','erica.avelino.s@gmail.com'),
      array('mario','ballesteros','neguer_14@hotmail.com'),
      array('Guillermo Merced','Barajas Acosta','gbarajas@mail.com'),
      array('Fernando','Barragan Ortíz','barragan027@gmail.com'),
      array('Sergio','Becerra','sergiogabriel2003@hotmail.com'),
      array('eunice stephany','beltran morales','nice-bemo@hotmail.com'),
      array('David Daniel','Betanzos Lopez','last_kooks@outlook.com'),
      array('Marco Antonio','Bolanos Damian','marko_m@live.com.mx'),
      array('osbaldo','bolaños geleana','osbaldoso@gmail.com'),
      array('Cristal Efrat','Brigido Ordaz','cristal.eordaz@hotmail.com'),
      array('Arturo García','Calixto','a_garcia_calixto@hotmail.com'),
      array('yunuet itayetzin dafne','camacho carrillo','renataquirozcamacho_2@hotmail.com'),
      array('jonatan roberto','camacho garcia','jsa2028@hotmail.com'),
      array('Jesus Carlos','Carballo Garcia','carballo_73carlos@hotmail.com'),
      array('Benjamin','Carmona','sasuben_18@hotmail.com'),
      array('hector aaron','carreto arcos','hackett_stern@hotmail.com'),
      array('Marina Agustina','carrillo quintana','marina.ada@hotmail.com'),
      array('jesus','castillo cervantes','licenciadoenderechojesus@gmail.com'),
      array('Luis Felipe','Castillo Vieyra','vieycast00@hotmail.com'),
      array('beatriz adriana','cedillo','alomig278@hotmail.com'),
      array('Maria Guadalupe','Ceron Heras','maria_pink99@hotmail.com'),
      array('viridiana','chavez','vchj@outlook.es'),
      array('Diana Esmeralda','Citalán Barrios','DianaE_CB@hotmail.com'),
      array('eduardo','cordero herrera','cordero_azul19@hotmail.com'),
      array('alberto','Cordova Arroyo','sayckodelicdrink@hotmail.com'),
      array('Ilse','Cordova Santiago','ilse.love.its98439@gmail.com'),
      array('MartIn Alejandro','Coutiño Suárez','macosu_italia@hotmail.com'),
      array('Antonio','Cruz','rantoniocruzr@hotmail.com'),
      array('César','Cruz Calderón','cesar.o.o.302@gmail.com'),
      array('DANIEL ARTURO','CRUZ GONZALEZ','dacruzg.030689@gmail.com'),
      array('laura  patricia','cruz romero','lau.patita@hotmail.com'),
      array('ANA LAURA','DE JESUS LONGINO','chispalunar89@gmail.com'),
      array('oscar ivan','de la cruz rosas','ivanr.cetis154@gmail.com'),
      array('Jacobo','Domínguez Gaspar','jacobo.dominguez@hotmail.com'),
      array('ERIC','ENCISO MORALES','eric.enciso@outlook.com'),
      array('manuel','escobar morales','manuel_87mem@hotmail.com'),
      array('Guicel Andrea','Espinosa Moreno','chicel_azul@hotmail.com'),
      array('JOSE MIGUEL','FELIPE ARELLANO','Geminis.180@hotmail.com'),
      array('ERICK','FELIPE GARCÍA','bonny.ov3r19@hotmail.com'),
      array('Jorge Arturo','Fernandez Ruiz','rossboy_87@hotmail.com'),
      array('JORGE ALEJANDRO','FLORES AGUILAR','jafacar@hotmail.com'),
      array('Marco A','Fonseca Flores','marco_fonseca_f@hotmail.com'),
      array('ivan alejandro','franco magdaleno','Ivan_franco619@hotmail.com'),
      array('Arturo','Galicia Hernandez','shadiel_shalom@hotmail.com'),
      array('Eduardo','García','etn_hectorlavoe@hotmail.com'),
      array('Guillermo','Garcia Perez','guillermogarciaggp@hotmail.com'),
      array('Nallely','Gonzalez','nalle_psibb@hotmail.com'),
      array('victor','gonzalez','snapyvictorlobo@hotmail.com'),
      array('Elvia','González Gullén','pili_gon@yahoo.com.mx'),
      array('José Guillermo','González Pérez','guillesmus@yahoo.com'),
      array('francisco javier alfonso','gonzalez vicencio','fja.gonzalez.1969@hotmail.com'),
      array('Fernando','Gutierrez','ferg696@hotmail.com'),
      array('angel','hernandez','angelhdz1405@gmail.com'),
      array('XOCHITL YADIRA','HERNANDEZ ALBA','yadirita_1311@hotmail.com'),
      array('Evelyn','Hernandez Bustos','evelynhernandezbustos@gmail.com'),
      array('Jesús','Hernández Espinisa','espherjes05@hotmail.com'),
      array('Rocio','Hernández García','crocio_hg@hotmail.com'),
      array('maria','hernandez jimenez','maryhj_98@hotmail.com'),
      array('Thania Lizeth','Hernández León','liz_y_ubago@hotmail.com'),
      array('JOSE LUIS','HERNÁNDEZ LUNA','antraxc_17@hotmail.com'),
      array('María','Hernández Morales','mary_hdez@prodigy.net.mx'),
      array('Césa Ramón','Hernández Robles','herc.rasec@gmail.com'),
      array('Eric Alonso','Hernandez Vargas','h.eric32@yahoo.com.mx'),
      array('victor manuel','herrera','vikthor20_erra@hotmail.com'),
      array('stephanie','herrera escobar','fanyherrera510@gmail.com'),
      array('Gerardo','Ibañez Aranda','geryale2011@yahoo.com.mx'),
      array('Stephanie yanely','Ibarra Casas','nelly_kamaleon@hotmail.com'),
      array('VELASCO MONTERO OMAR','ISRAEL','isramx2009@hotmail.com'),
      array('armando','Jiménez','janogriego1825@hotmail.com'),
      array('monica','jimenez  gomez','dana-55@live.com.mx'),
      array('Rodrigo','Juárez  Hernández','newrockuniver@hotmail.com'),
      array('Erika Jacqueline','Juárez Moreno','Tahiryjuarez@yahoo.com.mx'),
      array('KARLA PATRICIA','LEAL SANDOVAL','patricia.lesan12@gmail.com'),
      array('marisol','lopez atanasio','solatanahi_cr7@hotmail.com'),
      array('Elvira','Lopez Ordaz','segovia62.el@gmail.com'),
      array('Iván Elihu','López Ricardi','ivanchos_soon@hotmail.com'),
      array('julio cesar','lugo gonzalez','cesarjclg1977@gmail.com'),
      array('Maria Elena','Marin Rodriguez','mi_12376@hotmail.com'),
      array('Víctor Manuel Sánchez','Márquez','markezvicman@gmail.com'),
      array('Victor Manuel','Martínez Chimal','compa_3c@hotmail.com'),
      array('Faustino','Martínez Cortés','dultino@hotmail.com'),
      array('Jesús rodrigo','martinez ortiz','jesus28_kiubi@hotmail.com'),
      array('Bruno Jonathan','Mata González','ycap17@msn.com'),
      array('Christian Antonio','Mendoza Linares','bleacer2323@live.com.mx'),
      array('José Alan','Mendoza Ruiz','serafinkira88@gmail.com'),
      array('carlos','moctezuma','moac74@hotmail.com'),
      array('Carlos Daniel','Montiel Gamboa','wakkowarnernk@gmail.com'),
      array('Jessica Jackeline','Montoya Nava','chickayy@gmail.com'),
      array('jorge antonio','morales arriaga','drancer1788@hotmail.com'),
      array('eduardo','morales jimenez','emj_yayo@hotmail.com'),
      array('PABLO GIOVANNI','MORALES TINAJERO','giovanni7manutd@hotmail.com'),
      array('cintya nataly','nava mora','natnava_0407@hotmail.com'),
      array('Yessica Alejandra','Navarro Delgado','alejandra.navarro92@hotmail.com'),
      array('Alexis Isaac','Neri Huerta','ainh.95@hotmail.com'),
      array('gustavo enrique','nicolas de la rosa','dulce_dr_1308@hotmail.com'),
      array('ARTURO','OCAMPO','auch180@hotmail.com'),
      array('Adrian','Olivares Romero','aolirom@gmail.com'),
      array('Lucero de los Angeles','Orozco Pizano','lucero.jonas@hotmail.com'),
      array('Marco Antonio','Ortia Rosas','tonyortiz_007@hotmail.com'),
      array('Ana Lilia','Palencia Jiménez','alpj16@hotmail.com'),
      array('Carlos Alberto','Paredes Tejeda','rocoslocos@hotmail.com'),
      array('Gustavo','Peña Gomez','nano_118_zenzacion@hotmail.com'),
      array('Nantzin Pamela','Peñaloza Sanchez','sudeki92@hotmail.com'),
      array('Jesus','Peralta','jesus28rosa@gmail.com'),
      array('bernabe','perez jimenez','bernabeperezjimenez@hotmail.com'),
      array('Juan Carlos','Pérez Martínez','juancarlosperezmart@gmail.com'),
      array('Licel Pamella','Perez Morales','pamellapm061084@hotmail.com'),
      array('FELIX','PIEDRA SERNA','FELIX_ACAPIEDRA@HOTMAIL.COM'),
      array('orquidea','quintana garfias','pynky_pyky@hotmail.com'),
      array('daniel','quiroz','danyq09@gmail.com'),
      array('ruben suriel','ramirez hernadez','rubensurielramirez@gmail.com'),
      array('Dulce Esther','Rangel','tixtix79@hotmail.com'),
      array('Anallely','Rivera de Jesús','anallely_rivera@hotmail.com'),
      array('Alejandra','Robles Torres Torija','alechenes@gmail.com'),
      array('Arturo Ricardo','Rocha Angeles','arturo_anro@yahoo.com.mx'),
      array('Martín','Rodríguez de Jesús','chaps_martin@hotmail.com'),
      array('maria guadalupe','rodriguez olmos','olmosgisbet@hotmail.com'),
      array('victor manuel','rodriguez ortiz','vic-man1104@hotmail.com'),
      array('jonathan','Rodriguez San Agustín','jonathantadeo@gmail.com'),
      array('jose israel','rojas trejo','israelhino5555@hotmail.com'),
      array('oscar','romero martinez','romo_oscar74@hotmail.com'),
      array('Felipe de Jesús','Romero Martínez','fjrm_1990@hotmail.com'),
      array('Juanita','Rosales Quintero','giovannaselene@hotmail.com'),
      array('Rene Aurelio','Saavedra Oliva','yeyorene1@gmail.com'),
      array('ITZELL NATALIA HERNANDEZ','SALAZAR','nataly_hernandez_2006@hotmail.com'),
      array('Araceli','Salvador','aracelisalvm@hotmail.com'),
      array('Pedro Emir','Sanchez Cortes','pedro27galleta@gmail.com'),
      array('Dafne Giovanna','Sánchez Hernández','break_mysoul@hotmail.com'),
      array('jose martin','sanchez martinez','crater_749@hotmail.com'),
      array('veronica mariana','sanchez ramirez','anairam1301@hotmail.com'),
      array('Martin','Santiago Vazquez','gory_san@hotmail.com'),
      array('ALDAIR BRAYAN','SANTOS SÁNCHEZ','aldair.santos1@hotmail.com'),
      array('Manuel','segura','doctoners75@gmail.com'),
      array('MARÍA GARDENIA','TENORIO BERROCAL','amizabhan-89@hotmail.com'),
      array('Ricardo','Torres Montalban','rtmontalban@hotmail.com'),
      array('Lourdes Cecilia','Torres Morales','dulcecitoawado@gmail.com'),
      array('silvia','TORRES XANCOPINCA','silviatorresx@hotmail.com'),
      array('Mariano','Tortolero Palimino','gool68@hotmail.com'),
      array('stephany','valle bernal','fany_azul5@hotmail.com'),
      array('fernando','vallejo martin','kaos_fear@hotmail.com'),
      array('Luis Fernando','Vargas López','dar_k_sage@hotmail.com'),
      array('Jazmin','Vega Rojas','pelirroja_65@msn.com'),
      array('Eduardo','Velazquez Osnaya','yeyovt@live.com'),
      array('Patricia','Velázquez Osnaya','patriciavelazquezosnaya@yahoo.com.mx'),
      array('Geovani Martínez','Yáñez','anamarsdf1@hotmail.com'),
      array('José Bernardo','Zambrano Reyes','josezam1982@outlook.com'),
      array('Carlos Augusto','Zarate Estrada','cauzaec@hotmail.com'),
      array('GIOVANY','ZAVALA GARCIA','jovan4290@gmail.com'),
      array('leslie yareth','zuñiga zorrilla','loveme_zz_92@hotmail.com')
      );
    $m=ClassRegistry::init('CandidatoUsuario');
    $eva=ClassRegistry::init('EvaCan');
    $graf=ClassRegistry::init('GrafCan');
    $graf->useDbConfig=$eva->useDbConfig=$m->Candidato->useDbConfig=$m->useDbConfig='production';

    Router::fullBaseUrl("http://www.nuestroempleo.com.mx");
    foreach ($quefalta as  $v) {
        $correo= $v[2];
        $nombre= $v[0];
        $apellidos= $v[1];
        if( $m->hasAny(array( 'cc_email' => $correo ) ) ){
          Debugger::log('ya existe el correo $correo registrado.');
          continue;
        }
        $m->create();
        $m->save(
            array(
                'cc_email' => $correo,
                'cc_password' => '123456789',
                'cc_status' => -1,
                'per_cve' => 10,
                'cc_completo' => 'N'
              ),
            false
          );
        $dato_name= explode(' ', $apellidos) ;
        $num=count($dato_name);
        $pat= $num > 0? $dato_name[0] : '';
        $mat= $num > 1 ? $dato_name[1] : '';
        $m->Candidato->save(array(
            'candidato_cve' => $m->id,
            'candidato_nom' => $nombre,
            'candidato_pat' => $pat,
            'candidato_mat' => $mat,
          ),
        false
        );      
        $eva->create();
        $eva->save(
        array(
            "candidato_cve"=>$m->id,
            "evaluacion_cve"=>2,
            "cu_cve" => 1,
            "evaluacion_status" =>0,
            "evaluacion_fec" =>  date("Y-m-d ")
            )
        );
        $graf->save(array(
            'candidato_cve' => $m->id,
            'tabla_cve' => 1
          ));
        $v=$m->find("first",array(
        "recursive" =>-1,
        'joins' => array(
            array( 
                'table' => 'tcandidato',
                'alias' => 'Candidato',
                'type' => 'INNER',
                'conditions' => array(
                  'CandidatoUsuario.candidato_cve=Candidato.candidato_cve'
                  ),
                'fields' => array(
                    "Candidato.candidato_nom || ' ' || Candidato.candidato_pat ||' ' || Candidato.candidato_mat  CandidatoUsuario__nombre" 
                  )
              )

          ),
        "conditions" => array(
            'CandidatoUsuario.candidato_cve ' => $m->id
        ) ))['CandidatoUsuario'];
          $info= array (
                  'correo'=>$v['cc_email'],
                  'nombre'=>$v['nombre'] ,
                  'contrasena'=>'123456789',
                  'keycode'=>$v['keycode']
                  );
                try{
                  $st= Email::sendEmail($info['correo'],
                                'Activación de Cuenta',
                                'activar_candidato',
                                array("data"=>$info),'activar_cuenta');
                }catch (Exception $e){

                }

                Debugger::log("Registro de  $nombre $pat $mat $correo");

    }
    $m->getLog('return');

  }


}

