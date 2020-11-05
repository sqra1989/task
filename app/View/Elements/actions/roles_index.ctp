<div class="page-toolbar">
    <div class="btn-group pull-right">
 <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true" aria-expanded="false">
            <?php echo __('Actions'); ?>
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('Dodaj nowy'), array('action' => 'add'), array('escape' => false)); ?></li>
        </ul>
    </div>
</div>