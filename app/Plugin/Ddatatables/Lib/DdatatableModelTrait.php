<?php

trait DdatatableModelTrait {

    public function _filterConditionMysqlSchema($modelSchema, $config) {
        if ($modelSchema == false) {
            return $false;
        }

        if ($modelSchema == null) {
            $modelSchema = [];
        }

        if (!isset($modelSchema['fieldinfo'])) {
            $modelSchema['fieldinfo'] = [];
        }

        if (isset($config['custom_condition_fields_append']) && is_array($config['custom_condition_fields_append'])) {
            foreach ($config['custom_condition_fields_append'] as $path => $val) {
                HashIt::set_nested_array_value($modelSchema['fieldinfo'], $path, $val);
            }
        }


        /* debug */
//        foreach($modelSchema['fieldlist'] as $val){
//            echo "                    '".$val."/hidden' => true,\n";
//            echo "                    '".$val."/translated' => '".$modelSchema['fieldinfo'][$val]['translated']."',\n\n";
//        }
//        var_dump($modelSchema);
//        var_dump($config);
//        exit;
        /* end debug */

        return $modelSchema;
    }

    public function __translate_only_strings($el) {
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

    public function _generateMysqlSchema($model = null, $level = 2, $prefix = true) {
        /* @var $model Model */
        if ($model == null) {
            $model = $this;
        }
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

    /**
     * http://book.cakephp.org/2.0/en/models/retrieving-your-data.html#sub-queries
     * @return stdClass|mixed|boolean Returns CakePHP DB Expression
     */
    public function _datatables_get_schema() {
        //TODO: auto generate model schema here not in controller
        /*
         * example
         * 
          return Array
          (
          [fieldlist] => Array
          (
          [0] => Employee.id
          [1] => Employee.user_id
          [2] => Employee.name
          )

          [fieldinfo] => Array
          (
          [Employee.id] => Array
          (
          [type] => integer
          [null] =>
          [default] =>
          [length] => 10
          [unsigned] => 1
          [key] => primary
          )

          [Employee.user_id] => Array
          (
          [type] => integer
          [null] => 1
          [default] =>
          [length] => 10
          [unsigned] => 1
          [key] => index
          )
          [Employee.name] => Array
          (
          [type] => string
          [null] => 1
          [default] =>
          [length] => 255
          [collate] => utf8_general_ci
          [charset] => utf8
          )
          )

          [contain] => Array
          (
          [User] => Array
          (
          [Employee] => Array
          (
          )

          [Operator] => Array
          (
          )

          [Role] => Array
          (
          )

          )

          )

          )

         * 
         */
    }

    /**
     * Handles hasMany querys, it do a query and pass returned ID's or generate a subquery to pass to main query.
     * 
     * Uses http://book.cakephp.org/2.0/en/models/retrieving-your-data.html#sub-queries
     * 
     * Returns:
     * 
     * - null - for temporary default
     * - boolean - for example false
     * - string - for simple sql
     * - Mysql Expression - for more like "statement"
     * 
     * @param type $field
     * @param type $value
     * @return stdClass|mixed|boolean 
     */
    public function _datatables_handle_extra_conditions($field, $value) {
        static $uniqueNumber = 0;
        ++$uniqueNumber;

        $tmp = explode('.', ltrim($field, '+'), 3);
        if (count($tmp) == 3) {
            $fieldAndType = $tmp[2];
            $check = $tmp[1];
            $model = $tmp[0];
        } else {
            //todo, maybe expand the code more
            return false;
        }
//        list($model, $check, $fieldAndType) = explode('.', ltrim($field, '+'), 3);
        if ($check !== "0") {
            return false;
        }

        $tkey = explode(' ', $fieldAndType, 2);

        $NOT = "";
        switch ($tkey[1]) {
            case "LIKE %...%":
                $value = "%" . $value . "%";
                $tkey[1] = "LIKE";
                break;
            case "NOT LIKE %...%":
                $value = "%" . $value . "%";
                $NOT = " NOT";
                $tkey[1] = "LIKE";
                break;
            case "LIKE ...%":
                $value = $value . "%";
                $tkey[1] = "LIKE";
                break;
            case "LIKE %...":
                $value = "%" . $value;
                $tkey[1] = "LIKE";
                break;
            case "IS NULL":
                $value = null;
                unset($tkey[1]);
            case "IS NOT NULL":
                $value = null;
                $tkey[1] = "!=";
        }

        $jfield = join(" ", $tkey);

        if (isset($this->hasMany[$model])) {
            $foreignKey = $this->hasMany[$model]['foreignKey'];
        }
        /* else if(isset($this->hasAndBelongsToMany[$model])){
          $foreignKey = $this->hasAndBelongsToMany[$model]['foreignKey'];
          } */ else {
            throw new NotFoundException("unknown foreign key");
//            return false;
        }

        $db = $this->{$model}->getDataSource();
        $subQuery = $db->buildStatement(
                array(
            'fields' => array($model . $uniqueNumber . '.' . $foreignKey . ''),
            'table' => $db->fullTableName($this->{$model}),
            'alias' => $model . $uniqueNumber,
            'limit' => null,
            'offset' => null,
            'joins' => array(),
            'conditions' => [$model . $uniqueNumber . '.' . $jfield => $value],
            'order' => null,
            'group' => null
                ), $this->{$model}
        );
        $subQuery = $this->alias . '.' . $this->primaryKey . $NOT . ' IN (' . $subQuery . ') ';
        $subQueryExpression = $db->expression($subQuery);

        return $subQueryExpression;
    }

    public function custom_search_daterange_timestamp($column, $searchTerm, $columnSearchTerm, $config) {
        $range = explode(" - ", $columnSearchTerm, 2);
        if (count($range) == 1) {
            return;
        }

        $range[0] = strtotime($range[0]);
        $range[1] = strtotime($range[1]) + 60 * 60 * 24 - 1;

        $conditions = [
            "$column >=" => date("Y-m-d H:i:s", $range[0]),
            "$column <=" => date("Y-m-d H:i:s", $range[1])
        ];

        $config->conditions['AND'] = Hash::merge((array) Hash::get($config->conditions, 'AND'), $conditions);
    }

    public function custom_search_daterange($column, $searchTerm, $columnSearchTerm, $config) {
        $range = explode(" - ", $columnSearchTerm, 2);
        if (count($range) == 1) {
            return;
        }

        $conditions = [
            "$column >=" => $range[0],
            "$column <=" => $range[1]
        ];

        $config->conditions['AND'] = Hash::merge((array) Hash::get($config->conditions, 'AND'), $conditions);
    }

    public function custom_filter_like($column, $searchTerm, $columnSearchTerm, &$config) {
        $conditions = [
            "0." . $column . " LIKE" => '%' . $columnSearchTerm . '%',
        ];

        $config['conditions']['AND'] = Hash::merge((array) Hash::get($config['conditions'], 'AND'), $conditions);
    }

    public function custom_filter_exact($column, $searchTerm, $columnSearchTerm, &$config) {
        if (empty($columnSearchTerm)) {
            return;
        }
        $conditions = [
            $column => $columnSearchTerm,
        ];

        $config->conditions['AND'] = Hash::merge((array) Hash::get($config->conditions, 'AND'), $conditions);
    }

    public function custom_search_startwith($column, $searchTerm, $columnSearchTerm, &$config) {
        if (empty($columnSearchTerm)) {
            return;
        }

        $conditions = [$column . " LIKE" => $columnSearchTerm . "%"];
        $config->conditions['AND'] = Hash::merge((array) Hash::get($config->conditions, 'AND'), $conditions);
    }

    /**
     * gets a csv from searchTerm split by comma and add to conditions
     * np. szukanie po wielu tych samych statusach ktore maja rozne id
     */
    public function custom_search_by_csv($column, $searchTerm, $columnSearchTerm, $config) {
        if (empty($columnSearchTerm)) {
            return;
        }
        $comma_separated_values = explode(",", $columnSearchTerm, 2);

        $conditions = [
            "$column" => $comma_separated_values,
        ];

        $config->conditions['AND'] = Hash::merge((array) Hash::get($config->conditions, 'AND'), $conditions);
    }

    /**
     * gets a csv from searchTerm split by comma and add to conditions
     * np. szukanie po wielu tych samych statusach ktore maja rozne id
     */
    public function custom_search_boolean($column, $searchTerm, $columnSearchTerm, $config) {
        if ($columnSearchTerm === "") {
            return;
        }

        if ($columnSearchTerm < 0) {
            $columnSearchTerm += 1;
        }

        $conditions = [
            "$column" => $columnSearchTerm,
        ];

        $config->conditions['AND'] = Hash::merge((array) Hash::get($config->conditions, 'AND'), $conditions);
    }

}
