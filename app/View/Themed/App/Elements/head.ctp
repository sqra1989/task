<title>
    <?php echo Configure::read('App.name'); ?>
</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#57C5EB">
<base href="<?php echo Router::url('/', true) ?>">


<?php
echo $this->Html->meta('icon');

echo $this->fetch('meta');
echo $this->fetch('css');
?>

<!-- Latest compiled and minified JavaScript -->
<?php echo $this->Html->script("../assets/global/plugins/jquery.js"); ?>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<?php if (!isset($removeScripts)): ?>
<style type="text/css">
    body{ padding: 70px 0 0 0;}
    html, body {
        height: 100%;
    }
    .container {
        /*min-height: 100%;*/
    }
</style>
<?php endif; ?>
<?php
// Font awsome
//echo $this->Html->css('../font-awesome/css/font-awesome.min');
// Tables
//echo $this->Html->css(Router::url('/', TRUE) . 'css/tables.css');
if (!isset($removeScripts)):
    echo $this->Minify->script('../FooTable2/js/footable.js');
    echo $this->Html->css('../FooTable2/css/footable.core.css');
    ?>
    <script type="text/javascript">
        $(function () {
            $('.table').footable({
                breakpoints: {
                    "xs": 480, // extra small
                    "sm": 768, // small
                    "md": 992, // medium
                    "lg": 1200 // large
                }
            });
        });
    </script>
<?php endif; ?>
<?php
// Select2
//echo $this->Minify->script('../select2/select2.min.js');
//echo $this->Minify->script('../select2/select2_locale_' . Configure::read('Config.language') . '.js');
//echo $this->Html->css('../select2/select2.css');
//echo $this->Minify->css('../select2/select2-bootstrap.css');
// Nestable
if (!isset($removeScripts)) {
    echo $this->Minify->script('../nestable-master/jquery.nestable.js');
    echo $this->Minify->css('../assets/global/plugins/jquery-nestable/jquery.nestable.css');
}
// Flot graphs
if (!isset($removeScripts)) {
    echo $this->Minify->script('../flot/jquery.flot.js');
}
// Datepicker
//echo $this->Minify->script('../datepicker/js/bootstrap-datepicker.js');
//echo $this->Minify->css('../datepicker/css/datepicker.css');
// Magnific Popup
if (!isset($removeScripts)) {
    echo $this->Minify->css('../magnific-popup/dist/magnific-popup.css');
    echo $this->Minify->script('../magnific-popup/dist/jquery.magnific-popup.min.js');
}
// Bootstrap Switch
//echo $this->Minify->css('../bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css');
//echo $this->Minify->script('../bootstrap-switch/dist/js/bootstrap-switch.min.js');
// Daterangepicker
echo $this->Minify->css('../daterangepicker/daterangepicker-bs3.css');
echo $this->Minify->script('../daterangepicker/moment-local.js');
echo $this->Minify->script('../daterangepicker/daterangepicker.js');
//echo $this->Minify->script('../js/jquery.countdown.min.js');
if (!isset($removeScripts)) {
    echo $this->Minify->script('../js/masonry.pkgd.min.js');
    echo $this->Minify->script('../js/moment-round.min.js');
}
if (($this->request['controller'] == 'tasks' && $this->request['action'] == 'active')):
    echo $this->Minify->script('../js/ServerDate.js');
endif;
//echo $this->Minify->script('../js/jquery.fullpage.extensions.min.js');
echo $this->Minify->script('../js/bootstrap-toggle.min.js');
//echo $this->Minify->css('../css/jquery.fullpage.min.css');
echo $this->Minify->script('../js/jquery.inputmask.min.js');
if (!isset($removeScripts)) {
    echo $this->Minify->script('../js/custom.js?v=1.1');
}
if ($isAdmin):
//echo $this->Minify->script('../js/froala_editor.min.js');
//echo $this->Minify->script('../js/code_view.min.js');
//echo $this->Minify->css('froala_editor.min.css');
//echo $this->Minify->css('froala_style.min.css');
    ?>
    <?php /* <script>
      jQuery(function() {
      jQuery('.wysiwyg').froalaEditor();
      });
      </script> */ ?>
