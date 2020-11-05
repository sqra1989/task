<div class="contents">
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <div class="login-container">
        
        

                <?php echo $this->Form->create('User'); ?>
                <h3 class="form-title font-gray"><?php echo __('Forget Password?'); ?></h3>
                <div class="form-group">
                    <?php echo __('Enter your e-mail address below to reset your password.'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('email', array('label' => false, 'class' => 'form-control small form-control-solid placeholder-no-fix', 'placeholder' => __('email')));
                    ?>
                </div>
                <div class="form-actions">
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default green uppercase pull-right', 'style' => '', 'div' => FALSE, 'after' => '')); ?>
                    <?php echo $this->Html->link(__('Cancel'), array('action' => 'login'), array('class' => 'btn btn-info', 'style' => 'display: inline-block;')); ?>
                </div>
          
    </div>
</div>
</div>