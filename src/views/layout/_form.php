<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use paulzi\cmyii\admin\widgets\ActiveForm;
use paulzi\cmyii\admin\models\Layout;

/**
 * @var $this yii\web\View
 * @var $model paulzi\cmyii\models\Layout
 */
?>

<div class="panel">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'template')->textInput() ?>

        <?php /* расширение формы */ ?>
        <?php if ($template = $model->extraFormTemplate()): ?>
            <?= $this->render($template, [
                'form'  => $form,
                'model' => $model,
            ]) ?>
        <?php endif; ?>

        <div class="form-group">
            <?php if (!$model->isNewRecord): ?>
                <?= Html::submitButton('Удалить', [
                    'class'       => 'btn btn-danger btn-no-validate pull-right',
                    'formaction'  => Url::toRoute(['delete', 'id' => $model->id]),
                ]) ?>
            <?php endif; ?>
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>