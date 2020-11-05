<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="<?php echo $pluralVar; ?> form">

    <h3><?php echo "<?php echo \$this->element('page_title', array('title' => __('" . sprintf("%s %s", Inflector::humanize($action), $singularHumanName) . "'), 'subtitle' => '')); ?>"; ?></h3>
    <?php echo "<?php echo \$this->element('page_bar'); ?>"; ?>

    <div class="row">
        <!--div class="col-md-3">
            <div class="actions">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo "<?php echo __('Actions'); ?>"; ?></div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <?php if (strpos($action, 'add') === false): ?>
                                <li><?php echo "<?php echo \$this->Form->postLink('<span class=\"glyphicon glyphicon-remove\"></span>&nbsp;&nbsp;' . __('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('escape' => false), __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>"; ?></li>
                            <?php endif; ?>
                            <li><?php echo "<?php echo \$this->Html->link('<span class=\"glyphicon glyphicon-list\"></span>&nbsp;&nbsp;' . __('List " . $pluralHumanName . "'), array('action' => 'index'), array('escape' => false)); ?>"; ?></li>
                            <?php
                            $done = array();
                            foreach ($associations as $type => $data) {
                                foreach ($data as $alias => $details) {
                                    if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                        echo "\t\t<li><?php echo \$this->Html->link('<span class=\"glyphicon glyphicon-list\"></span>&nbsp;&nbsp;' . __('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('escape' => false)); ?> </li>\n";
                                        echo "\t\t<li><?php echo \$this->Html->link('<span class=\"glyphicon glyphicon-plus\"></span>&nbsp;&nbsp;' . __('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('escape' => false)); ?> </li>\n";
                                        $done[] = $details['controller'];
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>			
        </div-->
        
        <div class="col-sm-12">
            <div class="portlet box green">
                <!--div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"><?php echo __('Personal Informations'); ?></span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-pencil"></i> Edit </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-ban"></i> Ban </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;"> Make admin </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div-->

                <div class="portlet-body form">
        
                    <?php echo "\t\t\t<?php echo \$this->Form->create('{$modelClass}', array('role' => 'form')); ?>\n\n"; ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <?php
                                foreach ($fields as $field) {
                                    if (strpos($action, 'add') !== false && $field == $primaryKey) {
                                        continue;
                                    } elseif (!in_array($field, array('created', 'modified', 'updated'))) {
                                        echo "\t\t\t\t<div class=\"form-group\">\n";
                                        echo "\t\t\t\t\t<?php echo \$this->Form->input('{$field}', array('class' => 'form-control', 'placeholder' => __('" . Inflector::humanize($field) . "'), 'div' => false));?>\n";
                                        echo "\t\t\t\t</div>\n";
                                    }
                                }
                                if (!empty($associations['hasAndBelongsToMany'])) {
                                    foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
                                        echo "\t\t\t\t<div class=\"form-group\">\n";
                                        echo "\t\t\t\t\t<?php echo \$this->Form->input('{$assocName}', array('class' => 'form-control', 'placeholder' => __('" . Inflector::humanize($field) . "')));?>\n";
                                        echo "\t\t\t\t</div>\n";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php
                        echo "\t\t\t\t\t<?php echo \$this->Form->submit(__('Save'), array('style' => 'display:inline-block;', 'class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>\n";
                        echo "\t\t\t\t\t<?php echo \$this->Html->link(__('Cancel'), array(/*'admin' => \$this->request->params['admin'], */'action' => 'index'), array('style' => 'display:inline-block;', 'class' => 'btn default', 'escape' => FALSE)); ?>\n";
                        ?>
                    </div>
                    <?php echo "\t\t\t<?php echo \$this->Form->end() ?>\n\n"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
