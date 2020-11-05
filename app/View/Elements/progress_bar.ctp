<?php if (!isset($adminView)): ?>
    <ul class="progress-bar-list hidden-xs">
        <li class="<?php if ($step >= 1): ?>active<?php endif; ?> <?php if (isset($current) && $current == 1): ?>current<?php endif; ?>">
            <i>1</i>
            <span><?php echo __('Nowy wniosek'); ?></span>
        </li>

        <li class="<?php if ($step >= 2): ?>active<?php endif; ?> <?php if (isset($current) && $current == 2): ?>current<?php endif; ?>">
            <i>2</i>
            <span><?php echo __('Wypełnij wniosek'); ?></span>
        </li>
        <li class="<?php if ($step >= 3): ?>active<?php endif; ?> <?php if (isset($current) && $current == 3): ?>current<?php endif; ?>">
            <i>3</i>
            <span><?php echo __('Wyślij wniosek'); ?></span>
        </li>
         <li class="<?php if ($step >= 4): ?>active<?php endif; ?> <?php if (isset($current) && $current == 4): ?>current<?php endif; ?>">
            <i>4</i>
            <span><?php echo __('Decyzja'); ?></span>
        </li>

    </ul>
    <div class="progress-bar-mobile visible-xs">
        <i>Krok <?php echo $step; ?>/7</i>
        <span>
            <?php if ($step == 1): ?><?php echo __('Nowy wniosek'); ?><?php endif; ?>
            <?php if ($step == 2): ?><?php echo __('Wypełnij wniosek'); ?><?php endif; ?>
            <?php if ($step == 3): ?><?php echo __('Wyślij wniosek'); ?><?php endif; ?>
            <?php if ($step == 4): ?><?php echo __('Decyzja'); ?><?php endif; ?>
        </span>
    </div>
<?php endif; ?>