<?php

App::uses('AppModel', 'Model');

/**
 * Ddatatable Model
 *
 * @property DdatatableField $DdatatableField
 */
class Ddatatable extends AppModel {

    public $actsAs = array('Containable');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Ddatatable by that name already exists',
            ),
        ),
    );

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'DdatatableField' => array(
            'dependent' => true,
            'className' => 'Ddatatables.DdatatableField',
//            'foreignKey' => 'dview_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
        )
    );

    public function getConfig($name) {
        $tmp = $this->field("datatable", ['code' => $name]);
        if (empty($tmp)) {
            return null;
        }
        $tmp2 = json_decode($tmp, true);
        if ($tmp2) {
            return $tmp2;
        }
        return null;
    }

}
