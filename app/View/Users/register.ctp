


<div class="content container main-content grid-gap">
    <div class="text-center ">
        <h3 class="gap50"><?php echo __('Nowe konto') ?></h3>
    </div>

    <div class="std">
        <div class="row">
            <div class="col-sm-12">
                <?php
                echo $this->Form->create('User');
                ?>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('name', array('label' => false, 'placeholder' => __('Imię') . ' *', 'label' =>false, 'class' => 'form-control', 'div' => false));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('surname', array('label' => false, 'placeholder' => __('Nazwisko') . ' *', 'class' => 'form-control', 'div' => false));
                    ?>
                </div>

                <div class="form-group">
                    <?php
                    echo $this->Form->input('email', array('label' => false, 'placeholder' => __('E-mail') . ' *', 'class' => 'form-control', 'div' => false));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('telefon', array('label' => false, 'placeholder' => __('Telefon'), 'class' => 'form-control', 'div' => false));
                    ?>
                </div>

                <div class="form-group">
                    <?php
                    echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'placeholder' => __('Password') . ' *', 'class' => 'form-control', 'div' => false));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('password2', array('type' => 'password', 'label' => false, 'placeholder' => __('Repeat password') . ' *', 'class' => 'form-control', 'div' => false));
                    ?>
                </div>
                <div class="form-group ">
                    <?php echo $this->Form->input('born', array('type' => 'text', 'class' => 'form-control datepicker', 'placeholder' => __('data urodzenia *'), 'label' => false, 'div' => FALSE)); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('type', array(
                        'options' => Configure::read('App.typkonta'),
                        'empty' => false,
                        'label' => __('Typ konta'),
                        'required' => false,
                        'class' => 'form-control type-conta', 'div' => false
                    ));
                    ?>
                </div>
                <div class="company-details" style="display: none;">
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('company', array('label' => false, 'placeholder' => __('Firma'), 'label' => __('Firma'), 'class' => 'form-control', 'div' => false));
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('nip', array('label' => false, 'placeholder' => __('NIP'), 'label' => __('NIP'), 'class' => 'form-control', 'div' => false));
                        ?>
                    </div>
                </div>



                <div class="clearfix"></div>
                <div class="form-actions text-center gap60">
                    <?php echo $this->Form->button(__('Zarejestruj się'), array('class' => 'btn btn-default')); ?>

                </div>
                <div class="text-center"><p> <?php echo $this->Html->link(__('Powrót do logowania'), array('action' => 'login'), array('class' => 'btn btn-info')); ?></p></div>



            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).on('change', '.type-conta', function () {
        if (jQuery('.type-conta option:selected').val() === 'b2b') {
            jQuery('.company-details').show();
        } else {
            jQuery('.company-details').hide();
        }
    });
</script>

