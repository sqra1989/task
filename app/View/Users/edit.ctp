<div class="users form">

    <?php echo $this->element('page_title', array('title' => 'Edit User', 'subtitle' => '')); ?>
    <?php echo $this->element('page_bar'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <!--<i class="fa fa-gift"></i>-->
                        <?php echo __('Personal Informations'); ?>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <!--<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                        <!--<a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                        <!--<a href="javascript:;" class="remove" data-original-title="" title=""> </a>-->
                    </div>
                </div>

                <div class="portlet-body form">
                    <?php echo $this->Form->create(false, array('role' => 'form', 'autocomplete' => 'off')); ?>
                    <div class="form-body">
                        <?php //echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => __('Id'))); ?>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.name', array('class' => 'form-control', 'placeholder' => __('imie'), 'label' => __('imie'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.surname', array('class' => 'form-control', 'placeholder' => __('nazwisko'), 'label' => __('nazwisko'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.telefon', array('class' => 'form-control', 'placeholder' => __('tel'), 'label' => __('telefon'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4 hide">
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.username', array('class' => 'form-control', 'placeholder' => __('First name'), 'label' => __('Username'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('User.email', array('class' => 'form-control', 'placeholder' => __('e-mail'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->input('User.type', array(
                                        'options' => Configure::read('App.typkonta'),
                                        'empty' => false,
                                        'label' => __('Typ konta'),
                                        'required' => false,
                                        'class' => 'form-control type-conta', 'div' => false
                                    ));
                                    ?>
                                </div>

                            </div> 
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <?php echo $this->Form->input('User.born', array('type' => 'text', 'class' => 'form-control datepicker', 'placeholder' => __('data urodzenia'), 'label' => __('data urodzenia'), 'div' => FALSE)); ?>
                                </div>
                            </div>

                        </div>

                        <div class="company-details" <?php if (!isset($this->request->data['User']['type']) || $this->request->data['User']['type'] == 'prywatne'): ?>style="display:none;" <?php endif; ?>>
                            <h4 class="block"><?php echo __('Dane firmy'); ?></h4>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?php echo $this->Form->input('User.company', array('class' => 'form-control', 'placeholder' => __(''), 'label' => __('Firma'), 'div' => FALSE)); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?php echo $this->Form->input('User.nip', array('class' => 'form-control', 'placeholder' => __(''), 'label' => __('NIP'), 'div' => FALSE)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($isAdmin) : ?>
                            <h4 class="block"><?php echo __('Administrator options'); ?></h4>

                            <div class="row">
                                <!--<div class="col-md-12">-->
                                <!--<div class="row">-->
                                <!--<div class="col-md-4">-->
                                <!--<div class="form-group">-->
                                <?php // echo $this->Form->input('User.login', array('class' => 'form-control', 'placeholder' => __('User name'), 'required' => true, 'label' => __('User name'), 'div' => false)); ?>
                                <!--</div>-->
                                <!--</div>-->
                                <!--</div>-->
                                <!--</div>-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->input('User.status', array(
                                            'options' => Configure::read('Config.userStatuses'),
                                            'empty' => false,
                                            'required' => TRUE,
                                            'class' => 'form-control select2', 'div' => false
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->input('User.role_id', array(
                                            'label' => __('Role'),
                                            'empty' => false,
                                            'options' => $roles,
                                            'class' => 'form-control select2 chain_id',
                                            'div' => false
                                        ));
                                        ?>
                                    </div>
                                </div>

                                <!--<div class="col-md-6">-->
                                <!--<label>&nbsp;</label>-->
                                <?php // echo $this->Form->input('send_password', array('type' => 'checkbox', 'class' => '', 'label' => __('Send password to e-mail'), 'div' => false)); ?>
                                <!--</div>-->
                            </div>
                            <?php if ($auth['role_id'] == '3'): ?>
                                <h4 class="block"><?php echo __('Superadmin'); ?></h4>
                                <div class="row">  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->input('instance_id', array(
                                                'label' => __('Instance'),
                                                'empty' => false,
                                                'options' => $instances,
                                                'class' => 'form-control select2',
                                                'div' => false
                                            ));
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <?php echo $this->Form->submit(__('Save'), array('class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>
                        <?php echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'btn default', 'escape' => FALSE)); ?>
                    </div>

                </div>
            </div>
        </div>
     
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <!--<i class="fa fa-gift"></i>-->
                    <?php echo __('Change Password'); ?>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <!--<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                    <!--<a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                    <!--<a href="javascript:;" class="remove" data-original-title="" title=""> </a>-->
                </div>
            </div>

            <div class="portlet-body form">
                <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                <div class="form-body">
                    <div class="row">
                        <?php if (!$isAdmin) : ?>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo $this->Form->input('oldpassword', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('Old password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('Old password'), 'div' => FALSE)); ?>
                                </div>
                            </div>
                        <?php endif; ?>
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


<script>
    jQuery(document).on('change', '.type-conta', function () {
        if (jQuery('.type-conta option:selected').val() === 'b2b') {
            jQuery('.company-details').show();
        } else {
            jQuery('.company-details').hide();
        }
    });
</script>