<?php endif; ?>
<?php
if (!isset($removeScripts)) {
// Timeline
echo $this->Minify->css('timeline.css');

echo $this->Minify->script('jquery.optionTree.js');
}
?>
<script type="text/javascript">
    $(document).ready(function () {

        $('input.daterange').daterangepicker({
            //startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            //minDate: '01/01/2012',
            //maxDate: '12/31/2015',
            //dateLimit: { days: 60 },
            showDropdowns: false,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: false,
            ranges: {
                '<?php echo __('Today'); ?>': [moment(), moment()],
                '<?php echo __('Yesterday'); ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '<?php echo __('Last 7 Days'); ?>': [moment().subtract(6, 'days'), moment()],
                        '<?php echo __('Last 30 Days'); ?>': [moment().subtract(29, 'days'), moment()],
                        '<?php echo __('This Month'); ?>': [moment().startOf('month'), moment().endOf('month')],
                        '<?php echo __('Last Month'); ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-xs btn-primary',
            cancelClass: 'btn-xs',
            format: 'YYYY-MM-DD',
            separator: ' - ',
            locale: {
                applyLabel: '<?php echo __('OK'); ?>',
                cancelLabel: '<?php echo __('Cancel'); ?>',
                fromLabel: '<?php echo __('From'); ?>',
                toLabel: '<?php echo __('To'); ?>',
                customRangeLabel: '<?php echo __('Custom'); ?>',
                daysOfWeek: ['<?php echo __('Su'); ?>', '<?php echo __('Mo'); ?>', '<?php echo __('Tu'); ?>', '<?php echo __('We'); ?>', '<?php echo __('Th'); ?>', '<?php echo __('Fr'); ?>', '<?php echo __('Sa'); ?>'],
                monthNames: ['<?php echo __('January'); ?>', '<?php echo __('February'); ?>', '<?php echo __('March'); ?>', '<?php echo __('April'); ?>', '<?php echo __('May'); ?>', '<?php echo __('June'); ?>', '<?php echo __('July'); ?>', '<?php echo __('August'); ?>', '<?php echo __('September'); ?>', '<?php echo __('October'); ?>', '<?php echo __('November'); ?>', '<?php echo __('December'); ?>'],
                firstDay: 1
            }
        });
    });
</script>

<?php
echo $this->element('Summernote.summernote', array(
    // CSS selector
    'selector' => '.wysiwyg',
    // Options
    'options' => "{
            height: 400,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            toolbar: [
                // [groupname, [button list]]

                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['misc', ['codeview']],
    ['insert', [ 'picture']],
    ['link', ['linkDialogShow', 'unlink']]
    

            ],
            lang: 'pl-PL',
            // Hidden required textarea fix
            onkeyup: function(e) {
                $(this).parent().prev().html($(this).code());
            }
        }",
    // Language files
    'language' => array('en-EN')
));
?>
<?php //if (!($this->params['controller'] == 'engines') and ! ( $this->params['action'] == 'filter')) : ?>
<script type="text/javascript">
    $(document).ready(function () {
        //        $(".select2").select2({
        //            allowClear: true
        //        });
        $('.datepicker').datepicker({
            format: "dd.mm.yyyy",
            autoclose: true,
            todayHighlight: true,
            language: "<?php echo Configure::read('Config.language'); ?>",
        });

        $('.datepicker-max-18,.datepicker-max-2018').datepicker({
            format: "dd.mm.yyyy",
            autoclose: true,
            endDate: "31.12.2018",
            todayHighlight: true,
            language: "<?php echo Configure::read('Config.language'); ?>",
        });
        $('.datepicker-max-19,.datepicker-max-2019').datepicker({
            format: "dd.mm.yyyy",
            autoclose: true,
            endDate: "31.12.2019",
            todayHighlight: true,
            language: "<?php echo Configure::read('Config.language'); ?>",
        });
        $('.datepicker-max-20,.datepicker-max-2020').datepicker({
            format: "dd.mm.yyyy",
            autoclose: true,
            endDate: "31.12.2020",
            todayHighlight: true,
            language: "<?php echo Configure::read('Config.language'); ?>",
        });
        /*$('.noyearpicker,.noyearpicker-2018').datepicker({
         format: "dd.mm.",
         autoclose: true,
         todayHighlight: false,
         endDate: "31.12.2018",
         language: "<?php echo Configure::read('Config.language'); ?>",
         });*/

        /*$('.noyearpicker-2019').datepicker({
         format: "dd.mm.",
         autoclose: true,
         todayHighlight: false,
         endDate: "31.12.2019",
         language: "<?php echo Configure::read('Config.language'); ?>",
         });*/
        $('.noyearpicker-2020-backup').datepicker({
            format: "dd.mm.",
            autoclose: true,
            todayHighlight: false,
            endDate: "31.12.2020",
            language: "<?php echo Configure::read('Config.language'); ?>",
        });
        $('.datetimepicker').datetimepicker({
            format: "yyyy-mm-dd hh:ii:ss",
            autoclose: true,
            todayHighlight: true,
            language: "<?php echo Configure::read('Config.language'); ?>",
        });

        $('.yearpicker').datepicker({
            rtl: App.isRTL(),
            format: ' yyyy',
            viewMode: 'years',
            minViewMode: 'years'
        });

        $(".clone").click(function () {
            //console.log($(this));
            var parent = $(this).parent().parent().parent();
            var clone = parent.prevAll('.clonable:last').clone();
            //console.log(clone);
            clone.removeClass('clonable');
            if (clone.hasClass('hidden')) {
                clone.removeClass('hidden');
            }
            clone.css('display', 'none');
            clone.insertBefore(parent);
            clone.slideDown("slow");
            return false;
        });

        $(".ajaxdelete").click(function (e) {
            //e.preventDefault();
            if (confirm('<?php echo __('Are you sure?'); ?>')) {
                var container = $(this).closest('div');
                $.ajax({
                    url: $(this).attr('href'),
                    cache: false,
                    type: 'POST',
                    dataType: 'HTML',
                    success: function (data) {
                        //console.log($(this));
                        container.fadeOut('fast', function () {
                            container.remove();
                        });
                        //$('#success').html(data);
                    }
                });
            }
            return false;
        });

        $(".ajaxaction").click(function (e) {
            //e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                cache: false,
                type: 'POST',
                dataType: 'HTML',
                success: function (data) {
                    alert('<?php echo __('Success'); ?>');
                }
            });
            return false;
        });

        // Magnific Popup
        <?php if (!isset($removeScripts)): ?>
        $('a.thumbnail').magnificPopup({
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            gallery: {
                // options for gallery
                enabled: true
            }
            // other options
        });
        <?php endif; ?>

        $("[type='checkbox2']").bootstrapSwitch({
            size: 'mini',
            onColor: 'danger'
        });
