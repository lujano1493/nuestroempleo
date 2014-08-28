<?php

App::uses('Timbrado', 'Lib/CFDI');

class FactureHoyTimbrado extends Timbrado {
  public function enviar($xml) {
    $opts = new stdClass;
    $opts->usuario = $this->config['usuario'];
    $opts->contrasenia = $this->config['password'];
    $opts->idServicio = 41692353; //5906390; //5652422; //5652500;
    $opts->xml = trim(preg_replace(array("/\n/", '/>\s+</'), array('', '><'), $xml));

    if (!(bool)$this->soapClient) {
      $this->_errors[] = __('El servidor SOAP no está disponible.');
    } else {
      $response = $this->soapClient->emitirTimbrarTest($opts);
      if (isset($response->return->isError) && (bool)$response->return->isError) {
        /**
         * Ocurrió un error
         */
        $this->_errors[] = $response->return->message;
      } elseif(isset($response->return->XML) && !empty($response->return->XML)) {
        // $r = new stdClass;
        // $r->uuid = $response->return->folioUDDI;
        // $r->cadenaOriginalSAT = $response->return->cadenaOriginal;
        // // $r->sello = $response->return->selloDigitalEmisor;
        // $r->selloSAT = $response->return->selloDigitalTimbreSAT;
        // $r->urlPDF = $response->return->rutaDescargaPDF;
        // $r->urlXML = $response->return->rutaDescargaXML;
        // $r->XML = $response->return->XML;
        // $r->fechaTimbrado = $response->return->fechaHoraTimbrado;

        $response->return->XML = trim(preg_replace(array("/\n/", '/>\s+</'), array('', '><'), $response->return->XML));
        /**
         * Respuesta exitosa
         */
        return $response->return;
      }
    }

    return false;
  }
}
