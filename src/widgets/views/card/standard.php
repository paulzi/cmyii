<?php
use yii\helpers\Html;
use paulzi\cmyii\admin\widgets\DisplayStates;
/**
 * @var yii\web\View $this
 * @var string $content
 * @var paulzi\cmyii\admin\widgets\Actions $actions
 * @var paulzi\cmyii\admin\widgets\Card $widget
 */
$options = $widget->options;
$options['data-id'] = $widget->model->primaryKey;
Html::addCssClass($options, 'panel lv-item lv-standard');
Html::addCssClass($options, $widget->getMaxState());
?>
<?= Html::beginTag('div', $options) ?>
    <?php if ($widget->heading || $widget->title): ?>
        <div class="panel-heading">
            <?= DisplayStates::widget(['container' => $widget]) ?>
            <?php if ($actions): ?><?= $actions->run() ?><?php endif; ?>
            <?php if ($widget->heading): ?>
                <?= $widget->heading ?>
            <?php else: ?>
                <h3 class="panel-title"><?= Html::encode($widget->title) ?></h3>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="panel-body">
        <?php if (!$widget->heading && !$widget->title): ?>
            <?= DisplayStates::widget(['container' => $widget]) ?>
            <?php if ($actions): ?><?= $actions->run() ?><?php endif; ?>
        <?php endif; ?>
        <?= $content ?>
    </div>
    <?php if ($widget->massName && ($widget->massValue || $widget->model)): ?>
        <?= Html::checkbox($widget->massName, false, [
            'labelOptions' => ['class' => 'lv-mass-check lv-mass-visible'],
            'value'        => $widget->massValue ?: $widget->model->primaryKey,
            'form'         => $widget->listView->id . '-mass',
        ]) ?>
    <?php endif; ?>
<?= Html::endTag('div') ?>