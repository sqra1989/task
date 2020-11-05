<?php echo $this->Form->create('Contactform', array('role' => 'form', 'id' => 'contactform', 'url' => array('controller' => 'ajax', 'action' => 'contactform_quick'))); ?>
<?php echo $this->Form->input('topic', array('type' => 'hidden', 'class' => 'form-control', 'value' => $subject, 'required' => false, 'label' => false, 'placeholder' => __('Temat'), 'label' => 'Temat', 'div' => false)); ?>
<?php echo $this->Form->input('email', array('type' => 'hidden', 'value' => $email, 'class' => 'form-control', 'required' => false, 'label' => false, 'placeholder' => __('Wpisz swój email'), 'label' => 'E-mail <sup>*</sup>', 'div' => false)); ?>
<div class="form-actions text-center">
    <?php echo $this->Form->submit(__('Zapytaj o pomoc'), array('style' => 'display:inline-block;', 'class' => 'btn btn-default btn-xs', 'div' => FALSE, 'after' => '')); ?>
</div>

<?php echo $this->Form->end(); ?>

<div id="contact-alert" class="alert" style="display: none;"></div>
<script>

    jQuery("#contactform").submit(function (e) {
        e.preventDefault();
        jQuery('.loading-content').show();
        jQuery('#contact-alert').hide();
        jQuery('.field-alert').hide();
        var url = jQuery(this).attr('action');
        var frm = jQuery(this);
        var data = {};
        jQuery.ajax({
            url: url,
            type:'POST',
            data: frm.serialize(),
            success: function (mydata) {
                var data = jQuery.parseJSON(mydata);
                if (data.status) {
                    jQuery('#contact-alert').removeClass('alert-danger');
                    jQuery('#contact-alert').addClass('alert-success');
                    jQuery('#contact-alert').html(data.message);
                    jQuery('#contact-alert').slideDown(200);
                    frm.slideUp(200);
                    jQuery('.loading-content').fadeOut(200);

                } else {
                    jQuery('#contact-alert').removeClass('alert-success');
                    jQuery('#contact-alert').addClass('alert-danger');

                    /* jQuery.each(data.errors, function (key, value) {
                     jQuery('#' + key).text(value);
                     jQuery('#' + key).slideDown(100);
                     });*/
                    jQuery('#contact-alert').html(data.message);
                    console.log(data.errors);
                    jQuery('#contact-alert').slideDown(200);
                    jQuery('.loading-content').fadeOut(200);
                }

            }
        });
    });
</script>
