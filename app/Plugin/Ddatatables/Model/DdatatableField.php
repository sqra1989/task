<?php

App::uses('AppModel', 'Model');

/**
 * DdatatableField Model
 *
 */
class DdatatableField extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'field';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'dview_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'field' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Ddatatable'
    );

    /**
     * Fields that should be skipped while checking if row is empty
     * look at controler method: _checkAndDelete
     */
    public $skipEmptyChecking = array("settings");

}
