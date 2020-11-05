<!DOCTYPE html>
<?php if (!isset($_GET['only-content'])): ?>
    <html>
        <head>
            <?php echo $this->element('head'); ?>
            <script type="text/javascript"><?php echo $this->Blocks->get("top_js"); ?></script>
        </head>

        <?php
        switch ($this->request['controller']) {
            case 'users':
                switch ($this->request['action']) {
                    case 'register':
                    case 'lostpassword':
                    case 'changepassword':
                        $bodyClass = 'login';
                        break;
                    default:
                        $bodyClass = $this->request['controller'] . '-' . $this->request['action'] . ' ' . $this->request['action'] . ' ' . $auth['Role']['symbol'] . ' page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid';
                        break;
                }
                break;
            default:
                $bodyClass = $this->request['controller'] . '-' . $this->request['action'] . ' ' . $this->request['action'] . ' ' . $auth['Role']['symbol'] . ' page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid';
                break;
        }
        ?>
 <?php /*if(!$auth || (isset($auth['id']) && !in_array($auth['id'],Configure::read('App.blockSourceView')))): ?>
        
<script type="text/javascript">
     /*jQuery(document).bind("contextmenu",function(e) {
 e.preventDefault();
});
jQuery(document).keydown(function (event) {
    if (event.keyCode == 123) { // Prevent F12
        return false;
    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
        return false;
    }
    if(event.ctrlKey && (event.which == 83)) {
        return false;
    }
    if (event.ctrlKey && (event.keyCode === 67 || event.keyCode === 86 || event.keyCode === 85 || event.keyCode === 117)) {//Alt+c, Alt+v will also be disabled sadly.
                return false
    }
    if (event.keyCode == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                   return false
    }
});
</script>
<?php endif;*/ ?>
        <body class="<?php if(isset($b2bMode) && $b2bMode): ?> b2b <?php endif; ?><?php if (isset($fullPage) && $fullPage): ?> fullpage <?php endif; ?> <?php if ($this->request['controller'] == 'index' && $this->request['action'] == 'index'): ?>onepage <?php endif; ?><?php echo $bodyClass; ?>">
            <?php echo $this->Session->flash(); ?>
        <?php endif; //$_GET['only-content'] ?>
        <div class="page-wrapper">
            <?php if ((AuthComponent::user() && $auth['Role']['symbol'] == 'admin') || (AuthComponent::user() && $auth['Role']['symbol'] == 'superadmin')) : ?>

                <?php echo $this->Element('page_header'); ?>
                <div class="clearfix"> </div>
                <div class="page-container">        
                    <div class="page-sidebar-wrapper">
                        <?php
                        if ($this->elementExists('page_sidebar_' . $auth['Role']['symbol'])) {
                            echo $this->Element('page_sidebar_' . $auth['Role']['symbol']);
                        }
                        ?>
                    </div>
                    <div class="page-content-wrapper">
                        <div class="page-content">
                            <div class="page-maxwidth">
                                <?php // echo $this->Element('theme_panel');  ?>
                                <?php // echo $this->Element('page_bar');   ?>

                                <?php
                                // Main content
                                ?>

                                <?php echo $this->fetch('content'); ?>

                                <?php
                                // Additional content
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php // echo $this->Element('navigation');   ?>
            <?php else: ?>



                <?php echo $this->Element('page_header_user'); ?>


                <?php if (($this->request['controller'] != 'questionnaries' && $this->request['action'] != 'edit')): ?>
                    <div class="main-page-content not-logged user-logged">
                    <?php endif; ?>
                    <div id="flashMsg" class="">
                        <?php echo $this->Session->flash(); ?>
                    </div> 
                    <!--</a>-->
                    <?php echo $this->fetch('content'); ?>
                    <?php //echo $this->Facebook->like(array('href' => Router::url('/', TRUE), 'layout' => 'button_count'));    ?>
                    <?php if (($this->request['controller'] != 'questionnaries' && $this->request['action'] != 'edit')): ?>
                    </div>
                <?php endif; ?>
                <div class="not-section">
                    <div class="page-footer ">
                        <div class="container">
                            <ul>
                                <li><a class="" href="<?php echo $this->Html->url(array('controller' => 'index', 'action' => 'index')); ?>"> <?php echo __('Strona główna'); ?></a></li>

                                <?php foreach ($footerCms as $item): ?>
                                    <li><a href="<?php echo $this->Html->url(array('controller' => 'cmspages', 'action' => 'view', 'id' => $item['Cmspage']['id'], 'slug' => $item['Cmspage']['url'])); ?>"><?php echo $item['Cmspage']['title']; ?></a></li>

                                <?php endforeach; ?>
                                <?php if (!$auth): ?>
                                    <li><a class="" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'register')); ?>"> <?php echo __('Rejestracja'); ?></a></li>

                                    <li><a class="more goto" href="#logowanie"> <?php echo __('Logowanie'); ?></a></li>
                                <?php else: ?>
                                    <li><a class="" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logouts')); ?>"> <?php echo __('Wyloguj'); ?></a></li>

                                    <li><a class="" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'user_profile')); ?>"> <?php echo __('Moje konto'); ?></a></li>

                                <?php endif; ?>
                            </ul>

                        </div>

                        <div class="page-footer-inner">© <?php echo date('Y'); ?> <?php echo Configure::read('App.name'); ?> |<br class="visible-xs"/> <a href="https://agencja-interaktywna.opole.pl" target="_blank" title="agencja marketingu zintegrowanego">itDesk</a> </div>   
                    </div> 
                </div>
                 <?php if (Configure::read('App.blockCreatingForms')): ?>
                 <?php echo $this->element('modal'); ?>
                <?php endif; ?>
                <div class="loading-type"><span>Zmiana typu rozliczenia...<br/><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span></div>
                <div class="loading-content"><span>Proszę chwilkę poczekać...<br/><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span></div>
                <div class="loading-form-checker"><span>Sprawdzam wniosek...<br/><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span></div>
                <?php if (!isset($_COOKIE['cookie-popup'])): ?>
                    <div class="cookie-popup">
                        <div class="content">[[block cookies]]<a href="#" class="accept">Akceptuję</a></div>
                    </div>
                <?php endif ?>
            <?php endif; ?>
            <?php if (AuthComponent::user() && ($auth['Role']['symbol'] == 'admin' || $auth['Role']['symbol'] == 'superadmin')) : ?>      
                <div class="page-footer">
                    <div class="page-footer-inner"> © <?php echo date('Y'); ?> <?php echo Configure::read('App.name'); ?> |<br class="visible-xs"/> Projekt i wykonanie: itDesk</div>   
                </div> 
                <div class="scrollToTop">
                    <i class="icon-arrow-up"></i>
                </div>
                <div class="loading-content"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
            <?php else: ?>
                <?php if (($this->request['controller'] != 'index' && $this->request['action'] != 'index') && ($this->request['controller'] != 'users' && $this->request['action'] != 'login')): ?>
                    <?php
                    $params = $this->Paginator->params();
                    if ($params['pageCount'] > 1) {
                        ?>
                        <div class="container grid-gap no-margin-top text-center">
                            <ul class="pagination pagination-sm">
                                <?php
                                if ($params["pageCount"] > 2) {
                                    //echo $this->Paginator->first(__('<-'));
                                }
                                echo $this->Paginator->prev('<i class="fa fa-caret-left"></i>', array('class' => 'prev', 'tag' => 'li', 'escape' => false), '<i class="fa fa-caret-left"></i>', array('class' => 'prev disableds', 'tag' => 'li', 'escape' => false));
                                echo $this->Paginator->numbers(array('modulus' => 8, 'separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
                                echo $this->Paginator->next('<i class="fa fa-caret-right"></i>', array('class' => 'next', 'tag' => 'li', 'escape' => false), __('') . '<i class="fa fa-caret-right"></i>', array('class' => 'next disabled', 'tag' => 'li', 'escape' => false));
                                if ($params["pageCount"] > 2) {
                                    //echo $this->Paginator->last(__('->'));
                                }
                                ?>
                            </ul>
                        </div>
                    <?php } ?>        


                <?php endif; ?>   
            <?php endif; ?> 

            <?php
            // GLOBAL SCRIPTS
            echo $this->Minify->script("../assets/global/plugins/bootstrap/js/bootstrap.min.js");
            if (!( $this->params['action'] == 'filter')) :
                echo $this->Minify->script("../assets/global/plugins/js.cookie.min.js");
                echo $this->Minify->script("../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js");
                echo $this->Minify->script("../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js");
                echo $this->Minify->script("../assets/global/plugins/jquery.blockui.min.js");
                echo $this->Minify->script("../assets/global/plugins/uniform/jquery.uniform.min.js");
                echo $this->Minify->script("../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js");
            endif;
            echo $this->Minify->script("../assets/global/plugins/jquery-validation/js/jquery.validate.min.js");
            echo $this->Minify->script("../assets/global/plugins/jquery-validation/js/additional-methods.min.js");

            echo $this->Minify->script("../assets/global/plugins/select2/js/select2.full.min.js");

            echo $this->Minify->script("../assets/global/scripts/app.js");
            if (!( $this->params['action'] == 'filter')) :
                echo $this->Minify->script("../assets/layouts/layout2/scripts/layout.min.js");
                echo $this->Minify->script("../assets/layouts/layout2/scripts/demo.js");
                echo $this->Minify->script("../assets/layouts/global/scripts/quick-sidebar.min.js");

                echo $this->Minify->script("../assets/global/scripts/datatable.min.js");
                echo $this->Minify->script("../assets/global/plugins/datatables/datatables.min.js");
                echo $this->Minify->script("../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js");
            endif;
            if ($isAdmin) {
                echo $this->Minify->script("../assets/pages/scripts/components-select2.js");
            }
            if (!($this->params['controller'] == 'engines') and ! ( $this->params['action'] == 'filter')) :
                echo $this->Minify->script("../assets/global/plugins/dropzone-4.3.0/dist/min/dropzone.min.js");
                echo $this->Minify->script("../assets/global/plugins/jquery-md5/jquery.md5.js");

                echo $this->Minify->script("../assets/pages/scripts/components-bootstrap-switch.min.js");

                echo $this->Minify->script("../assets/global/plugins/bootstrap-toastr/toastr.min.js");
                echo $this->Minify->script("../assets/pages/scripts/ui-toastr.min.js");

                echo $this->Minify->script("../assets/global/plugins/jstree/dist/jstree.min.js");

                echo $this->Minify->script("../assets/global/plugins/uniform/jquery.uniform.min.js");

                echo $this->Minify->script("../assets/global/plugins/jquery-ui/jquery-ui.min.js"); // TODO: Confilct with DatePicker.

                echo $this->Minify->script("../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js");
                echo $this->Minify->script("../assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker." . Configure::read('Config.language') . ".min.js");
//        echo $this->Minify->script("../assets/pages/scripts/components-date-time-pickers.js");
                echo $this->Minify->script("../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js");
                echo $this->Minify->script("../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");
//        echo $this->Minify->script("../assets/pages/scripts/components-date-time-pickers.js");
                echo $this->Minify->script("../assets/layouts/global/scripts/quick-sidebar.min.js");
            endif;
//        echo $this->Minify->script("../assets/pages/scripts/ecommerce-products.js");
            ?>
            <script type="text/javascript">
<?php /* if (!isset($_GET['only-content'])): ?>
  jQuery(document).ready(function () {
  jQuery('.select2sadsad').select2({
  placeholder: "Wybierz",
  empty: true
  }).on("change", function () {
  console.log('clicked select2');
  jQuery('.loading-content').fadeIn(200);
  var value = jQuery(this).val();
  var level = parseInt(jQuery(this).parents('.ajax-itdeskfilters-item').attr('data-level'));
  getAjaxCategories(value, level);
  });
  });
  <?php endif; */ ?>
                /*function clearLevels(level) {
                 jQuery('.ajax-itdeskfilters-item').each(function () {
                 if (level <= (parseInt(jQuery(this).attr('data-level')) - 1)) {
                 jQuery(this).remove();
                 //console.log(level+' remove->'+parseInt(jQuery(this).attr('data-level')));
                 }
                 });
                 }*/

                function clearAjaxProducts() {
                    jQuery('#js-product-list .products.row').html('');
                }

                function insertProduct(data) {
                    //console.log(data);
                    var url = "<?php echo $this->webroot; ?>engines/singleproduct";
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: {data: data}
                    }).done(function (response, status, xhr) {
                        if (status === "success") {
                            //console.log(response);
                            var option = jQuery.parseJSON(response);
                            if (option.status) {
                                jQuery('#js-product-list .products.row').append(option.html);
                            }

                        }
                        if (status === "error") {

                        }
                    });
                }

                /*  function getAjaxCategories(value, level) {
                 var url = "<?php //echo $this->webroot;             ?>ajax/getlist";
                 jQuery.ajax({
                 type: "POST",
                 url: url,
                 data: {parent_id: value, level: level}
                 }).done(function (response, status, xhr) {
                 if (status === "success") {
                 clearLevels(level);
                 clearAjaxProducts();
                 level = level + 1;
                 var options = jQuery.parseJSON(response);
                 if (options.status) {
                 //add new level of categories
                 var html = '<div data-parentid="' + value + '" data-level="' + level + '" id="itdeskfilters-level-' + level + '" class="col-md-3 ajax-itdeskfilters-item"><label>' + options.label + '</label><select class="select2"></select></div>';
                 
                 if (jQuery('#itdeskfilters-level-' + level).length === 0) {
                 jQuery('.ajax-itdeskfilters').append(html);
                 }
                 
                 //console.log('before');
                 setSelectDataOptions(jQuery('#itdeskfilters-level-' + level + ' select'), options.subcategories);
                 jQuery('.loading-content').fadeOut(200);
                 } else {
                 if (options.products.length > 0) {
                 //jQuery.each(options.products, function (index, value) {
                 insertProduct(options.products);
                 // });
                 } else {
                 jQuery('#js-product-list .products.row').append('<div class="col-xs-12"><div class="alert alert-warning">Brak produktów spełniających wymagania</div></div>')
                 }
                 jQuery('.loading-content').fadeOut(200);
                 }
                 }
                 if (status === "error") {
                 jQuery('.loading-content').fadeOut(300);
                 }
                 });
                 }*/

                /*function setSelectDataOptions(select, data) {
                 //select.select2('destroy');
                 var id = select.val();
                 select.html('');
                 
                 if (data) {
                 $.each(data, function (index, value) {
                 
                 if (jQuery.type(value) === 'object') {
                 select.append('<option value="' + value.value + '">' + value.name + '</option>');
                 } else {
                 select.append('<option value="' + index + '">' + value + '</option>');
                 }
                 
                 
                 });
                 }
                 select.val(id);
                 select.select2({
                 placeholder: "<?php echo __('Wybierz'); ?>"
                 }).on("change", function () {
                 //console.log('changed ajax select2');
                 jQuery('.loading-content').fadeIn(200);
                 var value = jQuery(this).val();
                 var level = parseInt(jQuery(this).parents('.ajax-itdeskfilters-item').attr('data-level'));
                 getAjaxCategories(value, level);
                 
                 });
                 ;
                 }*/
            </script>
            <?php if (!isset($_GET['only-content'])): ?>    
                <script type="text/javascript">
                    //        function setSelectData(select, data) {
                    //            select.select2('destroy');
                    //            var id = select.val();
                    //            select.html('');
                    //            if (data) {
                    //                $.each(data, function (index, value) {
                    //
                    //                    select.append('<option value="' + index + '">' + value + '</option>');
                    //                });
                    //            }
                    //            select.val(id);
                    //            select.select2({
                    ////                allowClear: true
                    //            });
                    //        }

                    $(document).ready(function () {
                        $('.ajax-pagination').each(function () {
                            var model = $(this).attr('data-model');
                            var initUrl = $(this).attr('data-init-url');
                            if (initUrl !== undefined) {
                                $(this).load(initUrl, {model: model}, function () {
                                    $(this).fadeIn('slow');
                                });
                            }
                        });
                        $('.ajax-pagination').on('click', '.pagination a', function (event) {
                            event.preventDefault();
                            var thisHref = $(this).attr('href');
                            if (thisHref !== undefined) {
                                var parent = $(this).closest('.ajax-pagination');
                                var model = parent.attr('data-model');
                                parent.fadeTo(300, 0);
                                parent.load(thisHref, {model: model}, function () {
                                    parent.fadeTo(200, 1);
                                });
                            }
                            return false;
                        });
                    });

    <?php echo $this->Blocks->get("bottom_js"); ?>
                </script>
            </div>

            <?php if (($this->request['controller'] == 'users' && $this->request['action'] == 'register') || 
                    ($this->request['controller'] == 'users' && $this->request['action'] == 'user_profile') ||
                    ($this->request['controller'] == 'users' && $this->request['action'] == 'add') ||
                    ($this->request['controller'] == 'users' && $this->request['action'] == 'edit_b2b') 
                    ): ?>           
                <div id="custom_modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body std">

                            </div>
                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                            </div>
                        </div>

                    </div>
                </div>
                <script>
                    jQuery(document).on('click', '.form-group.register-list label a', function (e) {

                        var href = jQuery(this).attr('href');
                        e.preventDefault();
                        if (href == '' || href == "#") {

                            var html = jQuery(this).parents('label').html();
                            jQuery('#custom_modal .modal-body').html(html);
                            jQuery('#custom_modal').modal('show');
                            jQuery('html').addClass('no-scroll');
                        } else {
                            jQuery('#custom_modal .modal-body').load(href + ' #default-page');
                            jQuery('#custom_modal').modal('show');
                            jQuery('html').addClass('no-scroll');
                        }
                    });
                    jQuery(document).ready(function () {
                        jQuery('#custom_modal').on('hidden.bs.modal', function () {

                            jQuery('html').removeClass('no-scroll');
                        });
                    });
                </script>


            <?php endif; ?>          

        </body>
        <?php //echo $this->Facebook->init();     ?>
    </html>
<?php endif; // !isset($_GET['only-content'])): ?>
