

<div class="content container main-content std">

    <div class=" grid-gap">

        <div class="portlet-body form text-center">



            <div class="row">
                <div class="col-xs-12">

                    <h3><?php echo __('Wylogowano '); ?></h3>
                    <p><?php echo __('Za chwilę zostaniesz przekierowany na stronę główna.'); ?></p>
                    <a class="btn btn-default" href="<?php echo $this->Html->url(array('controller' => 'index', 'action' => 'index')); ?>">Powrót do strony głównej</a>
                </div>
            </div>
        </div>   
    </div>
    <script>
        setTimeout(
                function ()
                {
                    window.location.replace('<?php echo $this->webroot; ?>');
                }, 5000);
    </script>


