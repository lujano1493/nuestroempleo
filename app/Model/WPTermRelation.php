<?php
	class WPTermRelation extends AppModel {
	public $name='WPTermRelation';
	public $useTable = 'wp_term_relationships'; 
	public $primaryKey=false;	
  	public $useDbConfig = 'wordpress';

}