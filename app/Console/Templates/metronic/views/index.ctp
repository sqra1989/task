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

<div class="<?php echo $pluralVar; ?> index">

    <h3><?php echo "<?php echo \$this->element('page_title', array('title' => __('{$pluralHumanName}'), 'subtitle' => '')); ?>"; ?></h3>
    <?php echo "<?php echo \$this->element('page_bar'); ?>"; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12">

            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <!--<i class="fa fa-gift"></i>-->
                        <?php echo "<?php echo __('{$pluralHumanName} List'); ?>"; ?>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <!--<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                        <!--<a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                        <!--<a href="javascript:;" class="remove" data-original-title="" title=""> </a>-->
                    </div>
                </div>
                <div class="portlet-body">
                    <h1><?php echo "<?php echo \$this->DataTable->render('{$modelClass}', array('class' => 'table table-striped table-bordered table-hover dataTable no-footer')) ?>"; ?>
                </div>
            </div>
        </div>
    </div>
</div>