
        <div class="col-md-12 col-sm-12">

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <!--<i class="icon-user font-dark"></i>-->
                        <!--<span class="caption-subject bold uppercase">-->

                        <!--</span>-->
                    </div>
                    <!--div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                        </div>
                    </div-->
                    <div class="actions" style="float:right;">
                        <?php
                        if (isset($config['buttons'])) {
                            $akcje = '';
                            foreach ($config['buttons'] as $akcja => $ustawienia) {
                                if (is_string($ustawienia)) {
                                    $akcja = $ustawienia;
                                    $ustawienia = [];
                                }

                                if (!isset($ustawienia['id'])) {
                                    $ustawienia['id'] = $name . "." . 'id';
                                }

                                //$link = Hash::extract($result, $ustawienia['id']);
                                $link['action'] = $akcja;
                                if (isset($ustawienia['link'])) {
                                    $link = array_merge($link, $ustawienia['link']);
                                }

                                $bname = $akcja;
                                if (isset($ustawienia['name'])) {
                                    $bname = $ustawienia['name'];
                                }

                                $class = 'btn default btn-sm';

                                if (isset($ustawienia['class'])) {
                                    $class .= " " . $ustawienia['class'];
                                }

                                $options = array('class' => $class);

                                if (isset($ustawienia['options'])) {
                                    $options = array_merge($options, $ustawienia['options']);
                                }

                                $helper = "Html";
                                if (isset($ustawienia['helper'])) {
                                    $helper = $ustawienia['helper'];
                                }

                                switch ($akcja) {
                                    case 'delete':
                                        $question = 'Are you sure you want to delete %s?';
                                        if (isset($ustawienia['question'])) {
                                            $question = $ustawienia['question'];
                                        }

                                        $question_value = null;
                                        if (isset($ustawienia['question_value'])) {
                                            $question_value = Hash::get($result, $ustawienia['question_value']);
                                        }

                                        echo $this->Form->postLink(
                                                __($bname), $link, $options, __($question, $question_value)
                                        );
                                        break;
                                    case 'edit':
                                    default:
                                        echo $this->Html->link(
                                                __($bname), $link, $options
                                        );
                                }
                            }
                        } else {
//                            echo $this->AclLink->link('<i class="fa fa-plus"></i> ' . __('New %s', __(isset($config['model']) ? $config['model'] : $name)), array('action' => 'add'), array('class' => 'btn default', 'escape' => FALSE));
//                            echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add'), array('action' => 'add'), array('class' => 'btn default', 'escape' => FALSE));
                        }
                        ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo $this->element('datatable/table_init'); ?>
                </div>
            </div>
        </div>
   
