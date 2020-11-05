<div class="cmspages form">

    <?php echo $this->element('page_bar'); ?>
    <div class="row">


        <div class="col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase"><?php echo __('Dodaj wpis'); ?></span>
                    </div>
                </div>

                <div class="portlet-body form">

                    <?php echo $this->Form->create('Cmspage', array('type' => 'file')); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('Tytuł'), 'div' => false)); ?>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php echo $this->Form->submit(__('Save'), array('style' => 'display:inline-block;', 'class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>
                        <?php echo $this->Html->link(__('Cancel'), array(/* 'admin' => $this->request->params['admin'], */'action' => 'index'), array('style' => 'display:inline-block;', 'class' => 'btn default', 'escape' => FALSE)); ?>
                    </div>
                    <?php echo $this->Form->end() ?>

                </div>
            </div>
        </div>
    </div>
</div>
