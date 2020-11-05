<div class="datatable_<?php echo $name ?> index">
    <?php
    $hash = sha1(json_encode($config));
    $dataTableUniqId = 'datatable_' . $hash;
    ?>

    <?php // echo $this->element('page_title', array('title' => 'Employees', 'subtitle' => '')); ?>
    <?php // echo $this->element('page_bar'); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12">

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <!--<i class="icon-user font-dark"></i>-->
                        <span class="caption-subject bold uppercase"><?php echo __(isset($config['title']) ? $config['title'] : Inflector::pluralize(Inflector::humanize(Inflector::underscore(isset($config['model']) ? $config['model'] : $name)))); ?></span>
                    </div>
                    <!--div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                        </div>
                    </div-->
                    <div class="actions"><?php //$this->assign('page_buttons', " ");       ?>
                        <?php
                        if (isset($config['buttons'])) {
                            $akcje = '';
                            foreach ($config['buttons'] as $akcja => $ustawienia) {
                                if (is_string($ustawienia)) {
                                    $akcja = $ustawienia;
                                    $ustawienia = [];
                                }

                                if (!isset($ustawienia['id'])) {
                                    $ustawienia['id'] = $name . "." . 'id';
                                }

                                //$link = Hash::extract($result, $ustawienia['id']);
                                $link['action'] = $akcja;
                                if (isset($ustawienia['link'])) {
                                    if (is_array($ustawienia['link'])) {
                                        $link = array_merge($link, $ustawienia['link']);
                                    } else {
                                        $link = $ustawienia['link'];
                                    }
                                }

                                $bname = $akcja;
                                if (isset($ustawienia['name'])) {
                                    $bname = $ustawienia['name'];
                                }

                                if (array_key_exists('acl', $ustawienia) && $ustawienia['acl']) {
                                    if (is_bool($ustawienia['acl'])) {
                                        if (isset($ustawienia['link'])) {
                                            $ustawienia['acl'] = $ustawienia['link'];
                                        } else {
                                            $ustawienia['acl'] = ['action' => $akcja];
                                        }
                                    }

                                    if (!$this->AclLink->aclCheck($ustawienia['acl'])) {
                                        //hide button
                                        continue;
                                    }
                                }

                                $class = 'btn default';

                                if (isset($ustawienia['class'])) {
                                    $class .= " " . $ustawienia['class'];
                                }

                                $options = array('class' => $class);

                                if (isset($ustawienia['options'])) {
                                    $options = array_merge($options, $ustawienia['options']);
                                }

                                $helper = "Html";
                                if (isset($ustawienia['helper'])) {
                                    $helper = $ustawienia['helper'];
                                }

                                if (!isset($ustawienia['type'])) {
                                    switch ($akcja) {
                                        case 'delete':
                                            $ustawienia['type'] = 'postLink';
                                        case 'edit':
                                        default:
                                            $ustawienia['type'] = 'link';
                                    }
                                }

                                switch ($ustawienia['type']) {
                                    case 'postLink':
                                        $question = 'Are you sure you want to delete %s?';
                                        if (isset($ustawienia['question'])) {
                                            $question = $ustawienia['question'];
                                        }

                                        $question_value = null;
                                        if (isset($ustawienia['question_value'])) {
                                            $question_value = Hash::get($result, $ustawienia['question_value']);
                                        }

                                        echo $this->Form->postLink(
                                                __($bname), $link, $options, __($question, $question_value)
                                        );
                                        break;
                                    case 'link':
                                    default:
                                        echo $this->Html->link(
                                                __($bname), $link, $options
                                        );
                                }
                            }
                        } else {
//                        echo $this->AclLink->link('<i class="fa fa-plus"></i> ' . __('New %s', __(isset($config['model'])?$config['model']:$name)), array('action' => 'add'), array('class' => 'btn default', 'escape' => FALSE));
                            echo $this->AclLink->link('<i class="fa fa-plus"></i> ' . __('Add'), array('action' => 'add'), array('class' => 'btn default', 'escape' => FALSE));
                        }
                        ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="advancedConditionsWrapper">
                        <div class="advancedConditions" style='display: none;'>
                            <div class="advancedConditionBlockSchema advancedConditionBlock portlet box yellow" style='display: none;' data-conditions-block-name="AND">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-list"></i><span class='advancedConditionBlockName'>AND/OR?</span>
                                    </div>
                                    <div class="actions">
                                        <a href="javascript:;" class="btn red btn-sm" data-action='deleteBlock'><i class="fa fa-pencil"></i> Delete </a>
                                        <a href="javascript:;" data-action='addandrow' class="btn blue btn-sm"><i class="fa fa-plus"></i> Add AND</a>
                                        <a href="javascript:;" data-action='addorrow' class="btn blue btn-sm"><i class="fa fa-plus"></i> Add OR</a>
                                        <a href="javascript:;" data-action='addrow' class="btn blue btn-sm"><i class="fa fa-plus"></i> Add Field</a>
                                    </div>
                                </div>
                                <div class="portlet-body advancedConditionBody">

                                </div>
                            </div>
                            <div class="advancedConditionSchema advancedConditionRow" style='display: none; padding-bottom: 15px' data-conditions-block-name='INPUT'>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <select class='form-control'>
                                            <option value=''></option>
                                            <?php
                                            if (isset($modelSchema)) {
                                                DebugTimer::start('custom_conditions_modelSchema');
                                                foreach ($modelSchema['fieldinfo'] as $field => $data) {
                                                    $extraArgs = "";
                                                    if (isset($data['ignoreField']) && $data['ignoreField']) {
                                                        continue;
                                                    }
                                                    if (!isset($data['type'])) {
                                                        $data['type'] = 'string';
                                                    }
                                                    if (isset($data['get_options'])) {
//                                                        DebugTimer::start('custom_conditions_get_options_for_' . $field);
                                                        if (is_array($data['get_options'])) {
                                                            $data['get_options'] += ['admin' => null, 'plugin' => null];
                                                        }
                                                        $remote_options = $this->requestAction($data['get_options']);
                                                        if ($remote_options) {
                                                            $data['options'] = $remote_options;
                                                        } else {
                                                            $data['options'] = [];
                                                        }
//                                                        DebugTimer::stop('custom_conditions_get_options_for_' . $field);
                                                    }
                                                    if (isset($data['disable-modifier'])) {
                                                        $extraArgs .= " data-disable-modifier=true";
                                                    }
                                                    if (isset($data['options'])) {
                                                        $extraArgs .= " data-options='" . str_replace(['\''], ['\\\''], json_encode($data['options'], JSON_HEX_APOS | JSON_HEX_QUOT)) . "'";
                                                    }
                                                    echo "<option data-type='" . $data['type'] . "' value='" . $field . "'" . $extraArgs . ">" . (isset($data['translated']) ? $data['translated'] : $field) . "</option>";
                                                }
                                                DebugTimer::stop('custom_conditions_modelSchema');
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class='col-md-2'>
                                        <select class='form-control'>

                                            <option value="=">Równa się (=)</option>
                                            <option value=">">Większe niż (&gt;)</option>
                                            <option value=">=">Większe równe niż (&gt;=)</option>
                                            <option value="<">Mniejsze niż (&lt;)</option>
                                            <option value="<=">Mniejsze równe niż (&lt;=)</option>
                                            <option value="!=">Nie równa się (!=)</option>
                                            <option value="LIKE %...%">Zawiera (LIKE %...%)</option>
                                            <option value="NOT LIKE %...%">Nie zawiera (NOT LIKE %...%)</option>
                                            <option value="LIKE ...%">Zaczyna się na (LIKE ...%)</option>
                                            <option value="LIKE %...">Konczy się na (LIKE %...)</option>
                                            <option value="LIKE">LIKE</option>
                                            <option value="NOT LIKE">NOT LIKE</option>
                                            <!--<option value="IN (...)">IN (...)</option>-->
                                            <!--<option value="NOT IN (...)">NOT IN (...)</option>-->
                                            <!--<option value="BETWEEN">BETWEEN</option>-->
                                            <!--<option value="NOT BETWEEN">NOT BETWEEN</option>-->
                                            <option value="IS NULL">IS NULL</option>
                                            <option value="IS NOT NULL">IS NOT NULL</option>
                                        </select>

                                    </div>
                                    <div class='col-md-7'>
                                        <div class="input-group">
                                            <div class='advancedConditionInputBox'>
                                                <input type='text' data-path='' class='form-control '/>
                                                <!--<select class='form-control'></select>-->
                                            </div>
                                            <span class="input-group-btn">
                                                <a href="javascript:;" class="advancedConditionDelete btn red" data-action='deleteRow'><i class="fa fa-pencil"></i> <?php echo __('Delete') ?> </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="advancedConditionStart advancedConditionBlock portlet box yellow" >
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-list"></i><?= __("Conditions"); ?> ( ... AND ... )
                                    </div>
                                    <div class="actions">
                                        <a href="javascript:;" class="btn green btn-sm" data-action='filter'><i class="fa fa-play"></i> <?= __("Filtruj tabele"); ?> </a>
                                        <a href="javascript:;" class="btn green btn-sm" data-action='close'><i class="fa fa-cross"></i> <?= __("Close") ?> </a>
                                        <a href="javascript:;" data-action='reset' class="btn blue btn-sm"><i class="fa fa-bars"></i> <?= __("Reset") ?> </a>
                                        <a href="javascript:;" data-action='clear' class="btn blue btn-sm"><i class="fa fa-square-o"></i> <?= __("Clear") ?> </a>
                                        <a href="javascript:;" data-action='addandrow' class="btn blue btn-sm"><i class="fa fa-plus"></i> <?= __("Add") ?> AND </a>
                                        <a href="javascript:;" data-action='addorrow' class="btn blue btn-sm"><i class="fa fa-plus"></i> <?= __("Add") ?> OR </a>
                                        <a href="javascript:;" data-action='addrow' class="btn blue btn-sm"><i class="fa fa-plus"></i> <?= __("Add") ?> <?= __("field") ?> </a>
                                    </div>
                                </div>
                                <div class="portlet-body advancedConditionBody">

                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                /* based on http://stackoverflow.com/a/13719799 */
                                var array_push_path = function (obj, prop, value) {
                                    if (typeof prop === "string")
                                        prop = prop.split("/");

                                    if (prop.length > 1) {
                                        var e = prop.shift();
                                        array_push_path(obj[e] =
                                                Object.prototype.toString.call(obj[e]) === "[object Object]"
                                                ? obj[e]
                                                : {},
                                                prop,
                                                value);
                                    } else
                                        obj[prop[0]] = value;
                                };

<?php
if (!isset($userConditions)) {
    $userConditions = [];
}
?>
                                var default_conditions = <?= json_encode($userConditions); ?>;
                                var conditions = default_conditions;
                                var table = $("#<?= $dataTableUniqId ?>");
                                var returnIds = false;
//                                table.on('preXhr.dt', function (e, settings, data) {
//                                    data.aaa = {'TESTUJEMY': 'TEST'};
//                                });

                                table.on('stateSaveParams.dt', function (e, settings, data) {
                                    //execuded when:
                                    //$("#DataTables_Table_0").DataTable().state.save()                                    
                                    data.advancedConditions = {conditions: conditions};
                                });

                                table.on('preXhr.dt', function (e, settings, data) {
                                    data.conditions = conditions;
                                    data.returnIds = returnIds;
                                });

                                table.on('stateLoaded.dt', function (e, settings, data) {
                                    if (typeof data.advancedConditions !== 'undefined') {
                                        conditions = data.advancedConditions.conditions;
                                    }
                                });


                                var searchButton = null;

                                table.on('advancedConditionsButton.dt', function (e, dt, b, a, trigger) {
//                                    console.log('event button');
//                                    console.log(dt);
//                                    console.log(b);
//                                    console.log(a);
//                                    console.log('event button');
                                    var button = b;
                                    var text = button.html();
                                    if (typeof trigger === 'undefined') {
                                        trigger = function (containConditions) {
                                            if (containConditions) {
                                                button.html(text + "*");
                                            } else {
                                                button.html(text + "");
                                            }
                                        }
                                    }
                                    searchButton = trigger;
                                });

                                var init = function () {
                                    var dtable = table.DataTable();

                                    var getPath = function (el) {
                                        var x = $(el).parents().addBack().filter('[data-conditions-block-name]');
//                                        console.log(x);
                                        var path = [];
                                        x.each(function (x, el) {
                                            var tmp = $(el).attr('data-conditions-block-name');
//                                            console.log(el);
                                            if (tmp == 'INPUT') {
                                                return;
//                                                tmp = $(el).find('select:first').val();
                                            }
                                            path.push(tmp);
                                        });
//                                        console.log(path);
                                        return path;
                                    }

                                    var addRow = function (element) {
//                                        console.log(element);
                                        var n = $($(element).parents('.advancedConditionBlock')[0]).children('.advancedConditionBody');
                                        var nn = $(".advancedConditionSchema").clone().removeClass('advancedConditionSchema');
                                        nn.appendTo(n);
                                        nn.slideDown();
                                        nn.find('select').select2({
//                                            allowClear: true,
                                            placeholder: '<?= __("Wybierz pole") ?>',
                                        });
                                        nn.find('select:eq(0)').change(function (x, element2) {
                                            updateInputBySelect(this);
                                        });

                                        nn.find('select:eq(1)').change(function (x, element2) {
                                            updateInputPathBySelect(this);
                                        });
                                        return nn;
//                                        console.log(n);
                                    }

                                    var andUniqNumber = 0;

                                    var addBlock = function (element, type) {
//                                        console.log(element);
                                        var n = $($(element).parents('.advancedConditionBlock')[0]).children('.advancedConditionBody');
                                        var nn = $(".advancedConditionBlockSchema").clone().removeClass('advancedConditionBlockSchema');
                                        nn.appendTo(n);
                                        nn.slideDown();
                                        nn.attr('data-conditions-block-name', (andUniqNumber++) + '/' + type);
                                        nn.find(".advancedConditionBlockName").html('( ... ' + type + ' ... )');
                                        return nn;
//                                        console.log(n);
//                                        console.log(nn);
                                    }

                                    var delRow = function (element) {
//                                        console.log(element);
                                        var n = $(element).parents('.advancedConditionRow')[0];
//                                        console.log(n);
                                        $(n).slideUp(function () {
                                            $(this).remove()
                                        });
                                    }

                                    var delBlock = function (element) {
//                                        console.log(element);
                                        var n = $(element).parents('.advancedConditionBlock')[0];
//                                        console.log(n);
                                        $(n).slideUp(function () {
                                            $(this).remove()
                                        });
                                    }

                                    var updateInputPathBySelect = function (input) {
                                        var path = getPath(input);
                                        var n = $(input).parents('.advancedConditionRow')[0];
                                        if ($(n).find('select:eq(0)').val() === '') {
                                            $(n).find('input').attr('data-path', null);
                                            return;
                                        }

                                        var ipath = ''
                                        if (path.length > 0) {
                                            ipath = path.join("/") + '/';
                                        }
                                        ipath = ipath + (andUniqNumber++) + '/' + $($(n).find('select')[0]).val() + ' ' + $($(n).find('select')[1]).val();

                                        $(n).find('.advancedConditionInputBox > [data-path]').attr('data-path', ipath);
                                    }

                                    //uwaga gcode!
                                    var updateInputBySelect = function (input) {
//                                        console.log('updateInputBySelect');
                                        var n = $(input).parents('.advancedConditionRow')[0];
//                                        console.log(n);
//                                        console.log($(n).find('select')[0]);

                                        var typ = $($(n).find('select')[0]).find("option:selected").attr('data-type');
                                        if (typeof typ === 'undefined') {
                                            typ = 'string';
                                        }
                                        switch (typ) {
                                            case 'timestamp':
                                                typ = 'datetime';
                                                break;
                                            case 'boolean':
                                            case 'bool':
                                                typ = 'bool';
                                                break;
                                            case 'string':
                                            case 'text':
                                                typ = 'string';
                                                break;
                                            case 'integer':
                                                typ = 'number';
                                                break;
                                            case 'select':
                                                break;
                                            default:
                                                console.log('Unknown field type: ' + typ);
//                                                typ='string';
                                                break;
                                        }
                                        var type_now = $(n).find('.advancedConditionInputBox').attr("data-type");
                                        if (typeof type_now === 'undefined') {
                                            type_now = 'string';
                                        }

                                        if (type_now != typ || typ == 'select') {
                                            $(n).find('.advancedConditionInputBox > *').remove();
                                            $(n).find('.advancedConditionInputBox').attr("data-type", typ);
                                            switch (typ) {
                                                case 'string':
                                                    $(n).find('.advancedConditionInputBox').append("<input type='text' data-path='' class='form-control '/>");
                                                    break;
                                                case 'number':
                                                    $(n).find('.advancedConditionInputBox').append("<input type='number' data-path='' class='form-control '/>");
                                                    break;
                                                case 'date':
                                                    var newfield = $("<input type='text' data-path='' class='form-control '/>");
                                                    $(n).find('.advancedConditionInputBox').append(newfield);
                                                    newfield.datepicker({
//                                                        format: 'yyyy-mm-dd'
                                                        format: '<?= Configure::read("Database.Format.datepicker.date"); ?>',
                                                        onSelect: function () {
                                                            $(this).change();
                                                        }
                                                    });
                                                    break;
                                                case 'datetime':
                                                    var newfield = $("<input type='text' data-path='' class='form-control ' placeholder='x'/>");
                                                    $(n).find('.advancedConditionInputBox').append(newfield);
                                                    newfield.datetimepicker();
                                                    break;
                                                case 'bool':
                                                    var select = "<select data-path='' class='form-control '><option value=1><?= __("Yes") ?></option><option value=0><?= __("No") ?></option></select>";
                                                    $(n).find('.advancedConditionInputBox').append(select).find('select').select2();
                                                    break;
                                                case 'select':
                                                    var select = $("<select data-path='' class='form-control' data-tags=true appendMissingOptions='1' ></select>");
                                                    var opcje_selecta = jQuery.parseJSON($($(n).find('select')[0]).find("option:selected").attr('data-options'));
                                                    $.each(opcje_selecta, function (key, value) {
                                                        select.append($('<option>').text(value).attr('value', key));
                                                    });
                                                    $(n).find('.advancedConditionInputBox').append(select).find('select').select2();
                                                    break;
                                                default:
                                                    $(n).find('.advancedConditionInputBox').append("<input type='text' data-path='' class='form-control '/>");
                                                    console.log('Unknown input type: ' + typ);
                                                    break;
                                            }

                                            if ($(n).find('select:eq(0) > option:selected').attr('data-disable-modifier')) {
                                                var crazy_select2 = $(n).find('select:eq(1)');
//                                                crazy_select2.select2('val', '='); //select 3.x
                                                crazy_select2.val('=').trigger('change'); //select 4.0.2
//                                                crazy_select2.select2("enable", false);
                                            } else {
                                                $(n).find('select:eq(1)').select2("enable", true);
                                            }
                                        }

                                        updateInputPathBySelect(input);

//                                        console.log(path);

                                    }

                                    var filter = function () {
                                        conditions = {};
                                        $('.advancedConditionStart').find('[data-path]').each(function () {
                                            var path = $(this).attr('data-path');
                                            if (path.length === 0) {
                                                return;
                                            }
                                            var val = $(this).val();
                                            array_push_path(conditions, path, val);
                                        });
//                                        console.log(conditions);
                                        if (typeof searchButton === 'function') {
                                            searchButton($.isEmptyObject(conditions) ? false : true);
                                        }
                                        dtable.ajax.reload();
                                    };

                                    var closeBox = function () {
                                        $('.advancedConditions').slideUp();
                                    };

                                    $(".advancedConditions").delegate('a', 'click', function () {
                                        var action = $(this).attr('data-action');
//                                        console.log(action);
//                                        getPath(this);

                                        switch (action) {
                                            case 'addrow':
                                            case 'addRow':
                                                addRow(this);
                                                break;
                                            case 'delRow':
                                            case 'deleteRow':
                                                delRow(this);
                                                break;
                                            case 'filter':
                                                filter();
                                                break;
                                            case 'addandrow':
                                            case 'addAndRow':
                                                addBlock(this, 'AND');
                                                break;
                                            case 'addOrRow':
                                            case 'addorrow':
                                                addBlock(this, 'OR');
                                                break;
                                            case 'delBlock':
                                            case 'delblock':
                                            case 'deleteBlock':
                                            case 'deleteblock':
                                                delBlock(this);
                                                break;
                                            case 'reset':
                                                $(".advancedConditionStart .advancedConditionBody").html('');
                                                conditions = default_conditions;
                                                renderHtml(conditions, $(".advancedConditionStart .advancedConditionBody"));
                                                filter();
                                                break;
                                            case 'clear':
                                                $(".advancedConditionStart .advancedConditionBody").html('');
                                                filter();
                                                break;
                                            case 'close':
                                                closeBox();
                                                break;
                                        }
                                    });

//                                    console.log(conditions);
//                                    window.conditions = conditions;

                                    var renderHtml = function (array, div) {
//                                        console.log(div);
//                                        console.log(array);
                                        $.each(array, function (key, val) {
                                            if ($.isNumeric(key)) {
                                                renderHtml(val, div);
                                                return;
                                            }

                                            if ($.isPlainObject(val)) {
                                                //subgroups
                                                var block = null;
                                                switch (key) {
                                                    case 'OR':
                                                    case 'or':
                                                        var block = addBlock(div, 'OR');
                                                        break;
                                                    case 'AND':
                                                    case 'and':
                                                        var block = addBlock(div, 'AND');
                                                        break;
                                                }
                                                if (block !== null) {
                                                    renderHtml(val, $(block).find('.advancedConditionBody')[0]);
                                                }
//                                                console.log(key);
//                                                console.log(val);
                                                return;
                                            }
                                            var row = addRow(div);

                                            var i = key.indexOf(' ');
                                            if (i === -1) {
                                                var partOne = key.trim();
                                                var partTwo = '=';
                                            } else {
                                                var partOne = key.slice(0, i).trim();
                                                var partTwo = key.slice(i + 1, key.length).trim();
                                            }

//                                            console.log(partOne);
//                                            console.log(partTwo);
//                                            $(row.find('select')[0]).select2('val', [partOne], true); //select 3.X
//                                            $(row.find('select')[1]).select2('val', [partTwo], true);
                                            $(row.find('select')[0]).val(partOne).trigger('change'); //select 4.X
                                            $(row.find('select')[1]).val(partTwo).trigger('change');
                                            var input = row.find('input[data-path]');
                                            if (input.length) {
                                                $(input).val(val);
                                            }
                                            var select = row.find('select[data-path]');
                                            if (select.length) {
//                                                $(select).select2('val', [val], true);
                                                $(select).val(val).trigger('change');
                                            }

                                        });
                                    };
//                                    console.log('render start');
//                                    $('.advancedConditions').slideDown();
                                    $('.advancedConditions').show(); //select2 don't have width if hidden
                                    renderHtml(conditions, $(".advancedConditionStart .advancedConditionBody"));
                                    $('.advancedConditions').hide(); //select2 don't have width if hidden
                                    if (typeof searchButton === 'function') {
                                        searchButton($.isEmptyObject(conditions) ? false : true);
                                    }
                                };
//                                console.log($(".datatable"));
                                $("#<?= $dataTableUniqId ?>").on('init.dt', init);
//                                window.setTimeout(init, 0);
                            });
                        </script>
                    </div>
                    <?php
                    $langFile = new File("assets/global/plugins/datatables/i18n/" . CakeSession::read('Config.language') . ".lang");
                    $langUrl = null;
                    if ($langFile->exists()) {
                        $langUrl = $this->Html->url("/assets/global/plugins/datatables/i18n/" . CakeSession::read('Config.language') . ".lang", true);
                    }

                    if (!isset($js)) {
                        $js = [];
                    }
                    $js = array_merge(["language" => [
//                            "sSearch" =>        "Buscar:",
                            "url" => $this->Html->url("/assets/global/plugins/datatables/i18n/polish.lang", true)
                        ],
                        "autoWidth" => false,
//                        'dom' => 'lBfrtip', //with global search
                        'dom' => 'lBrtip', //without global search
                        "buttons" => [
                            [
                                "action" => '(function(){$(\'.advancedConditions\').slideDown();})',
                                "text" => 'Zaawansowane szukanie',
//                                'init' => '(function(){console.log("TEST INIT");table.trigger("advancedConditionsButton.dt",[this, table]);})',
                                'init' => "(function(dt, button, button2){table.trigger('advancedConditionsButton.dt',[dt, button, button2]);})"
                            ],
                            [
                                "extend" => 'print',
                                "exportOptions" => [
                                    "columns" => ':visible'
                                ],
                                "name" => 'drukuj',
                            ],
                            [
                                "extend" => 'excel',
                                "exportOptions" => [
                                    "columns" => ':visible'
                                ]
                            ],
                            [
                                "extend" => 'pdf',
                                "orientation" => 'landscape',
                                "exportOptions" => [
                                    "columns" => ':visible',
                                ]
                            ],
                            'colvis'
                        ]], $js);
