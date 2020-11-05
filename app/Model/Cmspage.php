<?php
App::uses('AppModel', 'Model');
/**
 * Cmspage Model
 *
 * @property Pagegroup $Pagegroup
 */
class Cmspage extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Pagegroup' => array(
			'className' => 'Pagegroup',
			'joinTable' => 'cmspages_pagegroups',
			'foreignKey' => 'cmspage_id',
			'associationForeignKey' => 'pagegroup_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
