<div class="row">
    <?php foreach ($assets as $asset) : ?>
        <div class="col-xs-12">
            <?php echo $this->element('product_special_row', array('product' => $asset)); ?>
        </div>
    <?php endforeach; ?>
</div>
<!--<p class="pagination-summary">-->
    <!--<small><?php // echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'))); ?></small>-->
<!--</p>-->

<?php
$params = $this->Paginator->params();
if ($params['pageCount'] > 1) {
    ?>
    <ul class="pagination">
        <?php
        if ($params["pageCount"] > 29) {
            echo $this->Paginator->first(__('First page'));
        }
        echo $this->Paginator->prev('<i class="fa fa-angle-left"></i>', array('model' => 'Asset', 'class' => 'prev', 'tag' => 'li', 'escape' => false), '<i class="fa fa-angle-left"></i>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
        echo $this->Paginator->numbers(array('modulus' => 9, 'separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
        echo $this->Paginator->next('<i class="fa fa-angle-right"></i>', array('model' => 'Asset', 'class' => 'next', 'tag' => 'li', 'escape' => false), '<i class="fa fa-angle-right"></i>', array('class' => 'next disabled', 'tag' => 'li', 'escape' => false));
        if ($params["pageCount"] > 29) {
            echo $this->Paginator->last(__('Last page'));
        }
        ?>
    </ul>
<?php }
