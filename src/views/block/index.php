<?php
/**
 * @var $this yii\web\View
 * @var $area string
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'area'     => $area,
    'active'   => 'layout',
    'template' => 'data-tabs/inline',
]) ?>
<div class="tab-content">
    <?= \paulzi\cmyii\admin\widgets\Area::widget([
        'id'    => $area,
        'title' => 'Внедрённая область',
    ]) ?>
</div>