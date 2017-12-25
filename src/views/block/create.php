<?php
/**
 * @var yii\web\View $this
 * @var \paulzi\cmyii\admin\models\Block $block
 * @var \paulzi\cmyii\models\BlockState $state
 * @var \yii\base\Model $settings
 * @var \paulzi\cmyii\admin\models\Page $page
 * @var \paulzi\cmyii\admin\models\Layout $layout
 * @var string $settings
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'page'   => $page,
    'layout' => $layout,
    'area'   => $block->area,
    'active' => 'layout',
]) ?>
<div class="tab-content">
    <?= $this->render('_form', [
        'block'    => $block,
        'state'    => $state,
        'settings' => $settings,
        'page'     => $page,
        'layout'   => $layout,
    ]) ?>
</div>