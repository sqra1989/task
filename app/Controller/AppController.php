<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('DataTableRequestHandlerTrait', 'DataTable.Lib');
App::uses('HashIt', 'Utility');
App::uses('ImageComponent', 'Controller/Component');
//App::uses('DdatatableHandlerTrait', 'Ddatatables.Lib');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

//use DdatatableHandlerTrait;
    public $loginAttemptLimit = 5;
    public $loginAttemptDuration = '+1 hour';
    public $uses = array('User', 'Role');
    protected $exportDir = WWW_ROOT . 'export';
    public $components = array(
        'DebugKit.Toolbar',
        'Cookie',
        //   'Acl',
        'Auth' => array(
            'authorize' => array(
                'Controller',
            //           'Actions' => array('actionPath' => 'controllers/')
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    )
                )
            ),
            'flash' => array(
                'element' => 'alert',
                'key' => 'auth',
                'params' => array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error'
                )
            )
        ),

        'Session',
        'RequestHandler',
        'DataTable.DataTable',
//        'Security',
        'Attempt.Attempt'
    );
    public $helpers = array(
        'Session',
        'Html' => array(
            'className' => 'BoostCake.BoostCakeHtml'
        ),
        'Form' => array(
            'className' => 'BoostCake.BoostCakeForm'
        ),
        'Paginator' => array(
            'className' => 'BoostCake.BoostCakePaginator'
        ),

        'Js' => array('Jquery'),
        'ThumbnailsPlugin.Thumbnail',
        'I18n.I18n',
        'MinifyHtml.MinifyHtml',
        'Minify.Minify',
        'DataTable.DataTable',
    );
    public $is_admin;




    protected function numberTocurrency($amount, $sign) {

        switch ($sign) {
            case 'PLN':
                return number_format($amount, 2) . ' zł';
                break;
            case 'EUR':
                return '€' . number_format($amount, 2);
                break;
            default :
                return number_format($amount, 2);
                break;
        }
    }

    protected function getSlug($name) {
        $slug = preg_replace('~[^\\pL\d]+~u', '-', $name);
        // trim
        $slug = trim($slug, '-');
        // transliterate
        $pattern = array("'ą'", "'ć'", "'ę'", "'ł'", "'ń'", "'ó'", "'ś'", "'ź'", "'ż'", "'Ł'", "'Ś'", "'ź'", "'ż'", "'ö'", "'ä'", "'ß'", "'ü'");
        $replace = array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'l', 's', 'z', 'z', 'o', 'a', 's', 'u');
        $slug = preg_replace($pattern, $replace, $slug);
        // lowercase
        $slug = strtolower($slug);
        // remove unwanted characters
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        return $slug;
    }




    public function processDataTableRequest() {
        $confign = $this->request->query('config');
        if (method_exists($this, $confign)) {
            $this->setAction($confign);
            return;
        }

        if (!isset($this->DataTable->settings[$confign])) {
            $this->loadModel("Ddatatable");
            if (($tmp = $this->Ddatatable->getConfig($confign))) {
                $this->DataTable->settings[$confign] = $tmp;
            }
        }

        $rawconfig = &$this->DataTable->settings[$confign];

//        $custom_conditions = $this->request->query('conditions');
//        var_dump($custom_conditions);
        //TODO: maybe custom event here?

        $i = 0;
        $property = $this->request->is('get') ? 'query' : 'data';
        $params = $this->request->$property;
        $searchTerm = Hash::get($params, 'sSearch');
        $customdebug = []; //array for debug info
        foreach ($rawconfig['columns'] as $column => &$options) {
//            if (isset($options['customSearch'])) {
//                $searchKey = "sSearch_$i";
//                $columnSearchTerm = Hash::get($params, $searchKey);
//
////                if ($searchTerm) {
////                    $conditions['OR'][] = array("$column LIKE" => '%' . $searchTerm . '%');
////                }
//                if ($columnSearchTerm) {
//                    if (is_array($options['customSearch'])) {
//                        foreach ($options['customSearch'] as $path => $cond) {
//                            if (isset($cond['type'])) {
//                                switch ($cond['type']) {
//                                    case 'contain':
//                                        $columnSearchTerm = "%" . $columnSearchTerm . "%";
//                                        break;
//                                    case 'startWith':
//                                        $columnSearchTerm = $columnSearchTerm . "%";
//                                        break;
//                                }
//                            }
//                            $condition = isset($cond['conditions']) ? $cond['conditions'] : [];
//                            if (isset($cond['appendQueryToPath'])) {
//                                if (is_array($cond['appendQueryToPath'])) {
//                                    foreach ($cond['appendQueryToPath'] as $path) {
//                                        $condition = Hash::insert($condition, $path, $columnSearchTerm);
//                                    }
//                                } else {
//                                    $condition = Hash::insert($condition, $cond['appendQueryToPath'], $columnSearchTerm);
//                                    var_dump($tokens = CakeText::tokenize($cond['appendQueryToPath'], '.', '[', ']'));
//                                }
//                            }
//
//
//                            $rawconfig['conditions']['AND'] = Hash::merge((array) Hash::get($rawconfig, 'conditions.AND'), $condition);
////                            var_dump($this->DataTable->settings[$confign]['conditions']);                            exit;
//                        }
//                    } else {
//                        
//                    }
//                }
////                if (is_callable(array($Model, $searchable))) {
////                    $Model->$searchable($column, $searchTerm, $columnSearchTerm, $config);
////                }
//            }
            if (isset($options['prefilter'])) {
                $searchKey = "sSearch_$i";
                $columnSearchTerm = Hash::get($params, $searchKey);
                if (!empty($columnSearchTerm)) {
                    foreach ($options['prefilter'] as $model => $config) {
                        if (isset($config['queryType'])) {
                            switch ($config['queryType']) {
                                default:
                                    $columnSearchTerm2 = $columnSearchTerm;
                                    break;
                                case 'contain':
                                case 'contains':
//                                    $config['queryField'] = $config['queryField']." LIKE";
                                    $columnSearchTerm2 = "%" . $columnSearchTerm . "%";
                                    break;
                                case 'startWith':
                                case 'startsWith':
//                                    $config['queryField'] = $config['queryField']." LIKE";
                                    $columnSearchTerm2 = $columnSearchTerm . "%";
                                    break;
                                case 'endWith':
                                case 'endsWith':
//                                    $config['queryField'] = $config['queryField']." LIKE";
                                    $columnSearchTerm2 = "%" . $columnSearchTerm;
                                    break;
                            }
                        } else {
//                            $config['queryField'] = $config['queryField']." LIKE";
                            $columnSearchTerm2 = "%" . $columnSearchTerm . "%";
                        }
                        $this->loadModel($model);
                        if (!isset($config['type'])) {
                            $config['type'] = 'list';
                        }
                        if (!isset($config['parms'])) {
                            $config['parms'] = [];
                        }
                        if (is_array($config['queryField'])) {
                            foreach ($config['queryField'] as $field) {
                                $config['parms']['conditions']["OR"][$field] = $columnSearchTerm2;
                            }
                        } else {
                            $config['parms']['conditions'][$config['queryField']] = $columnSearchTerm2;
                        }
//                        var_dump($config['parms']);exit;
                        $result = $this->$model->find((isset($config['type']) ? $config['type'] : 'list'), $config['parms']);
                        if ($rawconfig['debug']) {
                            $customdebug[$column]['config'] = $config;
                            $customdebug[$column]['result'] = $result;
                        }
                        if ($config['type'] == 'list') {
                            $ids = array_keys($result);
                        } else {
                            $ids = Hash::extract($result, $config['extract']);
                        }

                        if (!isset($rawconfig["conditions"][$config['applyTo']])) {
                            $rawconfig["conditions"][$config['applyTo']] = $ids;
                        } else {
                            $rawconfig["conditions"][$config['applyTo']] = array_intersect($rawconfig["conditions"][$config['applyTo']], $ids);
                        }
                    }
                }
            }
            ++$i;
        }
        if (isset($rawconfig['uconditions'])) {
            foreach ($rawconfig['uconditions'] as $key => $val) {
                $value = $this->Auth->user($val);
                HashIt::set_nested_array_value($rawconfig['conditions'], $key, $value);
            }
            unset($rawconfig['uconditions']);
        }

        if (isset($rawconfig['pconditions'])) {
            foreach ($rawconfig['pconditions'] as $key => $val) {
                $value = Hash::get($this->request->params, $val);
                HashIt::set_nested_array_value($rawconfig['conditions'], $key, $value);
            }
            unset($rawconfig['pconditions']);
        }

        $config = $this->DataTable->paginate($confign);

        $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . Inflector::underscore($confign) . $this->ext;
        if (!file_exists($element_path)) {
            $this->viewPath = "Elements";
        }

        $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . Inflector::underscore($confign) . $this->ext;
        if (!file_exists($element_path)) {
            $this->view = "default";
        }
//        $this->x();
        $this->set(compact('rawconfig', 'config', 'customdebug'));
//        $this->Model->force_stop_debug();
        return $config;
    }

    public function beforeRender() {

        $this->set('cakeDescription', Configure::read('App.name'));
        $this->set('title_for_layout', Configure::read('App.name'));
    }

    protected function getAccessEvents() {
        
    }

 

    public function beforeFilter() {

        $this->set('backurl', $this->referer());

        $this->layout = Configure::read('App.layout');
        $this->theme = Configure::read('App.theme');

        date_default_timezone_set('Europe/Warsaw');

        $this->user = $this->Session->read('Auth.User');
        $this->set('auth', $this->user);

        // Redirects
        $this->Auth->loginAction = array(
            'controller' => 'index',
            'action' => 'index',
            'admin' => false,
            'plugin' => false
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'index',
            'action' => 'logout',
            'admin' => false,
            'plugin' => false
        );

        $this->Auth->loginRedirect = array(
            'controller' => 'index',
            'action' => 'index',
            'admin' => false,
            'plugin' => false
        );
 

        if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie')) {

            $cookie = $this->Cookie->read('remember_me_cookie');
            //var_dump($cookie); exit;
            if (isset($cookie['email']) and $cookie['password']) {
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email' => $cookie['email'],
                        'User.password' => $cookie['password']
                    ),
                    'contain' => array('Role')
                ));
                //var_dump($user); exit;
            } else {
                $user = array();
            }
            if (isset($user['User']) and is_array($user['User'])) {
                $user = array_merge($user, $user['User']);
            }
            if ($user && !$this->Auth->login($user)) {
                $this->redirect('/users/logout'); // Destroy session & cookie
            } else {
                $this->User->id = $this->Auth->user('id');
            }
        }

        $this->isAdmin = $this->user['Role']['symbol'] == 'admin';
        $this->isUser = $this->user['Role']['symbol'] == 'user';

        $this->set('isAdmin', $this->isAdmin);
        $this->set('isUser', $this->isUser);

        $currentUser = false;
        $b2bMode = false;
        if ($this->isUser) {
            $this->User->recursive = -1;
            $currentUser = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));

            if ($currentUser['User']['type'] == 'b2b') {
                $b2bMode = true;
            }
            //update verification data
          
            /* if (in_array($this->Auth->user('id'), Configure::read('App.htmlEncryptKeysDisableForUser'))) {
              Configure::write('App.htmlEncryptKeys', array());
              } else {
              //Configure::write('App.encriptHtmlKey',md5(Configure::read('App.encriptHtmlKey').$this->Auth->user('id')));
              } */
        }

        $this->set('currentUser', $currentUser);
        $this->set('b2bMode', $b2bMode);
        // Directories
        $this->cacheDir = new Folder(WWW_ROOT . Configure::read('App.cache.dir'), TRUE);
        $this->uploadsCacheDir = new Folder(WWW_ROOT . Configure::read('App.cache.upload.dir'), TRUE);
        $this->thumbsCacheDir = new Folder(WWW_ROOT . Configure::read('App.cache.thumbs.dir'), TRUE);
        $this->uploadsDir = new Folder(WWW_ROOT . Configure::read('App.upload.dir'), TRUE);
        $this->thumbsDir = new Folder(WWW_ROOT . Configure::read('App.thumbs.dir'), TRUE);

        $this->uploadId = $this->Session->id();
        $this->set('uploadsId', $this->uploadId);

        new Folder(WWW_ROOT . Configure::read('Pdf.dir'), TRUE);

        // DataTable
        if ($this->user) {
            $this->Auth->allow(array('processDataTableRequest'));
        }


     

        $this->loadModel('Cmspage');
        $this->Cmspage->recursive = -1;
        $menuCms = $this->Cmspage->find('all', array('conditions' => array('Cmspage.menu' => true), 'order' => array('Cmspage.position ASC')));
        $this->set('menuCms', $menuCms);

        $footerCms = $this->Cmspage->find('all', array('conditions' => array('Cmspage.footer' => true), 'order' => array('Cmspage.position ASC')));
        $this->set('footerCms', $footerCms);

        $this->getAccessEvents();

    }


    public function afterFilter() {
        parent::afterFilter();
    }

    /**
     * Removes invalid attachments
     * 
     * @return null
     */
    public function getFormatedData($date) {
        $date = (int) $date;
        $hours = floor($date / 3600);
        $minutes = floor(($date / 60) % 60);
        $seconds = $date % 60;
        if ($hours < 10) {
            $hours = '0' . $hours;
        }
        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }
        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        }

        return $hours . ':' . $minutes . ':' . $seconds;
        /* $minsec = gmdate("i:s", $date);
          $hours = gmdate("d", $date) * 24 + gmdate("H", $date);

          return $time = $hours . ':' . $minsec; */
    }

    public function _index($model, $name = null, $conditions = null) {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }

        if ($name == null) {
            $name = $model->name;
        }

        $this->DataTable->setViewVar($name);

        $element_path = APP . 'View' . DS . $this->viewPath . DS . $this->action . $this->ext;
        if (!file_exists($element_path)) {
            $this->viewPath = "Elements";
            $this->view = 'datatable' . DS . $this->action;
        }

        $element_path = APP . 'View' . DS . $this->viewPath . DS . $this->action . $this->ext;
        if (!file_exists($element_path)) {
            $this->viewPath = "Elements";
            $this->view = "datatable/index";
        }

        $config = $this->DataTable->settings[$name];
        if (isset($this->DataTable->settings[$name]['viewVars'])) {
            $this->set($this->DataTable->settings[$name]['viewVars']);
        }

        if (isset($this->DataTable->settings[$name]['getVars'])) {
            foreach ($this->DataTable->settings[$name]['getVars'] as $key => $vars) {
                $var = array_merge(['model' => $model->name, 'type' => 'list', 'parms' => []], $vars);
                $this->loadModel($var['model']);
                $this->set($key, $this->{$var['model']}->find($var['type'], $var['parms']));
            }
        }

        $this->set(compact(['name', 'config']));

        if (($custom_conditions = $this->request->query('custom_conditions'))) {
            $this->set('custom_conditions', json_encode(['custom_conditions' => $custom_conditions]));
        }
    }

    protected function _export($model, $name = null, $conditions = null) {
        $confign = $this->request->query('config');
//        if (method_exists($this, $confign)) {
//            $this->setAction($confign);
//            return;
//        }

        if (!isset($this->DataTable->settings[$confign])) {
            $this->loadModel("Ddatatable");
            if (($tmp = $this->Ddatatable->getConfig($confign))) {
                $this->DataTable->settings[$confign] = $tmp;
            }
        }

        $rawconfig = &$this->DataTable->settings[$confign];
        if (isset($rawconfig['prefilter'])) {
            if (is_string($rawconfig['prefilter'])) {
                if (is_callable(array($this, $rawconfig['prefilter']))) {
                    $this->{$rawconfig['prefilter']}($this, $confign, $rawconfig);
                }
            } else {
                foreach ($rawconfig['prefilter'] as $pluginmodel => $methodname) {
                    list($plugin, $modelname) = pluginSplit($pluginmodel);
                    if (!isset($this->$modelname)) {
                        $this->loadModel($pluginmodel);
                    }
                    if (is_callable(array($this->$modelname, $methodname))) {
                        $this->$modelname->$methodname($this, $confign, $rawconfig);
                    }
                }
            }
        }

        $i = 0;
        $property = $this->request->is('get') ? 'query' : 'data';
        $params = $this->request->$property;
        $searchTerm = Hash::get($params, 'sSearch');
        $customdebug = []; //array for debug info
        foreach ($rawconfig['columns'] as $column => &$options) {
            if (isset($options['customfilter'])) {
                $searchKey = "sSearch_$i";
                $columnSearchTerm = Hash::get($params, $searchKey);
                $searchTerm = Hash::get($params, 'sSearch');
                if (!empty($columnSearchTerm) || !empty($searchTerm)) {
                    foreach ($options['customfilter'] as $pluginmodel => $methodname) {
                        list($plugin, $modelname) = pluginSplit($pluginmodel);
                        if (!isset($this->$modelname)) {
                            $this->loadModel($pluginmodel);
                        }
                        if (is_callable(array($this->$modelname, $methodname))) {
                            $this->$modelname->$methodname($column, $searchTerm, $columnSearchTerm, $rawconfig);
                        }
                    }
                }
            }

            if (isset($options['prefilter'])) {
                $searchKey = "sSearch_$i";
                $columnSearchTerm = Hash::get($params, $searchKey);
                if (!empty($columnSearchTerm)) {
                    foreach ($options['prefilter'] as $model => $config) {
                        if (isset($config['queryType'])) {
                            switch ($config['queryType']) {
                                default:
                                    $columnSearchTerm2 = $columnSearchTerm;
                                    break;
                                case 'contain':
                                case 'contains':
//                                    $config['queryField'] = $config['queryField']." LIKE";
                                    $columnSearchTerm2 = "%" . $columnSearchTerm . "%";
                                    break;
                                case 'startWith':
                                case 'startsWith':
//                                    $config['queryField'] = $config['queryField']." LIKE";
                                    $columnSearchTerm2 = $columnSearchTerm . "%";
                                    break;
                                case 'endWith':
                                case 'endsWith':
//                                    $config['queryField'] = $config['queryField']." LIKE";
                                    $columnSearchTerm2 = "%" . $columnSearchTerm;
                                    break;
                            }
                        } else {
//                            $config['queryField'] = $config['queryField']." LIKE";
                            $columnSearchTerm2 = "%" . $columnSearchTerm . "%";
                        }
                        $this->loadModel($model);
                        if (!isset($config['type'])) {
                            $config['type'] = 'list';
                        }
                        if (!isset($config['parms'])) {
                            $config['parms'] = [];
                        }
                        if (is_array($config['queryField'])) {
                            foreach ($config['queryField'] as $field) {
                                $config['parms']['conditions']["OR"][$field] = $columnSearchTerm2;
                            }
                        } else {
                            $config['parms']['conditions'][$config['queryField']] = $columnSearchTerm2;
                        }
//                        var_dump($config['parms']);exit;
                        $result = $this->$model->find((isset($config['type']) ? $config['type'] : 'list'), $config['parms']);
                        if ($rawconfig['debug']) {
                            $customdebug[$column]['config'] = $config;
                            $customdebug[$column]['result'] = $result;
                        }
                        if ($config['type'] == 'list') {
                            $ids = array_keys($result);
                        } else {
                            $ids = Hash::extract($result, $config['extract']);
                        }

                        if (!isset($rawconfig["conditions"][$config['applyTo']])) {
                            $rawconfig["conditions"][$config['applyTo']] = $ids;
                        } else {
                            $rawconfig["conditions"][$config['applyTo']] = array_intersect($rawconfig["conditions"][$config['applyTo']], $ids);
                        }
                    }
                }
            }
            ++$i;
        }
        if (isset($rawconfig['uconditions'])) {
            foreach ($rawconfig['uconditions'] as $key => $val) {
                $value = $this->Auth->user($val);
                HashIt::set_nested_array_value($rawconfig['conditions'], $key, $value);
            }
            unset($rawconfig['uconditions']);
        }

        if (isset($rawconfig['pconditions'])) {
            foreach ($rawconfig['pconditions'] as $key => $val) {
                $value = Hash::get($this->request->params, $val);
                HashIt::set_nested_array_value($rawconfig['conditions'], $key, $value);
            }
            unset($rawconfig['uconditions']);
        }

        // Custom setting
        $this->request->query['iDisplayStart'] = array_key_exists('iExportStart', $this->request->query) ? $this->request->query['iExportStart'] : 0;
        $this->request->query['iDisplayLength'] = array_key_exists('iExportLength', $this->request->query) ? $this->request->query['iExportLength'] : -1;
        $this->DataTable->settings[$confign]['autoData'] = false;
        $this->DataTable->settings[$confign]['autoRender'] = false;

//        var_dump($this->request->query);
//        var_dump($confign);
//        exit;

        $config = $this->DataTable->paginate($confign);

//        $this->set(compact('rawconfig', 'config', 'customdebug'));
//        $this->Model->force_stop_debug();
//        return $config;

        $columns = $config->columns;

        $data = array();
        $new = [];

        // Labels
//        foreach ($columns as $name => $column) {
//            if (isset($column['actions'])) {
//                continue;
//            }
//            $new[$name] = $column['label'];
//        }
//        $data[] = $new;

        foreach ($this->viewVars['dtResults'] as $result) {
            $new = [];
            foreach ($columns as $key => $val) {
                // Unwanted column?
                if (isset($this->DataTable->settings['engine']['columns'][$key]['export']) and!$this->DataTable->settings['engine']['columns'][$key]['export']) {
                    continue;
                }

                if (isset($val['actions'])) {
                    continue;
                } else if (isset($val['virtual'])) {
                    $new[$key] = Hash::get($result, "0." . $key);
                } else if (isset($val['get'])) {
                    $out = [];
                    if (is_array($val['get'])) {
                        foreach ($val['get'] as $key => $val) {
                            $out[$key] = Hash::get($result, $val);
                        }
                    } else {
                        $out = Hash::get($result, $val['get']);
                    }
                    $new[$key] = $out;
                } else if (isset($val['extract'])) {
                    $out = [];
                    if (is_array($val['extract'])) {
                        foreach ($val['extract'] as $key => $val) {
                            $out[$key] = Hash::extract($result, $val);
                        }
                    } else {
                        $out = Hash::extract($result, $val['extract']);
                    }
                    $new[$key] = $out;
                } else {
                    //$x = excplode(".",$key,2);
                    $new[$key] = Hash::get($result, $key); //$result[$x[0]][$x[1]];   
                }
            }
            $data[] = $new;
        }

//        $this->set(compact('data', 'config'));

        $return = $this->viewVars['dataTableData'];
        $return['iExportId'] = array_key_exists('iExportId', $this->request->query) ? $this->request->query('iExportId') : '';
        $return['aaData'] = $data;
        return $return;
    }

    protected function _csv($model, $name = null, $conditions = null) {
        $this->layout = '';
        $confign = $this->request->query('config');
        $this->_export($model, $name, $conditions);
        $this->viewClass = '';
        $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . 'csv' . DS . Inflector::underscore($confign) . $this->ext;
        if (!file_exists($element_path)) {
            $this->viewPath = "Elements" . DS . "datatable";
        }
        $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . 'csv' . DS . Inflector::underscore($confign) . $this->ext;
        if (!file_exists($element_path)) {
            $this->view = "csv";
        } else {
            $this->view = 'datatable' . DS . 'csv' . DS . Inflector::underscore($confign);
        }
    }

}
