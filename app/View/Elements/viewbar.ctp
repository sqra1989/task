<?php if ($auth['role_id'] == 1): ?>
<div class="page-bar"><div class="page-toolbar"><div class="btn-group pull-right"> 
            <?php if ($rdata['Questionnaire']['status'] > 5): ?>
                <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'questionnaires', 'action' => 'print_pdf', $rdata['Questionnaire']['id'])); ?>" class="btn btn-lg green"><i class="fa fa-file-pdf-o"></i> Wydruk wniosku PDF</a>
            <?php elseif($rdata['Questionnaire']['correct_data']): ?>
                    <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'questionnaires', 'action' => 'print_pdf', $rdata['Questionnaire']['id'])); ?>" class="btn btn-lg green"><i class="fa fa-file-pdf-o"></i> Wydruk wniosku PDF (testowego)</a>
                
            <?php endif; ?>
                    <?php if ($rdata['Questionnaire']['correct_data'] ==1): ?>
                    <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'questionnaires', 'action' => 'summary_pdf', $rdata['Questionnaire']['id'])); ?>" class="btn btn-lg green" style="margin-left: 5px;"><i class="fa fa-file-pdf-o"></i> Wydruk Podsumowania</a>
                    <?php endif; ?>
                    <?php if ($rdata['Questionnaire']['status'] > 5): ?>
                    <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'decisions', 'action' => 'summary_pdf', $rdata['Questionnaire']['id'])); ?>" class="btn btn-lg green" style="margin-left: 5px;"><i class="fa fa-file-pdf-o"></i> Wydruk Decyzji</a>
                    <?php endif; ?>
        </div></div>
</div>
<?php endif; ?>
  