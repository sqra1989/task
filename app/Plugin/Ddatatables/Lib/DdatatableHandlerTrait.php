<?php

trait DdatatableHandlerTrait {

    public function _filter_user_conditions($conditions, $fields, $model, &$config = null) {
        $clean = [];
        foreach ($conditions as $key => $val) {
            if (is_numeric($key)) {
                $clean[$key] = $this->_filter_user_conditions($val, $fields, $model, $config);
                continue;
            }

            if (is_array($val)) {
                if (!($key == 'OR' || $key == "AND")) {
                    throw new BadRequestException("Condition Keys Blackholed. Not allowed Group Key");
                }
                $clean[$key] = $this->_filter_user_conditions($val, $fields, $model, $config);
                continue;
            }

            if ($key[0] === "+") {
                if (method_exists($model, '_datatables_handle_extra_conditions')) {
                    $ret = $model->_datatables_handle_extra_conditions($key, $val, $config);
                    if ($ret) {
                        $clean[] = $ret;
                    }
                }
//                

                continue;
            }

            $tkey = explode(" ", $key, 2);
            if (isset($tkey[1])) {
                if (!in_array($tkey[1], [
                            "=",
                            ">",
                            ">=",
                            "<",
                            "<=",
                            "!=",
                            "LIKE %...%",
                            "NOT LIKE %...%",
                            "LIKE ...%",
                            "LIKE %...",
                            "LIKE",
                            "NOT LIKE",
                            "IS NULL",
                            "IS NOT NULL",
                        ])) {
                    throw new BadRequestException("Condition Keys Blackholed. Not allowed Modifier");
                }

                if (!in_array($tkey[0], $fields)) {
                    throw new BadRequestException("Condition Keys Blackholed. Field not allowed");
                }

                switch ($tkey[1]) {
                    case "LIKE %...%":
                        $val = "%" . $val . "%";
                        $tkey[1] = "LIKE";
                        break;
                    case "NOT LIKE %...%":
                        $val = "%" . $val . "%";
                        $tkey[1] = "NOT LIKE";
                        break;
                    case "LIKE ...%":
                        $val = $val . "%";
                        $tkey[1] = "LIKE";
                        break;
                    case "LIKE %...":
                        $val = "%" . $val;
                        $tkey[1] = "LIKE";
                        break;
                    case "IS NULL":
                        $val = null;
                    case "IS NOT NULL":
                        $val = null;
                }

                if ($val === null) {
                    $clean[] = join(" ", $tkey);
                } else {
                    $clean[join(" ", $tkey)] = $val;
                }
            } else {
                if (!in_array($tkey[0], $fields)) {
                    throw new BadRequestException(__("Condition Keys Blackholed. Field %s not allowed", $tkey[0]));
                }

                $clean[$tkey[0]] = $val;
            }
        }
        return $clean;
    }

