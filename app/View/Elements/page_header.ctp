<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?php echo $this->Html->url('/', true); ?>">
                <?php // echo Configure::read('App.name'); ?>
                <!--<img src="<?php echo Router::url('/', true); ?>assets/layouts/layout2/img/logo-default.png" alt="logo" class="logo-default">-->
                <!--<img src="<?php // echo Router::url('/', true); ?>/img/logo.png" alt="logo" class="logo-default">-->
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->

    </div>
    <!-- END PAGE ACTIONS -->
    <!-- BEGIN PAGE TOP -->
    <div class="page-top"> 
         <?php echo $this->Html->image('logo.jpg', array('id' => 'logo-alternative')); ?>
       
        <?php //echo $this->Html->image(Configure::read('App.logo.png'), array('id' => 'logo-alternative', 'style' => '')); ?>
        <!--<img id="logo-alternative" src="<?php // echo Router::url('/', true); ?>/img/logo.png" alt="logo" />-->

        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
           
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <!--<img alt="" class="img-circle" src="<?php echo Router::url('/', true); ?>assets/layouts/layout2/img/avatar3_small.jpg">-->
                        <span class="username username-hide-on-mobile"><i class="icon-user"></i>
                            <?php
                                
                            echo  $auth['username'];
                            ?>
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'profile')); ?>">
                                <i class="icon-user"></i> <?php echo __('My profile'); ?> </a>
                        </li>
                      <li class="divider"> </li>
                       
                        <li>
                            <a href="<?php echo Router::url(array('controller' => 'index', 'action' => 'index_admin')); ?>">
                                <i class="icon-home"></i> <?php echo __('Dashboard'); ?> </a>
                        </li>
                        <li class="divider"> </li>
                       
                        <li>
                            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logouts')); ?>">
                                <i class="icon-key"></i> <?php echo __('Logout'); ?> </a>
                        </li>
                    </ul>
                </li>
              
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->

      
    </div>
    <!-- END PAGE TOP -->
</div>
<!-- END HEADER INNER -->