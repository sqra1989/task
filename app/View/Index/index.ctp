<div class="banner-homepage">
    <div class="caption">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $homePage['Cmspage']['bannertext']; ?>
                </div>
            </div>

        </div>

    </div>
    <?php echo $this->Html->image($homePage['Cmspage']['imagebig'], array('class' => 'img-responsive')); ?>
</div>
<div id="szczegoly" class="container">
    <?php if ($homePage['Cmspage']['content']): ?>
        <div class="std grid-gap">
            <?php echo $homePage['Cmspage']['content']; ?>
        </div>
    <?php endif; ?>
    <?php if (!$auth): ?>
        <div class="container" id="artykuly">
            <div  class="std grid-gap no-padding-top">




                <div id="logowanie" class="login-container login-container-with-background text-center">
                    <?php echo $this->Form->create('User', array('class' => 'login-form', 'url' => array('controller' => 'users', 'action' => 'login'))); ?>

                    <div class="form-group">
                        <h3><?php echo Configure::read('App.name'); ?></h3>
                        <div class="clearfix gap30 hidden-xs"></div>
                        <p><?php echo __('Zaloguj się lub'); ?> <?php echo $this->Html->link(__('załóż konto'), array('controller' => 'users', 'action' => 'register'), array('class' => 'color-light-blue')); ?></p>
                        <div class="form-group">
                            <?php
                            echo $this->Form->input('normallogin', array('type' => 'hidden', 'value' => 1, 'label' => false, 'class' => 'form-control small form-control-solid placeholder-no-fix', 'placeholder' => __('email'), 'autocomplete' => 'off', 'div' => false));
                            ?>
                            <?php
                            echo $this->Form->input('email', array('label' => false, 'class' => 'form-control big form-control-solid placeholder-no-fix', 'placeholder' => __('email'), 'autocomplete' => 'off', 'div' => false));
                            ?>
                        </div>
                        <div class="form-group">

                            <?php
                            echo $this->Form->input('password', array('type' => 'password', 'required' => false, 'label' => false, 'class' => 'form-control big', 'placeholder' => __('hasło'), 'before' => false, 'div' => false));
                            ?>
                        </div>    
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label class="rememberme check text-center" >
                                        <?php
                                        echo $this->Form->input('remember_me', array('label' => __('Remember me'), 'checked' => true, 'type' => 'checkbox'));
                                        ?>
                                    </label>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <?php echo $this->Html->link(__('Forgot password?'), array('controller' => 'users', 'action' => 'lostpassword'), array('id' => 'forget-password', 'class' => 'forget-password')); ?>


                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <?php echo $this->Form->submit(__('Login'), array('class' => 'btn btn-default', 'div' => false)); ?>
                            <div class="clearfix gap60"></div>

                        </div>
                        <div class="create-account">
                            <div class="clearfix "></div>
                            <p>Nie masz konta? Przejdź do rejestracji.
                            </p>
                            <?php echo $this->Html->link(__('Przejdź do rejestracji'), array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-info')); ?>

                        </div>
                        <div class="clearfix gap5"></div>


                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>





            </div>
        </div>    
    <?php endif; ?>
   

</div>

