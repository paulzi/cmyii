<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var \paulzi\cmyii\admin\widgets\DataTabs $widget
 * @var \paulzi\cmyii\admin\models\Block[] $blocks
 */
$controllerId = $widget->page ? 'page' : 'layout';
$id = $widget->page ? $widget->page->id : $widget->layout->id;
$isHasDisabled = false;
foreach ($blocks as $block) {
    $isHasDisabled |= $block->isDisabled;
}
$links = [
    'update' => 'Настройки',
    'view'   => $widget->page ? 'Страницы' : 'Дочерние',
    'layout' => 'Макет',
];
?>
<ul class="nav nav-tabs nav-tabs-main data-tabs">
    <?php if ($isHasDisabled): ?>
        <li class="pull-right data-tabs-switch toggle-off">
            <?= Html::switcher(null, false, [
                'data-toggle'  => 'toggle',
                'data-target'  => '.data-tabs',
                'labelOptions' => [
                    'title' => 'Показать выключенные',
                    'class' => 'has-tooltip',
                    'data-placement' => 'bottom',
                ],
            ]) ?>
    <?php endif; ?>

    <?php foreach ($links as $action => $label): ?>
        <li<?= $widget->active === $action ? ' class="active"' : null ?>>
            <?= Html::a($label, ["{$controllerId}/{$action}", 'id' => $id]) ?>
    <?php endforeach; ?>

    <?php foreach ($blocks as $block): ?>
        <?php if ($block->adminWidget->hasData($widget->page, $widget->layout)): ?>
            <?php
            $options = [];
            if ($block->isDisabled) {
                Html::addCssClass($options, 'data-tabs-disabled');
            }
            if ($widget->active === 'data-' . $block->id) {
                Html::addCssClass($options, 'active');
            }
            ?>
            <?= Html::beginTag('li', $options) ?>
                <?php
                $url = ['block/data', 'id' => $block->id];
                if ($widget->page) {
                    $url['page_id'] = $widget->page->id;
                } else {
                    $url['layout_id'] = $widget->layout->id;
                }
                ?>
                <a href="<?= Url::toRoute($url) ?>">
                    <?php if ($block->isDisabled): ?><i class="icon">&#xE8AC;</i><?php endif; ?>
                    <?= Html::encode($block->title) ?>
                </a>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>