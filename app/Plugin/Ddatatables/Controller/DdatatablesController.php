<?php

App::uses('AppController', 'Controller');

/**
 * Ddatatables Controller
 *
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class DdatatablesController extends DdatatablesAppController {

    public $uses = array("Ddatatables.Ddatatable");

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Paginator',
        'Session',
        'DataTable.DataTable' => array(
            'Ddatatable' => array(
                'columns' => array(
                    'controller' => array(
                        'type' => 'text',
                    ),
                    'model' => array(
                        'type' => 'text',
                    ),
                    'code' => array(
                        'type' => 'text',
                    ),
                    'Actions2' => [
                        'useField' => false,
                        'label' => 'Akcje',
                        'actions' => [
//                            'edit' => [
//                                'class' => 'green',
//                                'name' => "Edytuj",
//                                'acl' => true,
//                            ],
                            'rawedit' => [
                                'class' => 'green',
                                'name' => "Edytuj",
                                'acl' => true,
                            ],
                            'view' => [
                                'class' => 'green',
                                'name' => "Zobacz",
                                'acl' => true,
                            ],
                            'delete' => [
                                'class' => 'red',
                                'name' => 'Usuń',
                                'question_value' => 'Ddatatable.code',
                                'acl' => true,
                            ],
                        ]
                    ],
                ),
                'contain' => array(),
                'fields' => array(
                    'id'
                ),
                'autoData' => false,
                'autoRender' => false
            ),
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->_index($this->Ddatatable);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
//    public function view($id = null) {
//        if (!$this->Ddatatable->exists($id)) {
//            throw new NotFoundException(__('Invalid dview group'));
//        }
//        $options = array('conditions' => array('Ddatatable.' . $this->DdatatableGroup->primaryKey => $id));
//        $this->set('dviewGroup', $this->DdatatableGroup->find('first', $options));
//    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
//        $this->view = "edit";
//        $this->edit(null);
//        $this->view = "rawedit";
//        $this->rawedit(null);
        if ($this->request->is(['put', 'post'])) {
            $table = $this->_get_datatable($this->request->data['Ddatatable']['template']);
            if ($table == null) {
                throw new NotFoundException("Unknown ddatatable");
            }

            if ($this->Ddatatable->save(['Ddatatable' => [
                            'code' => $this->request->data['Ddatatable']['code'],
                            'settings' => $table,
                ]])) {
                $this->redirect(['action' => 'rawedit', $this->Ddatatable->id]);
            };
        }

        $lists = $this->_list_datatables();
        $this->set('templates', array_combine($lists, $lists));
    }

    private function _add_to_menu() {
        $settings = json_decode($this->request->data['Ddatatable']['settings'], true);
        if (!($settings && isset($settings['controller']) && !empty($settings['controller']))) {
            die("nie znaleziono ustawien! O_o");
            return;
        }

        if (!isset($this->Dmenu)) {
            $this->loadModel("Dmenu.Dmenu");
        }

        $parent = $this->Dmenu->find("first", ['conditions' => ['Dmenu.name' => $settings['controller']]]);
        if (!$parent) {
            die("nie znaleziono menu! O_o");
            return;
        }

        $this->Dmenu->create();
        $this->Dmenu->save(['Dmenu' => [
                'name' => "generated_" . $this->request->data['Ddatatable']['code'],
                'parent_id' => $parent['Dmenu']['id'],
                'settings' => json_encode([
                    'title' => (isset($settings['title'])) ? $settings['title'] : 'Tabela ' . $this->request->data['Ddatatable']['code'],
                    'icon' => "<i class='icon-list'></i>",
                    'active' => true,
                    'url' => [
                        'plugin' => null,
                        'controller' => $settings['controller'],
                        'action' => 'ddatatable',
                        $this->request->data['Ddatatable']['code']
                    ]
                ]),
        ]]);
    }

    public function _after_saveAll($options = []) {
        if ($this->action == 'add' && CakePlugin::loaded("Dmenu")) {
            $this->_add_to_menu();
        }
        return parent::_after_saveAll();
    }

//    public function _get_fields($modelName){
//        $this->loadModel($modelName);
//        $model = $this->$modelName;
//        $fields = $model->schema();
//        
////        $this->$model->schema()
//        var_dump($fields);
//        
//        exit;
//    }

    public $fullContainMap = array(
        'DdatatableField'
    );

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null/* , $method = null */) {
        $this->view = 'rawedit';
        return $this->_edit($this->Ddatatable, $id);
    }

    public function rawedit($id = null/* , $method = null */) {
        return $this->_edit($this->Ddatatable, $id);
    }

    public function _before_saveAll($options = []) {
        $ar = json_decode($this->request->data['Ddatatable']['settings'], true);
        $ar['autoData'] = false;
        if ($this->action == 'rawedit' || $this->action == 'add') {
            $this->request->data['Ddatatable']['model'] = $ar['model'];
            $this->request->data['Ddatatable']['controller'] = $ar['controller'];
        } else {
            $ar['model'] = $this->request->data['Ddatatable']['model'];
            $ar['controller'] = $this->request->data['Ddatatable']['controller'];
        }
        $this->request->data['Ddatatable']['datatable'] = json_encode($ar);
    }

    private function _delete_from_menu($data) {
        $settings = json_decode($data['Ddatatable']['settings'], true);
        if (!($settings && isset($settings['controller']) && !empty($settings['controller']))) {
            die("nie znaleziono ustawien! O_o");
            return;
        }

        if (!CakePlugin::loaded("Dmenu")) {
            return;
        }

        if (!isset($this->Dmenu)) {
            $this->loadModel("Dmenu.Dmenu");
        }

        $x = $this->Dmenu->find('first', ['conditions' => ['Dmenu.name' => "generated_" . $data['Ddatatable']['code']], 'contain' => []]);
        if ($x) {
            $this->Dmenu->delete($x['Dmenu']['id']);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Ddatatable->id = $id;
        if (!$this->Ddatatable->exists()) {
            throw new NotFoundException(__('Invalid dview group'));
        }
        $this->request->onlyAllow('post', 'delete');
        $data = $this->Ddatatable->find('first', ['conditions' => ['Ddatatable.id' => $id], 'contain' => []]);
        if ($this->Ddatatable->delete()) {
            $this->_delete_from_menu($data);
            $this->Session->setFlash(__('The dview group has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The dview group could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

//
//    public function isAuthorized($user) {
//
//        switch ($this->request->params['action']) {
//            default:
//                $allowedRoles = array('admin');
//                break;
//        }
//
//        if (in_array($user['Role']['symbol'], $allowedRoles)) {
//            return true;
//        }
//
//        return parent::isAuthorized($user);
//    }

    public function _add_edit_selects_data($options = []) {
//        $models = array('Employee' => __('Employee'), 'Operator' => __('Operator'));
        $models2 = $this->_get_models();
        $models = array_combine($models2, $models2);

        $controller2 = $this->_get_controllers();
        $controllers = array_combine($controller2, $controller2);

        $types2 = array("text", "select", "date", "datetime", "checkbox");
        $types = array_combine($types2, $types2);

        $this->set(compact('models', 'types', 'controllers'));
    }

    private function _get_controllers() {
        $list = App::objects('controller');
        foreach (App::objects('plugin') as $plugin) {
            foreach (App::objects($plugin . '.controller') as $controller) {
                $list[] = $plugin . "." . $controller;
            }
        }
        return $list;
    }

    private function _get_models() {
        return App::objects('model');
    }

    private function _list_datatables() {
        $dt = $this->_get_datatables();
        return array_keys(Hash::flatten($dt));
    }

    private function _get_datatable($dtname = null) {
        $dt_list = $this->_get_datatables();
        return Hash::get($dt_list, $dtname);
    }

    private function _get_datatables() {
        $dt_list = [];
        $aCtrlClasses = $this->_get_controllers();
//        var_dump($aCtrlClasses);exit;
        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));
                $list = [];

                list($p, $cname) = pluginSplit($controller);

//                $class = new ReflectionClass($c);
//                $parameter_list = $class->getConstructor()->getParameters();
//                if (!empty($parameter_list)) {
//                    var_dump($parameter_list);
////                    continue;
//                }

                $c = new $cname(null, null);
                if (isset($c->components['DataTable.DataTable'])) {
                    foreach ($c->components['DataTable.DataTable'] as $name => $table) {
                        if (!array_key_exists('controller', $table)) {
                            $table['controller'] = lcfirst($c->name); //i think it's not best solution
                        }
                        $list[$name] = json_encode($table);
//                        echo "Name:" . $name . "<br/>";
//                        echo "<textarea>" . json_encode($table) . "</textarea>";
//                        echo "<br/><br/>";
                    }
                }
                if (!empty($list)) {
                    $dt_list[($p ? $p . " - " : "") . $cname] = $list;
                }
            }
        }

        return $dt_list;
    }

    public function debug() {

        $this->autoRender = false;

        $aCtrlClasses = $this->_get_controllers();

        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));

                var_dump($controller);

                $c = new $controller();
                if (isset($c->components['DataTable.DataTable'])) {
                    foreach ($c->components['DataTable.DataTable'] as $name => $table) {
                        if (!array_key_exists('controller', $table)) {
                            $table['controller'] = lcfirst($c->name); //i think it's not best solution
                        }
                        echo "Name:" . $name . "<br/>";
                        echo "<textarea>" . json_encode($table) . "</textarea>";
                        echo "<br/><br/>";
                    }
                }
            }
        }

        exit;
    }

    public function view($id) {
        $this->_view($this->Ddatatable, $id);
        $dane = $this->request->data['Ddatatable'];

        $url = [
            'action' => 'ddatatable',
            $dane['code']
        ];

//        var_dump($dane);exit;

        if (isset($dane['controller']) && !empty($dane['controller'])) {
            $url['plugin'] = null;
            $url['controller'] = $dane['controller'];
        }

        $this->redirect($url);
    }

    public function distinct($model, $field) {

        if (empty($this->request->params['requested'])) {
            throw new ForbiddenException();
        }

//        if (!$this->_aclCheck("controllers/Ddatatables/Ddatatables/distinct/".$field)) {
//            return false;
//        }


        list($plugin, $name) = pluginSplit($model);
        if (!isset($this->{$name})) {
            $this->loadModel($model);
        }
        $list = $this->{$name}->find("all", ['fields' => 'DISTINCT ' . $field]);
        $lista = Hash::extract($list, "{n}." . $name . "." . $field);
        return array_combine($lista, $lista);
    }

}
