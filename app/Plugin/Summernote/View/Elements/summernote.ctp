<?php
// Summernote WYSIWYG
echo $this->Html->script(Router::url('/', TRUE) . 'Summernote/summernote-master/dist/summernote.min.js');
echo $this->Html->css(Router::url('/', TRUE) . 'Summernote/summernote-master/dist/summernote.css');
if (isset($language) and is_array($language)) {
    foreach ($language as $l) {
        if (file_exists(dirname(dirname(dirname(__FILE__))) . '/webroot/summernote-master/lang/summernote-' . $l . '.js')) {
            echo $this->Html->script(Router::url('/', TRUE) . 'Summernote/summernote-master/lang/summernote-' . $l . '.js');
        }
    }
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(<?php
        if (isset($selector) and is_string($selector)) {
            echo "'" . $selector . "'";
        } else {
            echo '.summernote';
        }
        ?>).summernote(
        <?php
        if (isset($options)) :
            echo $options;
        else :
            ?>
            {
                // Hidden required textarea fix
                onkeyup: function(e) {
                    $(this).parent().prev().html($(this).code());
                }
            }
        <?php
        endif;
        ?>
        );
        $(<?php
        if (isset($selector) and is_string($selector)) {
            echo "'" . $selector . "'";
        } else {
            echo '.summernote';
        }
        ?>).css('display', 'block').css('opacity', '0').css('height', '0').css('overflow', 'hidden').css('position', 'absolute');
    });
</script>