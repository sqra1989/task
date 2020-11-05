<div class="users form">

    <?php echo $this->element('page_title', array('title' => 'My profile', 'subtitle' => '')); ?>
    <?php echo $this->element('page_bar'); ?>

    
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light ">
                                    <!-- STAT -->
                                    
                                    <!-- END STAT -->
                                    <div>
                                        <h4 class="profile-desc-title profile-username"><?php echo $user['User']['username']; ?></h4>
                                        
                                        <div class="margin-top-20 profile-desc-link">
                                           
                                           <strong><i class="fa fa-envelope-o"></i> <?php echo __('E-mail'); ?></strong>
                                            <?php echo $user['User']['email']; ?>
                                        </div>
                                        
                                        <div class="margin-top-20 profile-desc-link">
                                            <strong><i class="fa fa-calendar"></i> <?php echo __('Konto utworzono'); ?></strong>
                                           <?php echo $user['User']['created']; ?>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <strong><i class="fa fa-calendar"></i> <?php echo __('Konto modyfikowane'); ?></strong>
                                           <?php echo $user['User']['modified']; ?>
                                        </div>
                                        
                                    </div>
                                </div>
            
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="portlet  light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>
                        <?php echo __('Zmień dane'); ?>
                    </div>
                    
                </div>

                <div class="portlet-body form">
                    <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                    <div class="form-body">
                        <?php //echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => __('Id'))); ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => __('Imię'), 'label' => __('Imię'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('surname', array('class' => 'form-control', 'placeholder' => __('e-mail'),'label' => __('Nazwisko'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                             
                          
                        </div>
                       
                    </div>
                    <div class="form-actions">
                        <?php echo $this->Form->submit(__('Save'), array('class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-lock"></i>
                    <?php echo __('Change Password'); ?>
                </div>
               
            </div>

            <div class="portlet-body form">
                <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                <div class="form-body">
                    <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('oldpassword', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('Old password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('Old password'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                            <div class="form-group">
                                <?php echo $this->Form->input('passwordnew', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('New password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('New password'), 'div' => FALSE)); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?php echo $this->Form->input('passwordnew2', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('Confirm new password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('Confirm new password'), 'div' => FALSE)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo $this->Form->submit(__('Save'), array('class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>
                    <?php // echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'btn default', 'escape' => FALSE)); ?>
                </div>
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>