<div class="employees index">
    <div class="fixedactions"><?php $this->assign('page_buttons', " ");?>
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add Dynamic View'), array('action' => 'add'), array('class' => 'btn blue', 'escape' => FALSE)); ?>
    </div>
    <?php echo $this->element('page_title', array('title' => 'Dynamic Fields', 'subtitle' => '')); ?>
    <?php echo $this->element('page_bar'); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12">

            <div class="portlet light bordered">
<!--                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-user font-dark"></i>
                        <span class="caption-subject bold uppercase"><?php echo __('Dynamic Views'); ?></span>
                    </div>
                </div>-->
                <div class="portlet-body">
                    <?php echo $this->DataTable->render('Ddatatable', array('class' => 'table table-striped table-bordered table-hover dataTable no-footer')) ?>
                </div>
            </div>
        </div>
    </div>
</div>