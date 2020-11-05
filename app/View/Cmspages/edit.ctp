<div class="cmspages form">

    <?php echo $this->element('page_bar'); ?>
    <div class="row">


        <div class="col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase"><?php echo __('Edytuj wpis'); ?></span>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Podstawowe dane</a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab" aria-expanded="true">Sekcje</a>
                        </li>
                        <?php /*<li class="">
                            <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">galeria</a>
                        </li>*/ ?>

                    </ul>
                </div>
                <div class="portlet-body">

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="portlet-body form">

                                <?php echo $this->Form->create('Cmspage', array('type' => 'file')); ?>

                                <div class="form-body">
                                    <div class="row">
                                        <?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => __('Id'), 'div' => false)); ?>

                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('Tytuł'), 'div' => false)); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-5 hide">
                                            <div class="form-group">
                                                <?php echo $this->Form->input('Pagegroup', array('class' => 'form-control select2', 'data-placeholder' => 'wybierz', 'label' => __('Wybierz kategorię'), 'placeholder' => __('Modified'))); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <?php echo $this->Form->input('loggedonly', array('type' => 'checkbox', 'class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('Tylko dla zalogowanych'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="clearfix gap30"></div>
                                        <div class="col-sm-12">
                                            <hr  class="clearfix" />
                                        </div>
                                        <div class="clearfix gap30"></div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                              
                                                <?php echo $this->Form->input('menu', array('class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('Wyświetlaj w menu'), 'div' => false)); ?>
                                            </div>
                                            <div class="form-group">
                                                
                                                <?php echo $this->Form->input('footer', array('class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('Wyświetlaj w stopce'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <?php echo $this->Form->input('position', array('class' => 'form-control', 'placeholder' => __('pozycja'), 'label' => __('Pozycja'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <?php echo $this->Form->input('homepage', array('class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('Strona główna'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Wyświetl formularz kontaktowy</label>
                                                <?php echo $this->Form->input('contactform', array('class' => 'form-control', 'placeholder' => __('Tytuł'), 'label' => __('formularz kontaktowy'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="clearfix gap30"></div>
                                        <div class="col-sm-12">
                                            <hr  class="clearfix" />
                                        </div>
                                        <div class="clearfix gap30"></div>
                                        <div class="col-sm-12">
                                            <div class="form-group std-rte">
                                                <?php echo $this->Form->input('content', array('class' => 'form-control wysiwyg', 'placeholder' => __('Content'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12"><p class="info"><?php echo __('Zdjęcie główne'); ?></p></div>
                                        <div class="clearfix"></div>
                                        <?php if ($cmspage['Cmspage']['image']): ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">                              
                                                    <div class="small-image"><?php echo $this->Html->image($cmspage['Cmspage']['image'], array('class' => 'img-responsive main-logo')); ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <?php echo $this->Form->input('fooderimage', array('type' => 'file', 'label' => 'Dodaj/Zmień Zdjęcie głowne', 'class' => 'form-control', 'placeholder' => __('Logo'), 'div' => false)); ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12">
                                            <div class="form-group std-rte">
                                                <?php echo $this->Form->input('bannertext', array('class' => 'form-control wysiwyg', 'placeholder' => __('Content'), 'label' => 'Treść banera', 'div' => false)); ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions">
                                    <?php echo $this->Form->submit(__('Save'), array('style' => 'display:inline-block;', 'class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>
                                    <?php echo $this->Html->link(__('Cancel'), array(/* 'admin' => $this->request->params['admin'], */'action' => 'index'), array('style' => 'display:inline-block;', 'class' => 'btn default', 'escape' => FALSE)); ?>
                                </div>
                                <?php echo $this->Form->end() ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_3">
                            <?php echo $this->Form->create('Cmspage', array('type' => 'file', 'url' => array('controller' => 'cmspages', 'action' => 'edit'))); ?>

                            <div class="form-body">

                                <?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => __('Id'), 'div' => false)); ?>
                                <?php echo $this->Form->input('sections_update', array('type' => 'hidden', 'class' => 'form-control', 'placeholder' => __('Id'), 'div' => false)); ?>
                                <?php for ($i = 0; $i < 10; $i++): ?>
                                    <div class="row"> 
                                        <div class="col-sm-8">
                                            <div class="form-group std-rte">
                                                <?php echo $this->Form->input('sections_' . $i, array('type' => 'textarea', 'class' => 'form-control wysiwyg', 'placeholder' => __('Tytuł'), 'label' => __('Sekcja nr') . ($i + 1), 'div' => false)); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group std-rte">
                                                   <?php
                            echo $this->Form->input('class_' . $i, array(
                                'options' => Configure::read('App.cmspageSectionClass'),
                                'empty' => true,
                                'label' => __('Wygląd sekcji nr') . ($i + 1),
                              
                                'required' => false,
                                'class' => 'form-control select2', 'div' => false
                            ));
                            ?> 
                                             
                                            </div>
                                            <div class="form-group">
                                                     <?php echo $this->Form->input('image_'.$i, array('type' => 'file', 'label' => 'Zdjęcie do sekcji', 'class' => 'form-control', 'placeholder' =>false, 'div' => false)); ?>
                                           <?php if (isset($this->request->data['Cmspage']['image_'.$i]) && $this->request->data['Cmspage']['image_'.$i]): ?>
                                            <div class="col-sm-6">
                                                <div class="form-group">                              
                                                    <div class="small-image"><?php echo $this->Html->image($this->request->data['Cmspage']['image_'.$i], array('class' => 'img-responsive main-logo')); ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="form-actions">
                                <?php echo $this->Form->submit(__('Save'), array('style' => 'display:inline-block;', 'class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>
                                <?php echo $this->Html->link(__('Cancel'), array(/* 'admin' => $this->request->params['admin'], */'action' => 'index'), array('style' => 'display:inline-block;', 'class' => 'btn default', 'escape' => FALSE)); ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_2">


                            <?php echo $this->Form->create('Cmspage', array('type' => 'file', 'url' => array('controller' => 'cmspages', 'action' => 'gallery'))); ?>

                            <div class="form-body" style="padding: 0;">
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?php echo $this->Form->input('file.', array('type' => 'file', 'multiple' => true, 'label' => 'Dodaj zdjęcia', 'class' => 'form-control', 'placeholder' => __('galeria'), 'accept' => array('image/jpeg', 'image/png'), 'div' => false)); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label style="display: block;">&nbsp;</label>
                                            <?php echo $this->Form->submit(__('Save'), array('style' => 'display:inline-block;', 'class' => 'btn blue', 'div' => FALSE, 'after' => '')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php echo $this->Form->end() ?>

                            <div class="row" style="margin-top: 50px;margin-bottom: 50px;">
                                <?php foreach ($files as $key => $item): ?>
                                    <?php if ($key % 4 == 0): ?>
                                        <div class="clearfix gap30 hidden-xs"></div>
                                    <?php endif; ?>
                                    <div class="col-xs-6 col-sm-3 col-md-3 text-center gap30">
                                        <?php echo $this->Html->image('thumbs/gallery/' . $id . '/' . $item, array('class' => 'img-responsive main-logo gap5')); ?>
                                        <a href="#" class="btn btn-lg red delete-photo"><i class="fa fa-trash-o"></i> Usuń</a>
                                        <span class="confirmation hide"><span class="vcenter" style="font-size: 13px;font-weight: 300;margin-right: 5px;">Czy napewno usunąć?</span><a href="#" data-name="<?php echo $item; ?>" data-id="<?php echo $id; ?>" class="vcenter btn btn-md green delete-photo-confirm">TAK</a><a href="#"  class="vcenter btn btn-md red delete-photo-no">NIE</a></span>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).on("click", ".delete-photo", function (e) {
        e.preventDefault();
        jQuery(this).addClass('hide');
        jQuery(this).next().removeClass('hide');
    });
    jQuery(document).on("click", ".delete-photo-no", function (e) {
        e.preventDefault();
        console.log(jQuery(this).parent());
        jQuery(this).parent().addClass('hide');
        jQuery(this).parent().parent().find('.delete-photo').removeClass('hide');
    });

    jQuery(document).on("click", ".delete-photo-confirm", function (e) {
        e.preventDefault();
        jQuery('.loading-content').fadeIn(200);
        var thisElement = jQuery(this);
        var dataId = jQuery(this).attr('data-id');
        var dataname = jQuery(this).attr('data-name');
        var url = '<?php echo $this->request->webroot ?>ajax/deletephoto/';

        jQuery.ajax({
            type: "POST",
            url: url,
            data: {name: dataname, id: dataId}
        })
                .done(function (response, status, xhr) {
                    if (status === "success") {


                        var data = jQuery.parseJSON(response);
                        if (data.status) {
                            thisElement.parent().parent().remove();
                            jQuery('.loading-content').fadeOut(200);
                        } else {
                            jQuery('.loading-content').fadeOut(200);
                        }
                        console.log(jQuery.parseJSON(response));

                        jQuery('.loading-content').fadeOut(200);


                    }
                    if (status === "error") {

                        jQuery('.loading-content').fadeOut(300);
                    }

                });

    });
</script>


