<?php
/**
 * @var yii\web\View $this
 * @var paulzi\cmyii\models\Page $page
 * @var paulzi\cmyii\models\Layout $layout
 * @var paulzi\cmyii\admin\models\Block $block
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'page'   => $page,
    'layout' => $layout,
    'area'   => $block->area,
    'active' => 'data-' . $block->id,
]) ?>

<div class="tab-content">
    <?= $block->adminWidget->run() ?>
</div>