    public function processDataTableRequest() {
        $confign = $this->request->query('config');
//        if (method_exists($this, $confign)) { //it opens a backdor to execute commands that you don't have access to!!
//            $this->setAction($confign);
//            return;
//        }

        if (!isset($this->DataTable->settings[$confign])) {
            $this->loadModel("Ddatatables.Ddatatable");
            if (($tmp = $this->Ddatatable->getConfig($confign))) {
                $this->DataTable->settings[$confign] = $tmp;
            }
        }

        if (!isset($this->DataTable->settings[$confign])) {
            throw new NotFoundException(__("DataTable %s not found", $confign));
        }

        $rawconfig = &$this->DataTable->settings[$confign];

        if (!isset($rawconfig['model']) || !$rawconfig['model']) {
            $rawconfig['model'] = $confign;
        }

        $rawconfig['orgmodel'] = $rawconfig['model'];
        list($plugin, $rawconfig['model']) = pluginSplit($rawconfig['model']);
        if (!isset($this->{$rawconfig['model']})) {
            $this->loadModel($rawconfig['orgmodel']);
        }

        if (isset($rawconfig['acl']) && $rawconfig['acl']) {
            if (!$this->_aclCheck($rawconfig['acl'])) {
                throw new UnauthorizedException("Access denied");
            }
        }

        if (array_key_exists('applyConfig', $rawconfig)) {
            $this->_handle_applyConfig($rawconfig);
        }

        if (isset($this->request->query['conditions'])) {
            $userConditions = $this->request->query['conditions'];
//            var_dump($this->request->query['conditions']);exit;
            if (!isset($rawconfig['conditions'])) {
                $rawconfig['conditions'] = [];
            }

            //TODO: add security filters, allow only fields + modifiers as key like
            //"Ticket.name" => ...
            //"Ticket.number LIKE" =>...
            //"Ticket.name IS NULL" => ...
            $schema = $this->_generateMysqlSchema($this->{$rawconfig['model']});
            $userConditions2 = $this->_filter_user_conditions($userConditions, array_keys($schema['fieldinfo']), $this->{$rawconfig['model']}, $rawconfig);

            $rawconfig['conditions'][] = $userConditions2;
        }

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
                        if (isset($rawconfig['debug']) && $rawconfig['debug']) {
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

        $config = $this->DataTable->paginate($confign);
        $element_path='';
        if(isset($this->request->params['plugin'])){
            $element_path = APP . 'Plugin' . DS . Inflector::camelize($this->request->params['plugin']) . DS . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . Inflector::underscore($confign) . $this->ext;
        }
        if (!file_exists($element_path)) {
            $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . Inflector::underscore($confign) . $this->ext;
            if (!file_exists($element_path)) {
                $this->viewPath = "Elements";
            }

            $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . Inflector::underscore($confign) . $this->ext;
            if (!file_exists($element_path)) {
                $this->view = "default";
            }
        }
        //$this->x();
        if (isset($rawconfig['debug']) && $rawconfig['debug']) {
            $customdebug['conditions'] = $config->conditions;
        }
        $this->set(compact('rawconfig', 'config', 'customdebug'));
//        $this->Model->force_stop_debug();
        return $config;
    }

    private function __translate_only_strings($el) {
        if (empty($el)) {
            return $el;
        }

        if (is_numeric($el)) {
            return $el;
        }

        if (!is_string($el)) {
            return $el;
        }

        $translated = __($el);
        return empty($translated) ? $el : $translated;
    }

    public function _generateMysqlSchema($model, $level = 2, $prefix = true) {
        /* @var $model Model */
        $schema = ['fieldlist' => [], 'fieldinfo' => [], 'contain' => []];
        if ($level <= 0) {
            return $schema; //to nasted
        }

        if (is_array($model->simpleExport)) {
            return $model->simpleExport;
        }

        $db = $model->getDataSource();
        $x = $db->describe($model);

        $lastPrefix = $prefix;

        if ($prefix === true) {
            $prefix = $model->alias . ".";
        }
        $translated_prefix = join(".", array_map([$this, '__translate_only_strings'], explode(".", $prefix)));

        if ($prefix === false) {
            $prefix = "";
        }

        foreach ($x as $key => $val) {
            $schema['fieldlist'][] = $prefix . $key;
            $val['translated_model'] = $translated_prefix . $key;
            $val['translated'] = $translated_prefix . (isset($val['comment']) ? __($val['comment']) : __($key));
            $schema['fieldinfo'][$prefix . $key] = $val;
        }

        foreach (['hasOne', 'belongsTo'] as $typ) {
            if (isset($model->{$typ})) {
                foreach ($model->{$typ} as $submodel => $settings) {
                    if ($submodel == $model->alias) {
                        continue;
                    }
                    $schema['contain'][$submodel] = [];
                    if (is_string($settings)) {
                        $submodel = $settings;
                        $settings = [];
                    }
                    $ret = $this->_generateMysqlSchema($model->{$submodel}, ($level - 1), ((is_string($lastPrefix)) ? $lastPrefix : "") . $submodel . ".");
                    $schema['fieldlist'] = array_merge($schema['fieldlist'], $ret['fieldlist']);
                    $schema['fieldinfo'] = array_merge($schema['fieldinfo'], $ret['fieldinfo']);
                    $schema['contain'][$submodel] = $ret['contain'];
                }
            }
        }

        if (isset($model->hasMany)) {
            foreach ($model->hasMany as $submodel => $settings) {
                if ($submodel == $model->alias) {
                    continue;
                }
                $schema['contain'][$submodel] = [];
                if (is_string($settings)) {
                    $submodel = $settings;
                    $settings = [];
                }
                $ret = $this->_generateMysqlSchema($model->{$submodel}, ($level - 1), ((is_string($lastPrefix)) ? $lastPrefix : "+") . $submodel . ".0.");
                $schema['fieldlist'] = array_merge($schema['fieldlist'], $ret['fieldlist']);
                $schema['fieldinfo'] = array_merge($schema['fieldinfo'], $ret['fieldinfo']);
                $schema['contain'][$submodel] = $ret['contain'];
            }
        }

        return $schema;
    }

    protected function _view_getExtensions() {
        $exts = array($this->ext);
        if ($this->ext !== '.ctp') {
            $exts[] = '.ctp';
        }
        return $exts;
    }

    var $_pathsForPlugin = [];
    var $_paths = [];

    protected function _view_paths($plugin = null, $cached = true) {
        if ($cached === true) {
            if ($plugin === null && !empty($this->_paths)) {
                return $this->_paths;
            }
            if ($plugin !== null && isset($this->_pathsForPlugin[$plugin])) {
                return $this->_pathsForPlugin[$plugin];
            }
        }
        $paths = array();
        $viewPaths = App::path('View');
        $corePaths = array_merge(App::core('View'), App::core('Console/Templates/skel/View'));

        if (!empty($plugin)) {
            $count = count($viewPaths);
            for ($i = 0; $i < $count; $i++) {
                if (!in_array($viewPaths[$i], $corePaths)) {
                    $paths[] = $viewPaths[$i] . 'Plugin' . DS . $plugin . DS;
                }
            }
            $paths = array_merge($paths, App::path('View', $plugin));
        }

        $paths = array_unique(array_merge($paths, $viewPaths));
        if (!empty($this->theme)) {
            $theme = Inflector::camelize($this->theme);
            $themePaths = array();
            foreach ($paths as $path) {
                if (strpos($path, DS . 'Plugin' . DS) === false) {
                    if ($plugin) {
                        $themePaths[] = $path . 'Themed' . DS . $theme . DS . 'Plugin' . DS . $plugin . DS;
                    }
                    $themePaths[] = $path . 'Themed' . DS . $theme . DS;
                }
            }
            $paths = array_merge($themePaths, $paths);
        }
        $paths = array_merge($paths, $corePaths);
        if ($plugin !== null) {
            return $this->_pathsForPlugin[$plugin] = $paths;
        }
        return $this->_paths = $paths;
    }

    public function _pluginSplit($name, $fallback = true) {
        $plugin = null;
        list($first, $second) = pluginSplit($name);
        if (CakePlugin::loaded($first) === true) {
            $name = $second;
            $plugin = $first;
        }
        if (isset($this->plugin) && !$plugin && $fallback) {
            $plugin = $this->plugin;
        }
        return array($plugin, $name);
    }

    public function _view_exists($name = null) {

        if ($name === null) {
            $name = $this->view;
        }

        $subDir = null;

        if ($this->subDir !== null) {
            $subDir = $this->subDir . DS;
        }

        if ($name === null) {
            $name = $this->view;
        }
        $name = str_replace('/', DS, $name);
        list($plugin, $name) = $this->_pluginSplit($name);

        if (strpos($name, DS) === false && $name[0] !== '.') {
            $name = $this->viewPath . DS . $subDir . Inflector::underscore($name);
        } elseif (strpos($name, DS) !== false) {
            if ($name[0] === DS || $name[1] === ':') {
                $name = trim($name, DS);
            } elseif ($name[0] === '.') {
                $name = substr($name, 3);
            } elseif (!$plugin || $this->viewPath !== $this->name) {
                $name = $this->viewPath . DS . $subDir . $name;
            }
        }
        $paths = $this->_view_paths($plugin);
        $exts = $this->_view_getExtensions();
        foreach ($exts as $ext) {
            foreach ($paths as $path) {
                if (file_exists($path . $name . $ext)) {
                    return $path . $name . $ext;
                }
            }
        }

        return false;
    }

    public function _handle_applyConfig(&$config) {
        if (!is_array($config['applyConfig'])) {
            $config['applyConfig'] = [$config['applyConfig']];
        }

        foreach ($config['applyConfig'] as $applynewname) {
            if (!isset($this->DataTable->settings[$applynewname])) {
                $this->loadModel("Ddatatables.Ddatatable");
                if (($tmp = $this->Ddatatable->getConfig($applynewname))) {
                    $this->DataTable->settings[$applynewname] = $tmp;
                }
            }
            if (!isset($this->DataTable->settings[$applynewname])) {
                if (isset($this->Flash)) {
                    $this->Flash->warning(__("Unknown datatable config: %s", $applynewname));
                } else {
                    $this->Session->setFlash(__("Unknown datatable config: %s", $applynewname), 'default', array('class' => 'alert alert-info'));
                }
                continue;
            }

            if (isset($this->DataTable->settings[$applynewname]['acl']) && $this->DataTable->settings[$applynewname]['acl'] !== false) {
                if (!$this->_aclCheck($this->DataTable->settings[$applynewname]['acl'])) {
                    continue;
                }
            }
            if (array_key_exists('override', $this->DataTable->settings[$applynewname])) {
                foreach ($this->DataTable->settings[$applynewname]['override'] as $key => $val) {
                    HashIt::set_nested_array_value($config, $key, $val);
                }
            }
        }
    }

    /**
     * Renders 
     * 
     * @param Model $model Model that will be used to find data
     * @param string $name Name of the datatable setting that will be used to render datatables
     * @param array $pconditions Parameters send over http get ...
     * @param array $conditions Not implemented (for now)
     */
    public function _index($model, $name = null, $pconditions = null, $conditions = null) {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }

        if ($name == null) {
            $name = $model->name;
        }

        if ($pconditions != null) {
            if (!is_array($pconditions)) {
                $pconditions = [$pconditions];
            }
            if (!isset($this->DataTable->settings[$name]['viewVars']['js']['sAjaxSource'])) {
                $this->DataTable->settings[$name]['viewVars']['js']['sAjaxSource'] = array('action' => 'processDataTableRequest');
            }
            $this->DataTable->settings[$name]['viewVars']['js']['sAjaxSource'] = array_merge($this->DataTable->settings[$name]['viewVars']['js']['sAjaxSource'], $pconditions);
//            var_dump($this->DataTable->settings[$name]);exit;
//            var_dump($this->DataTable->settings[$name]['js']['sAjaxSource']);exit;
        }

//        DebugTimer::start("init_view_path");

        if ($this->_view_exists() === false) {
            $this->viewPath = "Elements";
            $this->view = 'datatable' . DS . $this->action;
        }

        if ($this->_view_exists() === false) {
            $this->view = 'datatable' . DS . 'index';
        }

//        DebugTimer::stop("init_view_path");
//        var_dump($this->_view_exists());exit;
//        $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . $this->action . $this->ext;
//        if (!file_exists($element_path)) {
//            $this->viewPath = "Elements";
//            $this->view = 'datatable' . DS . $this->action;
//        }
//
//        $element_path = APP . 'View' . DS . $this->viewPath . DS . 'datatable' . DS . $this->action . $this->ext;
//        if (!file_exists($element_path)) {
//            $this->view = "datatable" . DS . "index";
//        }

        $config = &$this->DataTable->settings[$name];
        if (array_key_exists('applyConfig', $config)) {
            $this->_handle_applyConfig($config);
        }

        if (isset($this->DataTable->settings[$name]['viewVars'])) {
            $this->set($this->DataTable->settings[$name]['viewVars']);
        }

        if (isset($this->DataTable->settings[$name]['getVars'])) {
            foreach ($this->DataTable->settings[$name]['getVars'] as $key => $vars) {
                $var = array_merge(['model' => $model->name, 'type' => 'list', 'parms' => [], 'method' => false], $vars);
                $this->loadModel($var['model']);
                if ($var['method']) {
                    $var['method'] = "get" . $var['method'];
                    if (method_exists($this->{$var['model']}, $var['method'])) {
                        $this->set($key, $this->{$var['model']}->{$var['method']}());
                    } else {
                        throw new NotFoundException(__("Method " . $var['method'] . " not exists"));
                    }
                } else {
                    $this->set($key, $this->{$var['model']}->find($var['type'], $var['parms']));
                }
            }
        }

        DebugTimer::start('generate_mysql_schema');
        $modelSchema = null;
        if (method_exists($model, '_datatables_get_schema')) {
            $modelSchema = $model->_datatables_get_schema();
        }
        if ($modelSchema === null) {
            if (method_exists($model, '_generateMysqlSchema')) {
                $modelSchema = $model->_generateMysqlSchema();
            } else {
                $modelSchema = $this->_generateMysqlSchema($model);
            }
        }

        if (method_exists($model, '_filterConditionMysqlSchema')) {
            $modelSchema = $model->_filterConditionMysqlSchema($modelSchema, $config);
        }

//        var_dump($modelSchema);exit;
        DebugTimer::stop('generate_mysql_schema');

        $this->set(compact(['name', 'config', 'modelSchema']));

        if (($custom_conditions = $this->request->query('custom_conditions'))) {

            $this->set('custom_conditions', json_encode(['custom_conditions' => $custom_conditions]));
        }

        $this->DataTable->setViewVar($name);
    }

    public function ddatatable($code) {
        if (!isset($this->Ddatatable)) {
            $this->loadModel("Ddatatables.Ddatatable");
        }

        $dtt = $this->Ddatatable->getConfig($code);
        if ($dtt == null) {
            throw new NotFoundException("DataTable not found");
        }

        if (isset($dtt['acl']) && $dtt['acl']) {
            if (!$this->_aclCheck($dtt['acl'])) {
                throw new UnauthorizedException("Access denied");
            }
        }

        $this->DataTable->settings[$code] = $dtt;

        $model = $code;
        if (isset($dtt['model'])) {
            $model = $dtt['model'];
        }

        list($plugin, $name) = pluginSplit($model);
        if (!isset($this->{$name})) {
            $this->loadModel($model);
        }

        $this->_index($this->{$name}, $code);
    }

}
