<div class="users form">

    <?php echo $this->element('page_title', array('title' => 'User profile', 'subtitle' => '')); ?>
    <?php echo $this->element('page_bar'); ?>


    <div class="row">
        <div class="col-md-6">
            <div class="portlet light ">
                <!-- STAT -->
                <div class="row list-separated profile-stat">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> ?? </div>
                        <div class="uppercase profile-stat-text"> Codes </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> ?? </div>
                        <div class="uppercase profile-stat-text"> Pounds </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> ?? </div>
                        <div class="uppercase profile-stat-text"> Reservations </div>
                    </div>
                </div>
                <!-- END STAT -->
                <div>
                    <h4 class="profile-desc-title profile-username"><?php echo $user['User']['username']; ?></h4>
                    <span class="profile-desc-text"><?php echo __('Account details on'); ?> <?php echo $user['Instance']['name']; ?> </span>
                    <div class="margin-top-20 profile-desc-link">

                        <strong><i class="fa fa-envelope-o"></i> <?php echo __('E-mail'); ?></strong>
                        <?php echo $user['User']['email']; ?>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <strong><i class="fa fa-calendar"></i> <?php echo __('Date of birth'); ?></strong>
                        <?php echo $user['User']['born']; ?>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <strong><i class="fa fa-calendar"></i> <?php echo __('Account creation date'); ?></strong>
                        <?php echo $user['User']['created']; ?>
                    </div>

                </div>
            </div>
         

        </div>
        
        
    </div>
</div>
