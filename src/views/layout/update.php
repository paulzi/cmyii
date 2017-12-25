<?php
/**
 * @var yii\web\View $this
 * @var paulzi\cmyii\models\Layout $model
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'layout' => $model,
    'active' => 'update',
]) ?>

<div class="tab-content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>