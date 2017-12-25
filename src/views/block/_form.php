<?php
use yii\helpers\Html;
use yii\helpers\Url;
use paulzi\cmyii\admin\widgets\ActiveForm;
use paulzi\cmyii\admin\CmyiiAdmin;

/**
 * @var yii\web\View $this
 * @var \paulzi\cmyii\admin\models\Block $block
 * @var \paulzi\cmyii\models\BlockState $state
 * @var \yii\base\Model $settings
 * @var \paulzi\cmyii\admin\models\Page $page
 * @var \paulzi\cmyii\admin\models\Layout $layout
 */
$state->state          = $state->state          !== null ? (int)$state->state          : null;
$state->state_children = $state->state_children !== null ? (int)$state->state_children : null;
?>

<div class="panel">
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'block-form'],
        ]); ?>
            <?= Html::activeHiddenInput($block, 'id') ?>
            <?= $form->field($block, 'widget_class')->dropDownList(CmyiiAdmin::getInstance()->getWidgetsListData(), [
                'prompt' => '- выбрать -',
                'class'  => 'block-form-class',
                'data'   => [
                    'settings' => Url::toRoute(['settings',
                        'block'  => $block->id,
                        'page'   => $page ? $page->id : null,
                        'layout' => $layout ? $layout->id : null,
                    ]),
                ],
            ]) ?>
            <?= $form->field($block, 'title')->textInput(['class' => 'form-control block-form-title']) ?>

            <?php if ($page || $layout): ?>
                <?= $form->field($block, 'is_inherit')->label(false)->triStateSwitcher(['Не наследовать', 'Наследовать'], ['values' => ['', '1']]) ?>

                <?php $stateLabel = $block->isDisabled ? 'выключен' : 'включён'; ?>
                <?= $form->field($state, 'state')->label(false)->triStateSwitcher(['Выключен на текущей странице', "Состояние на текущей странице унаследовано ({$stateLabel})", 'Включен на текущей странице']) ?>
                <?= $form->field($state, 'state_children')->label(false)->triStateSwitcher(['Выключен на дочерних страницах', "Состояние на дочерних страницах унаследовано ({$stateLabel})", 'Включен на дочерних страницах']) ?>
            <?php else: ?>
                <?= $form->field($state, 'state')->label(false)->triStateSwitcher(['Выключен', 'Включен'], ['values' => ['0', '']]) ?>
            <?php endif; ?>
            <?= $form->field($state, 'roles')->hint('список ролей через запятую (* - доступен всем, ? - доступен неавторизированным, @ - доступен авторизованным)')->textInput() ?>

            <?php /* расширение формы */ ?>
            <?php if ($template = $model->extraFormTemplate()): ?>
                <?= $this->render($template, [
                    'form'  => $form,
                    'block' => $block,
                    'state' => $state,
                ]) ?>
            <?php endif; ?>

            <?= $this->render('settings', [
                'block'    => $block,
                'settings' => $settings,
                'form'     => $form,
            ]) ?>

            <div class="form-group">
                <?php if (!$block->isNewRecord): ?>
                    <?= Html::submitButton('Удалить', [
                        'class'       => 'btn btn-danger btn-no-validate pull-right',
                        'formaction'  => Url::toRoute(['delete', 'id' => $block->id]),
                    ]) ?>
                <?php endif; ?>
                <?= Html::submitButton($block->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>