<?php
App::uses('AppModel', 'Model');
/**
 * Pagegroup Model
 *
 * @property Cmspage $Cmspage
 */
class CmspagePagegroup extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
        public $useTable='cmspages_pagegroups';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	

}
