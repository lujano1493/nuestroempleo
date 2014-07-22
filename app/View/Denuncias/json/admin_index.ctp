<?php

  $denuncias=array(
        "candidatos" =>  $denunciasCV,
        "ofertas" =>$denunciasOfertas
    );
  $this->_results = $this->Denuncia->formatToJson($denuncias);
?>