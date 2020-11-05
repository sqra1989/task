<?php

App::uses('AppController', 'Controller');

/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RolesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session',
        'DataTable.DataTable' => array(
            'roles' => array(
                'debug' => false,
                'model' => 'Role',
                'columns' => array(
                    'Role.name' => array(
                        'type' => 'text',
                        'label' => 'Nazwa',
                        'elementClass' => 'form-control',
                    ),
                    'Custom' => array(
                        'useField' => false,
                        'type' => 'select',
                        'select2' => array(
                            'placeholder' => '',
                            'allowClear' => true
                        ),
                        'elementOptions' => 'customlist',
                        'label' => 'Typy zadań',
                        'elementClass' => 'form-control',
                        'prefilter' => [
                            'RolesTasktype' => [
//                                'type' => 'list',
//                                'extract' => 'Phone.employee_id',//for other type than list
                                'queryType' => 'exact', //startWith, endWith, contain //default: contain
                                'applyTo' => 'Role.id',
                                'queryField' => 'RolesTasktype.tasktype_id',
                                'parms' => [
                                    'fields' => ['RolesTasktype.role_id', 'RolesTasktype.role_id'],
                                    'conditions' => [],
                                ],
                            ]
                        ],
                    ),
                    'Custom2' => array(
                        'useField' => false,
                        'type' => 'select',
                        'select2' => array(
                            'placeholder' => '',
                            'allowClear' => true
                        ),
                        'elementOptions' => 'custommlist',
                        'label' => 'Projekty',
                        'elementClass' => 'form-control',
                        'prefilter' => [
                            'ProjectsRole' => [
//                                'type' => 'list',
//                                'extract' => 'Phone.employee_id',//for other type than list
                                'queryType' => 'exact', //startWith, endWith, contain //default: contain
                                'applyTo' => 'Role.id',
                                'queryField' => 'ProjectsRole.project_id',
                                'parms' => [
                                    'fields' => ['ProjectsRole.role_id', 'ProjectsRole.role_id'],
                                    'conditions' => [],
                                ],
                            ]
                        ],
                    ),
                    'dodatkowe' => array(
                        'useField' => false,
                        'label' => 'Dodatkowe uprawnienia',
                    ),
                    'actions' => [
                        'useField' => false,
                        'label' => 'Actions',
                    ],
                ),
                'conditions' => array('Role.symbol!="admin"'),
                //'contain' => array('Scheme'),
                'fields' => array('Role.id', 'Role.type'),
                'order' => array('Role.id ASC'),
                'autoData' => false,
                'autoRender' => false
            ),
    ));

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->_index($this->Role, 'roles');
        $this->Role->Project->recursive = 0;
        $this->set('custommlist', $this->Role->Project->find('list'));

        $this->Role->Tasktype->recursive = 0;
        $this->set('customlist', $this->Role->Tasktype->find('list'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Role->exists($id)) {
            throw new NotFoundException(__('Invalid role'));
        }
        $options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
        $this->set('role', $this->Role->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Role->create();
            $this->Role->data['Role']['symbol'] = 'user';
            if ($this->Role->save($this->request->data)) {
                $this->Session->setFlash(__('The role has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The role could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        }
        $tasktypes = $this->Role->Tasktype->find('list');
        $projects = $this->Role->Project->find('list');
        $this->set(compact('projects', 'tasktypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Role->exists($id)) {
            throw new NotFoundException(__('Invalid role'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Role->save($this->request->data)) {
                $this->Session->setFlash(__('The role has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The role could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
            $this->request->data = $this->Role->find('first', $options);
        }
        $tasktypes = $this->Role->Tasktype->find('list');
        $projects = $this->Role->Project->find('list');
        $this->set(compact('projects', 'tasktypes'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Role->id = $id;
        if (!$this->Role->exists()) {
            throw new NotFoundException(__('Invalid role'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Role->delete()) {
            $this->Session->setFlash(__('The role has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The role could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow everything to not logged user except admin pages
        if (isset($this->params["admin"]) && $this->params["admin"]) {
            $this->Auth->deny();
        } else {
            $this->Auth->allow(array(''));
        }
    }

    public function isAuthorized($user) {

        switch ($this->request->params['action']) {
            default:
                $allowedRoles = array('admin');
                break;
        }

        if (in_array($user['Role']['symbol'], $allowedRoles)) {
            return TRUE;
        } else {
            return FALSE;
        }
        //parent::isAuthorized($user);
    }

}
