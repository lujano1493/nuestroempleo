
<?php 

  $results=array();


  foreach ($compartirse as $k) {
    $oferta=$k['Oferta'];
    $usuario=$k['UsuarioEmpresa'];
    $empresa=$k['Empresa'];
    $results[]=array(
        'id' => $oferta['oferta_cve'],
        'tipoCompartir' =>  'oferta',
        'codigo' => $oferta['oferta_cvealter'],
        'nombre' => $oferta['puesto_nom'],
        'vigencia' => $oferta['vigencia'],
        'empresa' => $empresa['cia_nombre'],
        'liga' => $oferta['oferta_link'],
        'fecha' => array(
              'val' =>$oferta['created'],
              'str' =>$this->Time->d($oferta['created']) 
          ),
        'veces_compartidas' => (int)$oferta['compartido'],
        'compartir' => array(
                'facebook' => (int)$oferta['compartido_facebook'],
                'twitter' => (int)$oferta['compartido_twitter'],
                'linkedin'=> (int)$oferta['compartido_linkedin']
          )

      );
  }

  $this->_results=$results;

?>