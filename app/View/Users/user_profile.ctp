


<div class="content container main-content grid-gap">


    <div class="std">  
        <div class="text-center"><h1 class="page-title "><?php echo __('My profile') ?></h1></div>
        <div class="row no-margin-bottom">
            <div class="col-md-6 text-center">
                <div class="portlet light ">
                    <!-- STAT -->

                    <!-- END STAT -->
                    <div>


                        <?php if ($user['User']['company']): ?>
                            <div class="margin-top-20 profile-desc-link">

                                <strong><i class="fa fa-building-o"></i> <?php echo __('Firma'); ?></strong>
                                <?php echo $user['User']['company']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($user['User']['nip']): ?>
                            <div class="margin-top-20 profile-desc-link">

                                <strong><i class="fa fa-th"></i> <?php echo __('NIP'); ?></strong>
                                <?php echo $user['User']['nip']; ?> 
                            </div>  
                        <?php endif; ?>

                    
                        <div class="margin-top-20 profile-desc-link">

                            <strong><i class="fa fa-user"></i> <?php echo __('Nazwa użytkownika'); ?></strong>
                            <?php echo $user['User']['name']; ?> <?php echo $user['User']['surname']; ?>
                        </div>
                        <div class="margin-top-20 profile-desc-link">

                            <strong><i class="fa fa-calendar"></i> <?php echo __('Data urodzenia'); ?></strong>
                            <?php echo $user['User']['born']; ?> 
                        </div>
                        <div class="margin-top-20 profile-desc-link">

                            <strong><i class="fa fa-envelope-o"></i> <?php echo __('E-mail'); ?></strong>
                            <?php echo $user['User']['email']; ?>
                        </div>

                        <div class="margin-top-20 profile-desc-link">
                            <strong><i class="fa fa-calendar"></i> <?php echo __('Konto utworzono'); ?></strong>
                            <?php echo $user['User']['created']; ?>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <strong><i class="fa fa-mobile"></i> <?php echo __('Telefon'); ?></strong>
                            <?php echo $user['User']['telefon']; ?>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <strong><i class="fa fa-info-circle"></i> <?php echo __('Typ konta'); ?></strong>
                            <?php echo $user['User']['type']; ?>
                        </div>
                        <?php if ($user['User']['type'] == 'b2b'): ?>
                            <div class="margin-top-20 profile-desc-link">
                                <strong><i class="fa fa-money"></i> <?php echo __('Twoje tokeny'); ?></strong>
                                <?php echo $user['User']['tokens']; ?>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                                <?php echo $this->Html->link(__('Dokup tokeny'), array('admin' => false, 'controller' => 'packages', 'action' => 'my_tokens', 'plugin' => false), array('class' => 'btn btn-default', 'escape' => false)); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
            <div class="col-md-6">
               
                <div id="demo" class="">
                    <div class="tu-form margin-top-20">
                        <div class="portlet-title text-center">
                            <h4>Zmiana danych</h4>

                        </div>

                        <div class="portlet-body">
                            <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                            <div class="form-body padding20">
                                <?php //echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => __('Id'))); ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => __('First name'), 'label' => __('Imię'), 'div' => FALSE)); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <?php echo $this->Form->input('surname', array('class' => 'form-control', 'placeholder' => __('First name'), 'label' => __('Nazwisko'), 'div' => FALSE)); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <?php echo $this->Form->input('telefon', array('class' => 'form-control', 'placeholder' => __('Telefon'), 'label' => __('Telefon'), 'div' => FALSE)); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <?php echo $this->Form->input('born', array('type' => 'text', 'class' => 'form-control datepicker', 'placeholder' => __('data urodzenia'), 'label' => __('data urodzenia'), 'div' => FALSE)); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                <?php echo $this->Form->submit(__('Zmień'), array('class' => 'btn btn-default btn-sm', 'div' => FALSE, 'after' => '')); ?>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>




        </div>

        <div class="row grid-gap no-padding-bottom">
         

            <div class="col-md-6">
                <div class="text-center"><h2 class="page-title "><?php echo __('Zmiana hasła') ?></h2></div>
                <div class="tu-form">


                    <div class="portlet-body">
                        <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                        <div class="form-body padding20">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <?php echo $this->Form->input('oldpassword', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('Old password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('Old password'), 'div' => FALSE)); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $this->Form->create('User', array('role' => 'form', 'autocomplete' => 'off')); ?>
                                    <div class="form-group">
                                        <?php echo $this->Form->input('passwordnew', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('New password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('New password'), 'div' => FALSE)); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->input('passwordnew2', array('type' => 'password', 'class' => 'form-control', 'placeholder' => __('Confirm new password'), 'required' => true, 'value' => '', 'autocomplete' => 'off', 'label' => __('Confirm new password'), 'div' => FALSE)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-default btn-sm', 'div' => FALSE, 'after' => '')); ?>
                            <?php // echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'btn default', 'escape' => FALSE)); ?>
                        </div>
                        <?php echo $this->Form->end() ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>