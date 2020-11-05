<!--<div class="<?php // echo $class; ?> <?php // if (!isset($dismissable) or $dismissable) : ?>alert-dismissable<?php // endif; ?>" data-alert="alert">-->
    <?php // if (!isset($dismissable) or $dismissable) : ?>
        <!--<button type="button" class="close" data-dismiss="alert" data-close="alert">×</button>-->
    <?php // endif; ?>
    <!--<span><?php // echo h($message); ?></span>-->
<!--</div>-->

<?php
switch ($class) {
    case 'alert alert-success':
        $type = 'success';
        break;
    case 'alert alert-danger':
        $type = 'error';
        break;
    default :
        $type = 'info';
        break;
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-center",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        
        toastr['<?php echo $type; ?>']("<?php echo h($message); ?>");
    });

</script>