<div class="employees form">
    <?php echo $this->Form->create('Ddatatable', array('role' => 'form', 'inputDefaults' => array('empty' => true))); ?>
    <?php echo $this->Form->input('id'); ?>
    <div class="fixedactions"><?php $this->assign('page_buttons', " ");?>
        <?php echo $this->Html->link('<i class="fa fa-undo"></i> ' . __('Cancel'), array('action' => 'index'), array('class' => 'btn default', 'escape' => FALSE)); ?>
        <?php
//        echo $this->Form->submit('&nbsp;&nbsp;&nbsp;' . __("Save and Close"), array('escape' => false, 'class' => 'btn blue', 'div' => FALSE,
////fail                'before' => '<span style="position: relative;"><i class="fa fa-floppy-o" style="color: white; position: absolute; left: 5px; top: 2px; z-index: 10;"></i>', 'after' => '</span>'
//        ));
//        echo " ";
        echo $this->Form->submit('&nbsp;&nbsp;&nbsp;' . __("Save"), array('name' => 'saveandcontinue', 'escape' => false, 'class' => 'btn blue', 'div' => FALSE,
//fail                'before' => '<span style="position: relative;"><i class="fa fa-floppy-o" style="color: white; position: absolute; left: 5px; top: 2px; z-index: 10;"></i>', 'after' => '</span>'
        ));
        ?>
    </div>
    <?php echo $this->element('page_title', array('title' => 'Dynamic View Fields', 'subtitle' => '')); ?>
    <?php echo $this->element('page_bar'); ?>

    <div class='row'>
        <div class='col-md-12'>
            <div class='portlet light'>
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"><?= __("View Settings") ?></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <?php echo $this->Form->input('template', array('bsize' => 12, 'required' => 'required', 'type'=>'select', 'placeholder' => __('Template'), 'label' => __('Template'))); ?>
                            <?php echo $this->Form->input('code', array('bsize' => 12, 'required' => 'required', 'placeholder' => __('Name'), 'label' => __('Name'))); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".delete-row").click(function () {
                var x = $(this).parents(".delete-group")[0];
                $(".deleteField", x).val(1);
                //TODO: if id empty = delete block
                $(x).slideUp();
            });
            $(".add-group").click(function () {
                var hidden = jQuery(".hidden-group:first", jQuery(this).parents(".form-body")[0]);
                if (hidden.length) {
                    hidden.slideDown();
                    hidden.removeClass("hidden-group");
                } else {
                    window.alert("<?= __("Save before adding more") ?>");
                }
            });


            $(".jsoneditor").each(function () {
                var textarea = this;
                var container = jQuery("<div class='jsonEditorContainer' style='height: 400px; width: 100%;'></div>")[0];
                jQuery(textarea).after(container).hide();

                var options = {
                    mode: 'tree',
                    modes: ['code', 'form', 'text', 'tree', 'view'], // allowed modes
                    onError: function (err) {
                        alert(err.toString());
                    },
                    onModeChange: function (newMode, oldMode) {
                        console.log('Mode switched from', oldMode, 'to', newMode);
                    },
                    onChange: function () {
                        console.log('onChange');
                        jQuery(textarea).html(editor.getText());
                        console.log(editor.getText());
//                            textarea.html(this.get());
                    },
                    search: false
                };
<?php //https://github.com/josdejong/jsoneditor               ?>
                var editor = new JSONEditor(container, options);
                console.log(editor.onChange);

//                // set json
//                var json = {
//                    "Array": [1, 2, 3],
//                    "Boolean": true,
//                    "Null": null,
//                    "Number": 123,
//                    "Object": {"a": "b", "c": "d"},
//                    "String": "Hello World"
//                };
                var json = jQuery(textarea).html();
                console.log(json);
                if (json !== "") {
                    editor.setText(json);
                }
//                var schema = {
//                    "$schema": "http://json-schema.org/draft-04/schema#",
//                    "title": "Product",
//                    "description": "A product from Acme's catalog",
//                    "type": "object",
//                    "properties": {
//                        "id": {
//                            "description": "The unique identifier for a product",
//                            "type": "integer"
//                        },
//                        "name": {
//                            "description": "Name of the product",
//                            "type": "string"
//                        },
//                        "price": {
//                            "type": "number",
//                            "minimum": 0,
//                            "exclusiveMinimum": true
//                        },
//                        "tags": {
//                            "type": "array",
//                            "items": {
//                                "type": "string"
//                            },
//                            "minItems": 1,
//                            "uniqueItems": true
//                        }
//                    },
//                    "required": ["id", "name", "price"]
//                }
//                editor.setSchema(schema);
                // get json
//                var json = editor.get();


            });

<?php
echo $this->Blocks->get("custom_js");
?>
        });
    </script>
    <?php echo $this->Form->end() ?>
</div>