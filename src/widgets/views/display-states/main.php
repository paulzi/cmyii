<?php
use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var \paulzi\cmyii\admin\components\DisplayStatesTrait $container
 */
?>
<?php if (count($container->states) > 1): ?>
    <button type="button" class="lv-icon">
        <?= Html::tag('i', $container::$stateIcons[$container->getMaxState()], ['class' => 'icon']) ?>
        <div class="tooltip right">
            <div class="tooltip-arrow"></div>
            <div class="tooltip-inner">
                <?php foreach ($container->states as $state): ?>
                    <div>
                        <i class="icon"><?= $state['icon'] ?: $container::$stateIcons[$state['type']] ?></i>
                        <span><?= Html::encode($state['message']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </button>
<?php elseif ($state = reset($container->states)): ?>
    <div class="lv-icon">
        <?= Html::tag('i', $state['icon'] ?: $container::$stateIcons[$state['type']], [
            'class'          => 'icon' . ($state['message'] ? ' has-tooltip' : null),
            'title'          => $state['message'] ?: null,
            'data-placement' => 'right',
        ]) ?>
    </div>
<?php endif; ?>