<?php

//$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $cakeDescription ?>:
        <?php echo $title_for_layout; ?>
    </title>
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('style');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
<body>
	<div id="container">
            <div id="header">

            </div>
            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <?php echo $this->Html->link(
                                $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
                                'http://www.cakephp.org/',
                                array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                            );
                ?>
                <p>
                        <?php echo $cakeVersion; ?>
                </p>
            </div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
