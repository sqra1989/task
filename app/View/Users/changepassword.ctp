
<div class="contents">
<div class="content container main-content">
    <div class="std">
        <div class="text-center"><h3 class="page-title"><?php echo __('Set new password'); ?></h3></div> 

        <?php echo $this->Form->create('User'); ?>
        <div class="form-group">
            <?php
            echo $this->Form->input('password', array('type' => 'password', 'label' => __('Password'), 'class' => 'form-control', 'placeholder' => __('Password'), 'div' => false));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->input('password2', array('type' => 'password', 'label' => __('Repeat password'), 'class' => 'form-control', 'placeholder' => __('Repeat password'), 'div' => false));
            ?>
        </div>
        <div class="form-actions">
            <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-default  uppercase pull-right', 'id' => 'register-submit-btn')); ?>
            <?php echo $this->Html->link(__('Cancel'), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-info', 'id' => 'register-back-btn')); ?>
        </div>
        <?php echo $this->Form->end(); ?>


    </div>
</div>
    </div>