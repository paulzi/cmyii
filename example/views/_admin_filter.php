<?php
use paulzi\cmyii\admin\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \yii\base\Model $model
 * @var \paulzi\cmyii\admin\widgets\ListView $widget
 */
?>
<?php $form = ActiveForm::begin([
    'id'      => $widget->id . '-filter',
    'options' => [
        'class' => 'collapse panel panel-default'
    ],
]); ?>

    <div class="panel-heading">
        <h3 class="panel-title">Фильтр</h3>
    </div>

    <div class="panel-body">
        <?= $form->field($model, 'q') ?>

        <div class="form-group">
            <button type="submit" class="btn btn-default">Найти</button>
        </div>
    </div>
<?php ActiveForm::end(); ?>
