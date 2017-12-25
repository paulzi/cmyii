<?php

use yii\helpers\Html;
use yii\helpers\Url;
use paulzi\cmyii\admin\widgets\ActiveForm;
use common\models\User;

/**
 * @var $this yii\web\View
 * @var $model paulzi\cmyii\models\Page
 */
?>

<div class="panel">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput(['value' => '']) ?>
            <?= $form->field($model, 'status')->switcher(['uncheck' => User::STATUS_DELETED, 'value' => User::STATUS_ACTIVE, 'label' => 'Включён']) ?>

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