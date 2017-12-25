<?php

use yii\helpers\Html;
use yii\helpers\Url;
use paulzi\cmyii\admin\widgets\ActiveForm;
use paulzi\cmyii\admin\widgets\SummerNote;

/**
 * @var $this yii\web\View
 * @var $model \common\cmyii\text\models\Text $model
 */
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>
    <?php if ($model->block->template === 'clear'): ?>
        <?= $form->field($model, 'content')->textarea(['class' => 'form-control auto-size']) ?>
    <?php else: ?>
        <?= $form->field($model, 'content')->widget(SummerNote::className()) ?>
    <?php endif; ?>

    <div class="form-group">
        <?php if (!$model->isNewRecord): ?>
            <?= Html::submitButton('Удалить', [
                'class'        => 'btn btn-danger btn-no-validate pull-right',
                'formaction'   => Url::toRoute(['delete', 'id' => $model->id]),
                'data-sure'    => [
                    'message' => 'Вы уверены, что хотите удалить этот элемент?',
                    'button'  => 'Удалить',
                    'class'   => 'bootbox-danger',
                ],
            ]) ?>
        <?php endif; ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
