
<div class="breadcrumb">
    <div class="container">
        <ul>
            <li> <?php echo $this->Html->link(__('Strona główna'), array('controller' => 'index', 'action' => 'index'), array('class' => '', 'escape' => false)); ?></li>
            <li><strong><?php echo $cmspage['Cmspage']['title']; ?></strong></li>
        </ul>
    </div>
</div>
<div class="<?php if (Configure::read('App.etap') == 1): ?> container grid-gap no-padding-top <?php endif; ?> std <?php if (Configure::read('App.etap') == 2): ?> std-rte <?php endif; ?>">
    <div class="container  <?php if (!$cmspage['Cmspage']['sections']): ?>grid-gap<?php endif; ?>">
        <?php $variable = new AppController(); ?>

        <?php if ($cmspage['Cmspage']['imagebig']): ?>
            <div class="banner-article ">
                <?php echo $this->Html->image($cmspage['Cmspage']['imagebig'], array('class' => 'img-responsive full-img')); ?>
                <div class="meta">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="content">
                                    <?php if ($cmspage['Pagegroup'][0]) { ?>

                                        <span><?php echo $variable->getDateFormatted($cmspage['Cmspage']['created']); ?></span>
                                    <?php } ?>
                                    <h1><?php echo $cmspage['Cmspage']['title']; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if ($cmspage['Cmspage']['sections']): ?>
            <?php foreach (unserialize($cmspage['Cmspage']['sections']) as $key => $item): ?>





                <?php if ($item['sections'] && $item['sections'] != ''): ?>




                    <div id="section-id-<?php echo $key; ?>" class="cms-section std cms-section-<?php echo $key; ?> <?php echo $item['class']; ?>">
                        <?php if ($item['class'] == 'section-right' || $item['class'] == 'section-left'): ?>
                            <div class="row">

                                <div class="col-sm-6 col-content">
                                    <?php echo $item['sections']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php if (isset($item['image']) && $item['image']): ?>
                                        <?php echo $this->Html->image($item['image'], array('class' => 'img-responsive')); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($item['class'] == 'section-mobile-app'): ?>
                            <div class="row">

                                <div class="col-sm-6 col-content">
                                    <?php echo $item['sections']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php if (isset($item['image']) && $item['image']): ?>
                                        <?php echo $this->Html->image($item['image'], array('class' => 'img-responsive')); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($item['class'] == 'section-price'): ?>
                            <div class="price-content">
                                <?php echo $item['sections']; ?>
                            </div>
                        <?php elseif ($item['class'] == 'section-faq'): ?>
                            <?php $temp = str_replace('<p>', '<div class="question-answer"><p>', $item['sections']); ?>
                            <?php $temp = str_replace('</p>', '</p></div>', $temp); ?>
                            <?php echo $temp; ?>

                        <?php else: ?>

                            <?php echo $item['sections']; ?>
                            <?php if (isset($item['image']) && $item['image']): ?>
                                <?php echo $this->Html->image($item['image'], array('class' => 'img-responsive')); ?>

                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>


        <?php if ($cmspage['Cmspage']['content'] != ''): ?>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div id="default-page">
                        <?php echo $cmspage['Cmspage']['content']; ?>
                    </div>
                </div>
            </div>
            <div class="clearfix gap15"></div>

        <?php endif; ?>
      



   
    </div>
</div>