<?php if (!$isAdmin): ?>
            jQuery(".select2").select2({
                theme: 'bootstrap'
            });
<?php endif; ?>

    });
</script>
<?php //endif;  ?>
<?php
// GLOBAL MANDATORY STYLES
echo $this->Html->css('../assets/global/plugins/font-awesome/css/font-awesome.min.css');
if (!isset($removeScripts)) {
echo $this->Html->css('../assets/global/plugins/simple-line-icons/css/simple-line-icons.css');
}
echo $this->Html->css('../assets/global/plugins/bootstrap/css/bootstrap.min.css');
echo $this->Html->css('../assets/global/plugins/uniform/css/uniform.default.css');
echo $this->Html->css('../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
if (!isset($removeScripts)) {
echo $this->Html->css('../assets/global/plugins/datatables/datatables.min.css');
echo $this->Html->css('../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
}
echo $this->Html->css('../assets/global/plugins/select2/css/select2.min.css');
echo $this->Html->css('../assets/global/plugins/select2/css/select2-bootstrap.min.css');
if (!isset($removeScripts)) {
echo $this->Html->css("../assets/global/plugins/bootstrap-toastr/toastr.min.css");
echo $this->Html->css('../assets/global/plugins/dropzone-4.3.0/dist/min/dropzone.min.css');
echo $this->Html->css('../assets/global/plugins/dropzone-4.3.0/dist/min/basic.min.css');
echo $this->Html->css('../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.standalone.css');
echo $this->Html->css('../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
echo $this->Html->css('../css/jquery-bootstrap-datepicker.css');
echo $this->Html->css('../assets/pages/css/pricing.min.css');
echo $this->Html->css('../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
echo $this->Html->css('../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
echo $this->Html->css('../assets/global/plugins/jstree/dist/themes/default/style.min.css');
}
// THEME GLOBAL STYLES
if (!isset($removeScripts)) {
echo $this->Html->css('../assets/global/css/components.min.css', array('id' => 'styleco_components'));
echo $this->Html->css('../assets/global/css/plugins.min.css');
}
if (AuthComponent::user() && ($isAdmin)) {
    echo $this->Html->css("../assets/layouts/layout2/css/layout.min.css");
    echo $this->Html->css("../assets/layouts/layout2/css/themes/blue.min.css", array('id' => 'style_color'));
    echo $this->Html->css("../assets/layouts/layout2/css/custom.min.css");
} else {
    echo $this->Html->css('../assets/pages/css/login.min.css');
}

//echo $this->Minify->script('../FooTable2/js/footable.js');
if (!isset($removeScripts)) {
    echo $this->fetch('dataTableSettings');
    echo $this->fetch('script');
}
// CUSTOM CSS
//echo $this->Minify->script('../js/star-rating.min.js');
//echo $this->Minify->css('star-rating.min.css');
if (isset($adminView)) {
    echo $this->Minify->css('frontend-custom.css?v=1.139999399');
    //echo $this->Minify->script('../js/custom_frontend.js?v=1.28');
}
if (!$isAdmin) {
    ?>

    <?php /* <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113156063-1"></script>
      <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-113156063-1');
      </script> */ ?>

    <?php
    if (!isset($removeScripts)) {
        echo $this->Minify->css('../owl/owl.carousel.css');
        echo $this->Minify->css('../owl/owl.theme.css');
        echo $this->Minify->script('../owl/owl.carousel.min.js');
        echo $this->Minify->script('../js/clipboard.min.js');
        echo $this->Minify->script('../js/custom_frontend.js?v=1.369');
    }
    echo $this->Minify->css('frontend-custom.css?v=1.1399951112');
} else {
    
    echo $this->Minify->css('std.css?v=1.1');
}

if (Configure::read('App.brand.css')) {
    echo $this->Minify->css(Configure::read('App.brand.css'));
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("form").validate();
    });
</script>

<?php
echo $this->Minify->css('daterangepicker.css');
echo $this->Minify->script('../js/daterangepicker.min.js');
?>



