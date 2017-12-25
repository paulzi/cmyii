<?php
/**
 * @var yii\web\View $this
 * @var paulzi\cmyii\models\Page $model
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'page'   => $model,
    'active' => 'update',
]) ?>

<div class="tab-content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>