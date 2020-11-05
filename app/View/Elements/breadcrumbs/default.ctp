<ul class="page-breadcrumb">
    <li>
        <i class="icon-home"></i>
        <?php echo $this->Html->link(__('Start'), array('controller' => 'index', 'action' => 'index')); ?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span><?php echo __(Inflector::humanize($this->request->params['controller'])); ?></span>
    </li>
</ul>
