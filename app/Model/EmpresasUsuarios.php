<?php

App::uses('AppModel', 'Model');

class EmpresasUsuarios extends AppModel {
	public $name = 'EmpresasUsuarios';
	
	/**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'usuxcia_cve';


	public $useTable = 'tusuxcia';
	
}