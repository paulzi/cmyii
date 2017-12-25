<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use paulzi\cmyii\admin\widgets\ActiveForm;
use paulzi\cmyii\admin\models\Layout;

/**
 * @var $this yii\web\View
 * @var $model \paulzi\cmyii\models\Page
 */
?>

<div class="panel">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?php if ($model->isNewRecord || !$model->isRoot()): ?>
            <?= $form->field($model, 'slug')->textInput() ?>
        <?php endif; ?>
        <?= $form->field($model, 'link')->textInput() ?>
        <?= $form->field($model, 'layout_id')->dropDownList(
            ArrayHelper::map(Layout::getList(), 'id', 'value'),
            [
                'class'         => 'select-style',
                'prompt'        => 'Наследовать',
                'placeholder'   => 'Наследовать',
                'encodeSpaces'  => true,
                'options'       => ArrayHelper::map(Layout::getList(), 'id', 'options'),
            ]
        ) ?>
        <?= $form->field($model, 'roles')->hint('список ролей через запятую (* - доступен всем, ? - доступен неавторизированным, @ - доступен авторизованным)')->textInput() ?>
        <?= $form->field($model, 'is_disabled')->switcher(['uncheck' => '1', 'value' => '', 'label' => 'Включён']) ?>

        <div class="panel-group" id="page-form-accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-collapse">
                <div class="panel-heading" role="tab" id="page-form-accordion-seo-heading">
                    <h5 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#page-form-accordion" href="#page-form-accordion-seo" aria-expanded="false" aria-controls="page-form-accordion-seo">
                            <i class="icon icon-more">&#xE5CF;</i>
                            SEO параметры
                        </a>
                    </h5>
                </div>
                <div id="page-form-accordion-seo" class="collapse" role="tabpanel" aria-labelledby="page-form-accordion-seo-heading">
                    <div class="panel-body">
                        <?= $form->field($model, 'seoTitle')->textInput() ?>
                        <?= $form->field($model, 'seoH1')->textInput() ?>
                        <?= $form->field($model, 'seoDescription')->textInput() ?>
                        <?= $form->field($model, 'seoKeywords')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>

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