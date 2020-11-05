<div class="admin index">
    <?php echo $this->element('page_title', array('title' => __('Panel administratora'), 'subtitle' => '')); ?>
    <?php echo $this->element('page_bar'); ?>
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat blue" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index')); ?>">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number"> <?php echo $usersCount; ?>  </div>
                    <div class="desc"> <?php echo __('Users'); ?> </div>
                </div>
                <span class="more" > <?php echo __('View more'); ?>
                    <i class="m-icon-swapright m-icon-white"></i>
                </span>
            </a>
        </div>
    </div> 
</div>

