<?php 
class OpcionPreg extends Model {
	public $name="OpcionPreg";
	public $useTable = 'topcpregunta'; 
  	public $primaryKey="opcpre_cve";


  	 // public $hasAndBelongsToMany = array(
    //     'Ingredient' =>
    //         array(
    //             'className' => 'Ingredient',
    //             'joinTable' => 'ingredients_recipes',
    //             'foreignKey' => 'recipe_id',
    //             'associationForeignKey' => 'ingredient_id',
    //             'unique' => true,
    //             'conditions' => '',
    //             'fields' => '',
    //             'order' => '',
    //             'limit' => '',
    //             'offset' => '',
    //             'finderQuery' => '',
    //             'with' => ''
    //         )
    // );

}