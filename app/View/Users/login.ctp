<div class="contents">
<div class="content container main-content">

    <div class="login-container">
<?php echo $this->Form->create('User', array('class' => 'login-form')); ?>
<div class="text-center ">
        <h3 class="gap50"><?php echo Configure::read('App.name'); ?></h3>
           <p class="sub-title"><?php echo __('Zaloguj się lub'); ?> <?php echo $this->Html->link(__('załóż konto'), array('controller' => 'users', 'action' => 'register'), array('class' => 'color-light-blue')); ?></p>
                             
    </div>
<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    <span>  <?php echo __('Enter any username and password'); ?>.</span>
</div>
<div class="form-group">
    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
    <div class="form-group">
    <?php
    echo $this->Form->input('email', array('label' => false, 'id' => '', 'class' => 'form-control small form-control-solid placeholder-no-fix', 'placeholder' => __('email'), 'autocomplete' => 'off', 'div' => false));
    ?>
    </div>
    <div class="form-group">
     
        <?php
        echo $this->Form->input('password', array('type' => 'password', 'required' => false, 'label' => false, 'class' => 'form-control small', 'placeholder' => __('Password'), 'before' => false, 'div' => false));
        ?>
        <div class="form-actions gap50">
            <div class="row gap15">
                <div class="col-xs-6">
                        <label class="rememberme check">
                <?php
                echo $this->Form->input('remember_me', array('label' => __('Remember me'), 'type' => 'checkbox'));
                ?>
            </label>
                </div>
                <div class="col-xs-6">
                             <?php echo $this->Html->link(__('Forgot password?'), array('action' => 'lostpassword'), array('id' => 'forget-password', 'class' => 'forget-password')); ?>
      
              
                </div>
            </div>
            
            <div class="text-center">
            <?php echo $this->Form->submit(__('Login'), array('class' => 'btn btn-default', 'div' => false)); ?>
            </div>
            <div class="clearfix"></div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="text-center">
            <p>
                <?php echo $this->Html->link(__('New account'), array('controller' => 'users', 'action' => 'register'), array('id' => '', 'class' => 'uppercase btn btn-info')); ?>
            </p>
        </div>
    </div>
</div>

    </div>
</div>
</div>