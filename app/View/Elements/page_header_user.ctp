<nav id="bmain-nav" class="navbar navbar-default not-section">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->Html->url('/', true); ?>">    <?php echo $this->Html->image('logo.jpg', array('class' => 'img-responsive main-logo')); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">
                <li><a class="" href="<?php echo $this->Html->url(array('controller' => 'index', 'action' => 'index')); ?>"> <?php echo __('Strona główna'); ?></a></li>
             

         
                <?php foreach ($menuCms as $item): ?>
                    <li><a href="<?php echo $this->Html->url(array('controller' => 'cmspages', 'action' => 'view', 'id' => $item['Cmspage']['id'], 'slug' => $item['Cmspage']['url'])); ?>"><?php echo $item['Cmspage']['title']; ?></a></li>
                <?php endforeach; ?>


                <?php if (!$auth): ?>
                    <li><a class="" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'register')); ?>"> <?php echo __('Rejestracja'); ?></a></li>

                    <li><a class="more goto" href="#logowanie"> <?php echo __('Logowanie'); ?></a></li>
                <?php endif; ?>

                <?php if (isset($auth) && $auth): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo __('Profil') . ''; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'user_profile')); ?>"><?php echo __('Moje konto') . ''; ?></a></li>              
                            <li><a class="more" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logouts')); ?>"> <?php echo __('Logout'); ?></a></li>
                        </ul>
                    </li> 
                <?php endif; ?>
            </ul>

        </div><!--/.nav-collapse -->




    </div><!--/.container-fluid -->
</nav>

