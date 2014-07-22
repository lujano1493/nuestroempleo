<?php
	class WPTaxoTerms extends AppModel {
	public $name='WPTaxoTerms';
	public $useTable = 'wp_term_taxonomy'; 
	public $primaryKey="term_taxonomy_id";	
  	public $useDbConfig = 'wordpress';

}