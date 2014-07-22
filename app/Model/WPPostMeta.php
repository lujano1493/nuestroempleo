<?php
	class WPPostMeta extends AppModel {
	public $name='WPPostMeta';
	public $useTable = 'wp_postmeta'; 
	public $primaryKey="meta_id";	
  	public $useDbConfig = 'wordpress';

}