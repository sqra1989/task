<p style="font-size: 20px">Dear <?php echo $user['User']['username']; ?>,</p>

<p><?php echo __('Please click %s to reset your password.', $this->Html->link(__('here'), $link)); ?></p>           

<p><?php echo __("If you did not request password change, ignore that message.", Configure::read('App.name')); ?></p>