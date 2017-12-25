<?php
use paulzi\cmyii\admin\CmyiiAdmin;
/**
 * @var yii\web\View $this
 * @var paulzi\cmyii\admin\models\Layout $layout
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'layout' => $layout,
    'active' => 'layout',
]) ?>

<div class="tab-content">
    <?= CmyiiAdmin::getInstance()->renderAdminAreasLayout(null, $layout) ?>
</div>