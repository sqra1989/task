<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Operator $Operator
 * @property Role $Role
 * @property Employee $Employee
 */
class User extends AppModel {



    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'username' => array(
        /* 'notBlank' => array(
          'rule' => array('notBlank'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
          'characters' => array(
          'rule'     => 'alphaNumeric',
          'message'  => '(tylko cyfry i litery)'
          ),
          'unique' => array(
          'rule' => array('isUnique'),
          'message' => 'Taka nazwa użytkownika już istnieje',
          ), */
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'pole wymagane'
            ),
        ),
        'type' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'pole wymagane'
            ),
        ),
        'surname' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'pole wymagane'
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email')
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Taki email już istnieje w bazie',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password' => array(
            'identicalFieldValues' => array(
                'rule' => array('identicalFieldValues', 'password2'),
                'message' => 'Passwords do not match',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'minLength' => array(
                'rule' => array('minLength', 1),
                'message' => 'Minimum 1 characters long'
            ),
        ),
        'created' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'modified' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'born' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'pole wymagane'
            ),
        ),
        'role_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    function identicalFieldValues($field = array(), $compare_field = null) {
        foreach ($field as $value) {
            $v1 = $value;
            $v2 = isset($this->data[$this->alias][$compare_field]) ? $this->data[$this->alias][$compare_field] : null;
            if ($v1 !== $v2) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }

    public function isVerified() {
        if ($this->field('verified') == 3) {
            return true;
        }
        return false;
    }

    public function alreadyExist($key_value, $ignore_id = NULL) {
        if ($ignore_id and is_numeric($ignore_id)) {
            $count = $this->find('count', array(
                'conditions' => array_merge($key_value, array(
                    'id <>' => $ignore_id
                )),
                'recursive' => -1
            ));
        } else {
            $count = $this->find('count', array(
                'conditions' => $key_value,
                'recursive' => -1
            ));
        }
        return ($count == 0);
    }

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
            'foreignKey' => 'role_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
  

    /**
     * hasOne associations
     *
     * @var array
     */
    public function beforeValidate($options = array()) {
    
    }

    public function beforeSave($options = array()) {

        if (isset($this->data[$this->alias]['born'])) {
            $this->data[$this->alias]['born'] = date('Y-m-d', strtotime($this->data[$this->alias]['born']));
        }

        if (isset($this->data[$this->alias]['password']) and isset($this->data[$this->alias]['password2'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
            $this->data[$this->alias]['password2'] = AuthComponent::password($this->data[$this->alias]['password2']);
        }

        return true;
    }

    public function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            if (isset($val['User']['born'])) {
                $results[$key]['User']['born'] = $this->dateFormatAfterFind(
                        $val['User']['born']
                );
            }
        }
        return $results;
    }

    public function dateTimeFormatAfterFind($dateString) {
        return date('d.m.Y H:i:s', strtotime($dateString));
    }

    public function dateFormatAfterFind($dateString) {
        return date('d.m.Y', strtotime($dateString));
    }

}
