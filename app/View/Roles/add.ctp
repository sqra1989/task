<div class="roles form">

    <h3><?php echo $this->element('page_title', array('title' => __('Add Role'), 'subtitle' => '')); ?></h3>
    <?php echo $this->element('page_bar'); ?>
    <div class="row">
        <!--div class="col-md-3">
            <div class="actions">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo __('Actions'); ?></div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                                                        <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;' . __('List Roles'), array('action' => 'index'), array('escape' => false)); ?></li>
                            		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;' . __('List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>			
        </div-->
        
        <div class="col-sm-12">
            <div class="portlet box green">
                <!--div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">Personal Informations</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-pencil"></i> Edit </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-ban"></i> Ban </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;"> Make admin </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div-->

           

                   <div class="portlet-body form">

                    <?php echo $this->Form->create('Role', array('role' => 'form')); ?>

                    <div class="form-body">
                       <div class="row">

                            <div class="clearfix"></div>
                            <div class="col-xs-12"><p class="info"><?php echo __('Ogólne'); ?></p></div>
                            <div class="clearfix"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => __('Name'), 'div' => false)); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12"><p class="info"><?php echo __('Uprawnienia'); ?></p></div>
                            <div class="clearfix"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('Project', array('class' => 'form-control select2', 'label' => __('Dla projektów'), 'placeholder' => __('rola'), 'div' => false)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('Tasktype', array('class' => 'form-control select2', 'label' => __('Dla zadań'), 'placeholder' => __('rola'), 'div' => false)); ?>
                                </div>
                            </div>
<div class="col-sm-4">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->input('type', array(
                                            'options'=>Configure::read('Config.rolePermisions'),
                                            'empty' => false,
                                            'readonly' => true,
                                            'label' => __('Dodatkowe uprawnienia'),
                                            'required' => TRUE,
                                            'class' => 'form-control select2', 'div' => false
                                        ));
                                        ?> </div>
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