//                    $js['order'] = array(array(1, "desc"));

                    $options = array();
                    //var_dump($this->DataTable->_dtColumns);exit;
                    $filters = false;
                    foreach ($this->DataTable->_dtColumns as $config) {
                        foreach ($config as $index => $column) {
                            if (isset($column['elementOptions']) && isset(${$column['elementOptions']})) {
                                $options[(string) $index] = ${$column['elementOptions']};
                            }
                            if (isset($column['type'])) {
                                $filters = true;
                            }
                        }
                    }
                    $this->DataTable->settings['scriptBlock'] = false;
                    if ($filters) {
                        $this->DataTable->settings['table']['tfoot'] = '<tr>' . str_repeat('<th></th>', count($this->DataTable->_dtColumns[$name])) . '</tr>';
                    }
                    ?>

                    <div class="table-responsive">
                        <?php
                        echo $this->DataTable->render($name, array('id' => $dataTableUniqId, 'class' => 'table table-striped table-bordered table-hover dataTable no-footer'), $js);
                        ?>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            var initComplete = function () {
                                var table = this;
                                var tableSettings = table.api().settings();
                                var options = <?php echo json_encode($options); ?>;
                                table.api().columns().every(function (key) {
//                                    var optionsArray = $.map(options[key], function (el) {
//                                        return el;
//                                    });
                                    var column = this;
                                    var columnSettings = tableSettings[0].aoColumns[key];
                                    var elementClass = (columnSettings['elementClass'] === undefined) ? 'datatablesDefaultSearchClass' : columnSettings['elementClass'];
                                    var elementSelectClass = (columnSettings['elementClass'] === undefined) ? 'datatablesDefaultSearchClass dtselect2' : columnSettings['elementClass'];
                                    var elementId = (columnSettings['elementId'] === undefined) ? '' : columnSettings['elementId'];
                                    var elementPlaceholder = (columnSettings['elementPlaceholder'] === undefined) ? '' : columnSettings['elementPlaceholder'];

                                    switch (columnSettings['type']) {
                                        case 'daterange':
                                            var input = $('<input type="text" placeholder="' + elementPlaceholder + '" class="' + elementClass + '" id="' + elementId + '" />');

                                            input.appendTo($(column.footer()).empty()).val(column.search());
                                            input.daterangepicker(
                                                    {
                                                        //startDate: moment().subtract(29, 'days'),
                                                        endDate: moment(),
                                                        //minDate: '01/01/2012',
                                                        //maxDate: '12/31/2015',
                                                        //dateLimit: { days: 60 },
                                                        showDropdowns: false,
                                                        showWeekNumbers: true,
                                                        timePicker: false,
                                                        timePickerIncrement: 1,
                                                        timePicker12Hour: false,
                                                        ranges: {
                                                            '<?php echo __('Today'); ?>': [moment(), moment()],
                                                            '<?php echo __('Yesterday'); ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                                    '<?php echo __('Last 7 Days'); ?>': [moment().subtract(6, 'days'), moment()],
                                                                    '<?php echo __('Last 30 Days'); ?>': [moment().subtract(29, 'days'), moment()],
                                                                    '<?php echo __('This Month'); ?>': [moment().startOf('month'), moment().endOf('month')],
                                                                    '<?php echo __('Last Month'); ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                                        },
//                                                        opens: 'left',
                                                        buttonClasses: ['btn btn-default'],
                                                        applyClass: 'btn-xs btn-primary',
                                                        cancelClass: 'btn-xs',
//                                                        format: 'YYYY-MM-DD',
                                                        format: '<?= Configure::read("Database.Format.daterangepicker.date"); ?>',
                                                        separator: ' - ',
                                                        locale: {
                                                            applyLabel: '<?php echo __('OK'); ?>',
                                                            cancelLabel: '<?php echo __('Cancel'); ?>',
                                                            fromLabel: '<?php echo __('From'); ?>',
                                                            toLabel: '<?php echo __('To'); ?>',
                                                            customRangeLabel: '<?php echo __('Custom'); ?>',
                                                            daysOfWeek: ['<?php echo __('Su'); ?>', '<?php echo __('Mo'); ?>', '<?php echo __('Tu'); ?>', '<?php echo __('We'); ?>', '<?php echo __('Th'); ?>', '<?php echo __('Fr'); ?>', '<?php echo __('Sa'); ?>'],
                                                            monthNames: ['<?php echo __('January'); ?>', '<?php echo __('February'); ?>', '<?php echo __('March'); ?>', '<?php echo __('April'); ?>', '<?php echo __('May'); ?>', '<?php echo __('June'); ?>', '<?php echo __('July'); ?>', '<?php echo __('August'); ?>', '<?php echo __('September'); ?>', '<?php echo __('October'); ?>', '<?php echo __('November'); ?>', '<?php echo __('December'); ?>'],
                                                            firstDay: 1
                                                        }
                                                    }
                                            );
                                            input.on('apply.daterangepicker', function (ev, picker) {
                                                input.trigger('change');
                                            });

                                            input.on('cancel.daterangepicker', function (ev, picker) {
                                                input.val('').trigger('change');
                                            });
                                            input.on('change', function () {
                                                var val = ($(this).val());
                                                column.search(val ? '' + val + '' : '', true, false).draw();
                                            });
                                            break;
                                        case 'date':
                                            var input = $('<input type="text" placeholder="' + elementPlaceholder + '" class="' + elementClass + '" id="' + elementId + '" />');
                                            input.appendTo($(column.footer()).empty()).val(column.search())
                                                    .on('change', function () {
                                                        var val = ($(this).val());
                                                        column.search(val ? '' + val + '' : '', true, false).draw();
                                                    });
                                            input.datepicker();
                                            break;
                                        case 'select':
                                            var select = $('<select class="' + elementSelectClass + '" id="' + elementId + '"><option value=""></option></select>')
                                                    .appendTo($(column.footer()).empty())
                                                    .on('change', function () {
                                                        var val = $(this).val();
                                                        column.search(val ? '' + val + '' : '', true, false).draw();
                                                    });
//                                                    console.log(optionsArray);
                                            var selectedVal = column.search();
                                            $.each(options[key], function (d, j) {
                                                if (d == selectedVal) {
                                                    select.append('<option value="' + d + '" selected="selected">' + j + '</option>');
                                                } else
                                                {
                                                    select.append('<option value="' + d + '">' + j + '</option>');
                                                }
                                            });
                                            if (columnSettings['select2']) {
                                                select.select2(columnSettings['select2']);
                                            }
                                            break;
                                        case 'text':
                                            $('<input type="text" placeholder="' + elementPlaceholder + '" class="' + elementClass + '" id="' + elementId + '" />').appendTo($(column.footer()).empty()).val(column.search())
                                                    .on('change', function () {
                                                        var val = $(this).val();
                                                        column.search(val ? '' + val + '' : '', true, false).draw();
                                                    });
                                            break;
                                        case 'selectAllCheckbox':
                                            var selectAllElement = $(column.footer()).empty();
                                            var selected = false;
                                            $(column.footer()).empty().addClass('select-all-checkbox').on('click', function () {
                                                if (selected) {
                                                    table.api().rows().deselect();
                                                    $(selectAllElement).removeClass('select-all-checkbox-selected');
                                                    selected = false;
                                                } else {
                                                    table.api().rows().select();
                                                    $(selectAllElement).addClass('select-all-checkbox-selected');
                                                    selected = true;
                                                }
                                            });
                                            break;
                                    }

//                                    if(typeof columnSettings['customScript'] !== 'undefined'){
//                                        if (columnSettings['customScript'].startsWith('(function(')) {
//                                            eval(value.render.'()');
//                                        }
//                                    }
                                });
                                //$('.dtselect2').select2();

                                $('tbody', table).on('click', 'tr > td:not(:first-child):not(:last-child)', function (e) {
//                                    console.log(e);console.log(this); console.log($('.defaultAction',$(this).parent('tr')).attr('href'));
                                    if (($('.defaultAction', $(this).parent('tr')).attr('href'))) {
                                        location.href = $('.defaultAction', $(this).parent('tr')).attr('href');
                                    }
                                });

                                $('tbody', table).on('click', 'tr a', function (e) {
                                    e.stopPropagation();
                                });
                            };
                            $('#<?= $dataTableUniqId ?>').each(function () {
                                var table = $(this);
                                var settings = dataTableSettings[table.attr('data-config')];
                                settings['initComplete'] = initComplete;
                                settings['buttons'].push({
                                    text: '<?= __("Reset") ?>',
                                    action: function (e, dt, node, config) {
                                        dt.state.clear();
                                        location.reload();
                                    }
                                });
                                settings['buttons'].push({
                                    text: '<?= __("Clear") ?>',
                                    action: function (e, dt, node, config) {
                                        dt.search('').columns().search('').draw();
                                        dt.columns().footer().each(function (el) {
                                            $("input", el).val('');
                                            $("select", el).val([]).trigger('change');
                                        });
                                    }
                                });
                                $.each(settings.buttons, function (index2, value2) {
                                    if ($.isPlainObject(value2)) {
                                        $.each(value2, function (index, value) {
                                            if (typeof value === 'string' && value.startsWith('(function(')) {
                                                value2[index] = eval(value);
                                            }
//                                        }
                                        });
                                    }
                                });


                                $.each(settings.aoColumns, function (index, value) {
                                    if (value.render) {
//                                        console.log(value.render);
                                        if (value.render.startsWith('(function(')) {
                                            value.render = eval(value.render);
                                        }
                                    }
                                });

                                $.each(settings, function (index, value) {
//                                    console.log(value);
                                    if (typeof value == 'string') {
                                        if (value.startsWith('(function(')) {
                                            settings[index] = eval(value);
                                        }
                                    }
//                                    console.log(value);
                                });

<?php
if (isset($custom_conditions)) {
//                                    echo 'settings.ajax.data = '.$custom_conditions.';';
}
?>

<?php
if (isset($before_script)) {
    echo $before_script;
}
?>
                                table.dataTable(settings);
<?php
if (isset($after_script)) {
    echo $after_script;
}
?>




                                $(".datatable_<?php echo $name ?> .dtAppendSelectAll").each(function () {
                                    $(this).removeAttr('onclick');
                                    $(this).on('click', function (e) {
                                        e.preventDefault();

                                        var element = $(this);
                                        var dtable = table.DataTable();
                                        var mydata = dtable.on('preXhr.dt', function (e, settings, data) {
                                            data.returnIds = true;
                                        });

                                        dtable.ajax.reload(function (json) {
                                            
                                            var question="Czy napewno chcesz dodać %s pozycji?";
                                            
                                            if(typeof element.attr('data-question')!=='undefined'){
                                                question=element.attr('data-question');
                                            }
                                                question=question.replace('%s',json.aaResultsIdsCount);
                                            if (confirm(question)) {

                                                var request = jQuery.ajax({
                                                    type: "POST",
                                                    url: element.prev('form').attr('action'),
                                                    data: {ids: json.aaResultsIdsPlain}
                                                });

                                                request.done(function (response, status, xhr) {
                                                    if (status === "success") {
                                                        var mydata = jQuery.parseJSON(response);
                                                        if(typeof mydata.redirect!=="undefined"){
                                                          window.location = mydata.redirect;  
                                                        }
                                                        
                                                    }
                                                });

                                            }
                                        });


                                        //var mydata=dtable.ajax.json();
                                        // console.log(mydata.ajax.json());
                                        return false;
                                    });
                                });
                                $(".datatable_<?php echo $name ?> .dtAppendSelectedIds").each(function () {
                                    var dtable = table.DataTable();
                                    var link = this;
                                    var baseUrl = $(link).attr('href');
                                    var zaznaczone = [];
                                    $(link).on('click', function (e) {
                                        if (zaznaczone.length === 0) {
                                            window.alert('<?= __("Nie zaznaczono żadnej pozycji.") ?>');
                                            e.preventDefault();
                                        }
                                    });
                                    var table_changed = function (e, dt, type, indexes) {
                                        var rowData = dtable.rows({selected: true}).data().toArray();
                                        zaznaczone = [];

                                        $(rowData).each(function (nr, data) {
                                            zaznaczone.push(data[0]);
                                        });
                                        $(link).attr('href', baseUrl + '/' + zaznaczone.join(","));

                                    };
                                    dtable.on('select', table_changed);
                                    dtable.on('deselect', table_changed);
                                    dtable.on('draw', table_changed);
                                    table_changed();
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>