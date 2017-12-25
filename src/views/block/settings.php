<?php

use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \paulzi\cmyii\admin\models\Block $block
 * @var \yii\base\Model $settings
 * @var \paulzi\cmyii\admin\widgets\ActiveForm $form
 */
$widget = $block->getAdminWidget();
?>

<div class="block-form-type-data">
    <?php $templates = $block->getTemplatesData(); ?>
    <?php if (count($templates) > 1): ?>
        <?= $form->field($block, 'template')->dropDownList($templates, ['prompt' => '- выбрать -']) ?>
    <?php elseif (count($templates) === 1): ?>
        <?= Html::activeHiddenInput($block, 'template', ['value' => array_keys($templates)[0]]) ?>
    <?php endif; ?>
    <?= $widget ? $widget->renderSettings($settings, $form) : null ?>
</div>