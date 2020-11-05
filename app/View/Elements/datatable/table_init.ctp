
<?php
if (!isset($js)) {
    $js = [];
}
$langFilePath = "assets/global/plugins/datatables/i18n/" . Configure::read('Config.language') . ".lang";
$langFile = new File($langFilePath);
if ($langFile->exists()) {
    $langFileUrl = $this->Html->url("/" . $langFilePath, true);
} else {
    $langFileUrl = '';
}
$js = array_merge(["language" => [
//                            "sSearch" =>        "Buscar:",
        "url" => $langFileUrl
    ],
    "autoWidth" => false,
    'dom' => 'lBfrtip',
    'stateSave' => true,
    'responsive' => true,
    'columnDefs' => [
        ['responsivePriority' => 1, 'targets' => 0],
        ['responsivePriority' => 2, 'targets' => -1]
    ],
    "buttons" => [
//                            [
//                                "extend" => 'print',
//                                "exportOptions" => [
//                                    "columns" => ':visible'
//                                ],
//                                "name" => 'drukuj',
//                            ],
//                            [
//                                "extend" => 'excel',
//                                "exportOptions" => [
//                                    "columns" => ':visible'
//                                ]
//                            ],
//                            [
//                                "extend" => 'pdf',
//                                "exportOptions" => [
//                                    "columns" => ':visible'
//                                ]
//                            ],
//                            'colvis'
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
echo $this->DataTable->render($name, array('class' => 'table table-striped table-bordered table-hover dataTablex no-footer'), $js);
?>
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
                    case 'date':
                        $('<input type="text" placeholder="' + elementPlaceholder + '" class="' + elementClass + '" id="' + elementId + '" />').appendTo($(column.footer()).empty()).val(column.search())
                                .datepicker({
                                    format: '<?php echo Configure::read('JS.Date.Format'); ?>'
                                }).on('changeDate change', function () {
                            var val = ($(this).val());
                            column.search(val ? '' + val + '' : '', true, false).draw();
                        });
                        break;
                    case 'select':
                        var select = $('<select class="' + elementSelectClass + '" id="' + elementId + '"><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = ($(this).val());
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
                                    var val = ($(this).val());
                                    column.search(val ? '' + val + '' : '', true, false).draw();
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
            table.on('click', '.post.ajax', function (e) {
                e.preventDefault();
                var question = $(this).attr('data-question');
                if (question !== undefined) {
                    var questionValue = $(this).attr('data-question-value');
                    if (questionValue !== undefined) {
                        question = question.replace('%s', questionValue);
                    }
                    if (confirm(question)) {
                        $.post($(this).attr('href'), {})
                                .done(function (data) {
                                    if ($(this).hasClass('setText')) {
                                        $(this).text(data);
                                    } else {
                                        table.DataTable().ajax.reload(null, false);
                                    }
                                }).fail(function (xhr, status, error) {
                            // error handling
                            var errorText = '<?php echo __('%s could not be deleted'); ?>';
                            errorText = errorText.replace('%s', questionValue);
                            alert(errorText);
                        });

                    }
                } else {
                    $.post($(this).attr('href'), {})
                            .done(function (data) {
                                if ($(this).hasClass('setText')) {
                                    $(this).text(data);
                                } else {
                                    table.DataTable().ajax.reload(null, false);
                                }
                            });
                }

            });
        };
        $('.dataTablex').each(function () {
            var table = $(this);
            var settings = dataTableSettings[table.attr('data-config')];
            settings['initComplete'] = initComplete;
            settings['buttons'].push({
                text: '<?php echo __('Reset'); ?>',
                className: 'btn-xs',
                action: function (e, dt, node, config) {
                    table.fnFilter('');
                    table.find('input').val('');
                    table.find('select[class*=" select2"], select[class^="select2"]').each(function () {
                        $(this).select2("val", "");
                    });
                    table.DataTable().columns().search('');
                    if (settings.order !== undefined && settings.order[0] !== null) {
                        table.dataTable().fnSort(settings.order[0]);
                    } else {
                        table.dataTable().fnSort([0, "asc"]);
                    }
                    table.DataTable().ajax.reload();
                }
            });
            settings['buttons'].push({
                text: '<?php echo __('Reload'); ?>',
                className: 'btn-xs',
                action: function (e, dt, node, config) {
                    table.DataTable().ajax.reload(null, false);
                }
            });
//            settings['buttons'].push({
//                text: '<?php echo __('CSV'); ?>',
//                className: 'btn-xs',
//                action: function (e, dt, node, config) {
//                    var params = table.DataTable().ajax.params();
//                    params.config = settings['config'];
//                    var paramsString = jQuery.param( params );
//                    url = window.location + '/csv?' + paramsString;
//                    window.location = url;
//                    return;
//                }
//            });

            $.each(settings.aoColumns, function (index, value) {
                if (value.render) {
                    if (value.render.startsWith('(function(')) {
                        value.render = eval(value.render);
                    }
                }
            });
            $.each(settings.buttons, function (index, value) {
                if (typeof value.action == 'string') {
                    if (value.action.startsWith('(function(')) {
                        value.action = eval(value.action);
                    }
                }
            });

//                                if (typeof settings.ajax == 'undefined'){
//                                    settings.ajax = {};
//                                }
//                                console.log(settings);
<?php
if (isset($custom_conditions)) {
//                                    echo 'settings.ajax.data = '.$custom_conditions.';';
}
?>

            table.dataTable(settings);
        });
    });
</script>