<div class="page-sidebar navbar-collapse collapse">

    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="nav-item start ">
            <a href="<?php echo $this->Html->url(array('controller' => 'index', 'action' => 'index_admin', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title"><?php echo __('Dashboard'); ?></span>

            </a>
        </li>
      
        <li class="nav-item  <?php if (($this->params['controller'] == 'users') and ( $this->params['action'] == 'index')) : ?> active<?php endif; ?>">
            <?php echo $this->Html->link('<i class="fa fa-users"></i><span class="title">' . __('Users') . '</span>', array('admin' => false, 'controller' => 'users', 'action' => 'index', 'plugin' => false), array('escape' => false)); ?>
        </li>


        <li class="nav-item start <?php if (($this->params['controller'] == 'pagegroups') || ($this->params['controller'] == 'cmspages')) : ?>active open<?php endif; ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-pencil"></i>
                <span class="title"><?php echo __('Strony'); ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu" style="">
                <li class="nav-item start <?php if (($this->params['controller'] == 'cmspages') or ( $this->params['controller'] == 'add')) : ?>active <?php endif; ?>">
                    <?php echo $this->Html->link('<i class="fa fa-plus-square-o"></i><span class="title">' . __('Dodaj stronę') . '</span>', array('admin' => false, 'controller' => 'cmspages', 'action' => 'add', 'plugin' => false), array('escape' => false)); ?>
                </li>
                <li class="nav-item start <?php if (($this->params['controller'] == 'cmspages') and ( $this->params['action'] == 'index')) : ?>active <?php endif; ?>">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i><span class="title">' . __('Strony') . '</span>', array('admin' => false, 'controller' => 'cmspages', 'action' => 'index', 'plugin' => false), array('escape' => false)); ?>
                </li>
            </ul>
        </li>

        <li class="nav-item" <?php if (($this->params['controller'] == 'users') and ( $this->params['action'] == 'admins')) : ?>class="active"<?php endif; ?>>
            <?php echo $this->Html->link('<i class="fa fa-briefcase"></i><span class="title">' . __('Administratorzy') . '</span>', array('admin' => false, 'controller' => 'users', 'action' => 'admins', 'plugin' => false), array('escape' => false)); ?>
        </li>

        <li class="nav-item" <?php if (($this->params['controller'] == 'users') and ( $this->params['action'] == 'profile')) : ?>class="active"<?php endif; ?>>
            <?php echo $this->Html->link('<i class="icon-user"></i> <span class="title">' . __('My profile') . '</span>', array('admin' => false, 'controller' => 'users', 'action' => 'profile', 'plugin' => false), array('escape' => false)); ?>
        </li>


    </ul>
    <!-- END SIDEBAR MENU -->
</div>