<!DOCTYPE html>
<?php //echo $this->Facebook->html(); ?>
<html>
    <head>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Latest compiled and minified JavaScript -->
        <?php echo $this->Html->script("../assets/global/plugins/jquery.js"); ?>
        
        <?php
        echo $this->Html->meta('icon');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>

        <!-- Latest compiled and minified CSS -->
        <!--link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"-->
        <?php echo $this->Html->css('bootstrap.min'); ?>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
          <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <?php echo $this->Html->css('print'); ?>
    </head>

    <body onload="window.print()">
    <!--<body>-->

        <?php //echo $this->Element('navigation'); ?>

        <div class="container">

            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>

            <?php //echo $this->Facebook->like(array('href' => Router::url('/', TRUE), 'layout' => 'button_count'));  ?>

        </div><!-- /.container -->

    </body>
    <?php //echo $this->Facebook->init(); ?>
</html>
