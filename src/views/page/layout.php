<?php
use paulzi\cmyii\admin\CmyiiAdmin;
/**
 * @var $this yii\web\View
 * @var $page paulzi\cmyii\admin\models\Page
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'page'   => $page,
    'active' => 'layout',
]) ?>

<div class="tab-content">
    <?= CmyiiAdmin::getInstance()->renderAdminAreasLayout($page, null) ?>
</div>