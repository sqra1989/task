<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="nav-item start ">
            <a href="<?php echo $this->Html->url(array('controller' => 'index', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title"><?php echo __('User Dashboard'); ?></span>
                <!--<span class="arrow"></span>-->
            </a>
            <!--ul class="sub-menu">
                <li class="nav-item start ">
                    <a href="index.html" class="nav-link ">
                        <i class="icon-bar-chart"></i>
                        <span class="title">Dashboard 1</span>
                    </a>
                </li>
                <li class="nav-item start ">
                    <a href="dashboard_2.html" class="nav-link ">
                        <i class="icon-bulb"></i>
                        <span class="title">Dashboard 2</span>
                        <span class="badge badge-success">1</span>
                    </a>
                </li>
                <li class="nav-item start ">
                    <a href="dashboard_3.html" class="nav-link ">
                        <i class="icon-graph"></i>
                        <span class="title">Dashboard 3</span>
                        <span class="badge badge-danger">5</span>
                    </a>
                </li>
            </ul-->
        </li>

        <li class="nav-item">
            <a href="<?php echo $this->Html->url(array('controller' => 'clients', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title"><?php echo __('Clients'); ?></span>
                <!--<span class="arrow"></span>-->
            </a>
            <!--<ul class="sub-menu">-->
            <!--<li class="nav-item">-->
                <!--<a href="<?php // echo $this->Html->url(array('controller' => 'clients', 'action' => 'index', 'admin' => false, 'plugin' => false));    ?>" class="nav-link ">-->
                    <!--<i class="icon-users"></i>-->
                    <!--<span class="title"><?php // echo __('List Clients');    ?></span>-->
            <!--</a>-->
            <!--</li>-->
            <!--</ul>-->
        </li>

        <li class="nav-item">
            <a href="<?php echo $this->Html->url(array('controller' => 'skladnikis', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-chemistry"></i>
                <span class="title"><?php echo __('Ingredients'); ?></span>
                <!--<span class="arrow"></span>-->
            </a>
            <!--ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php // echo $this->Html->url(array('controller' => 'operators', 'action' => 'index', 'admin' => false, 'plugin' => false));    ?>" class="nav-link ">
                        <i class="icon-users"></i>
                        <span class="title"><?php // echo __('List Operators');    ?></span>
                    </a>
                </li>
            </ul-->
        </li>

        <li class="nav-item">
            <a href="<?php echo $this->Html->url(array('controller' => 'posilkis', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-cup"></i>
                <span class="title"><?php echo __('Meals'); ?></span>
                <!--<span class="arrow"></span>-->
            </a>
            <!--ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo $this->Html->url(array('controller' => 'operators', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link ">
                        <i class="icon-users"></i>
                        <span class="title"><?php echo __('List Operators'); ?></span>
                    </a>
                </li>
            </ul-->
        </li>
        <li class="nav-item">
            <a href="<?php echo $this->Html->url(array('controller' => 'dieties', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-note"></i>
                <span class="title"><?php echo __('Diets'); ?></span>
                <!--<span class="arrow"></span>-->
            </a>
            <!--ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php // echo $this->Html->url(array('controller' => 'operators', 'action' => 'index', 'admin' => false, 'plugin' => false));    ?>" class="nav-link ">
                        <i class="icon-users"></i>
                        <span class="title"><?php // echo __('List Operators');    ?></span>
                    </a>
                </li>
            </ul-->
        </li>

        <li class="nav-item  ">
            <a href="<?php echo $this->Html->url(array('controller' => 'plany_dietetycznes', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title"><?php echo __('Diet Plans'); ?></span>
                <!--<span class="arrow"></span>-->
            </a>
        </li>

        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title"><?php echo __('Settings'); ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item" <?php if (($this->params['controller'] == 'users') and ( $this->params['action'] == 'edit')) : ?>class="active"<?php endif; ?>>
                    <?php echo $this->Html->link('<i class="icon-user"></i><span class="title">' . __('My profile') . '</span>', array('admin' => false, 'controller' => 'users', 'action' => 'edit', 'plugin' => false), array('escape' => false)); ?>
                </li>
                <!--<li <?php // if (($this->params['controller'] == 'skladniki_jednostkis')) :  ?>class="active"<?php // endif;  ?>>-->
                <?php // echo $this->Html->link('<i class="icon-drop"></i><span class="title">' . __('Units'), array('admin' => false, 'controller' => 'skladniki_jednostkis', 'action' => 'index', 'plugin' => false), array('escape' => false)); ?>
                <!--</li>-->
                <!--<li <?php // if (($this->params['controller'] == 'skladniki_numery_kodowes')) :  ?>class="active"<?php endCif; ?>>-->
                <?php // echo $this->Html->link('<i class="icon-organization"></i><span class="title">' . __('Skladniki Numery Kodowe'), array('admin' => false, 'controller' => 'skladniki_numery_kodowes', 'action' => 'index', 'plugin' => false), array('escape' => false)); ?>
                <!--</li>-->
                <!--<li <?php // if (($this->params['controller'] == 'posilki_grupies')) :  ?>class="active"<?php // endif;  ?>>-->
                <?php // echo $this->Html->link('<i class="icon-organization"></i><span class="title">' . __('Posilki Grupies'), array('admin' => false, 'controller' => 'posilki_grupies', 'action' => 'index', 'plugin' => false), array('escape' => false)); ?>
                <!--</li>-->
            </ul>
        </li>

        <?php if (Configure::read('App.SAS.mode')) : ?>
            <li class="nav-item  ">
                <a href="<?php echo $this->Html->url(array('controller' => 'payments', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>" class="nav-link nav-toggle">
                    <i class="icon-credit-card"></i>
                    <span class="title"><?php echo __('Payments'); ?></span>
                    <!--<span class="arrow"></span>-->
                </a>
            </li>
        <?php endif; ?>

    </ul>
    <!-- END SIDEBAR MENU -->
</div>