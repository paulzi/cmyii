<?php

/**
 * @var \yii\web\View $this
 * @var \common\cmyii\text\models\Text $model
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'page'   => $model->page,
    'layout' => $model->page ? null : $model->block->layout,
    'area'   => $model->block->area,
    'active' => 'data-' . $model->block_id,
]) ?>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Редактирование текстового содержимого (ID <?= $model->id ?>)</h3>
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>