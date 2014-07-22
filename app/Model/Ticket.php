<?php
App::uses('AppModel', 'Model');

/**
 * Modelo de Tickets 
 */
class Ticket extends AppModel {
    
    /**
     * Nombre de Modelo
     * @var string
     */
    public $name = 'Ticket';
    

    public $primaryKey = 'ticket_cve';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var string 
     */
    public $useTable = 'ttickets';
    

    public $reasons = array(
      'recuperar_pass_admin',
      'recuperar_pass_empresas',
      'recuperar_pass_candidatos',
      'cambiar_email_empresas',
      'cambiar_email_candidatos'
    );
    /**
     * Elimina todos los tickets con fecha anterior a now() 
     */
    private function purgeTickets() {
        $this->deleteAll(array('Ticket.fec_exp <= CURRENT_DATE'), false);
    }
    
    /**
     * Elimina el Ticket con el HASH = $hash
     * @param string $hash Hash 
     */
    public function deleteTicket($hash) {
        $this->deleteAll(array('Ticket.hash' => $hash), false);
        $this->purgeTickets();
    }
    
    /**
     * Verifica si existe un Ticket.
     * Elimina todos los tickets con fecha anterior a now() 
     * 
     * @param string $hash Hash
     * @return array 
     */
    public function checkTicket($hash) {
        $this->purgeTickets();
        return $this->findByHash($hash);
    }
    
    /**
     * Obtiene la fecha en que expirará un ticket.
     * @param integer $days
     * @return date Fecha de Expiración 
     */
    public function getExpirationDate($days = 1) {
        $date = time() + ($days * 24 * 60 * 60);
        $expired = date('Y-m-d H:i:s', $date);
        return $expired; 
    }
}