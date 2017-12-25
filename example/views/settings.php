<?php
/**
 * @var \yii\web\View $this
 * @var \common\cmyii\text\TextAdminWidget $widget
 * @var \common\cmyii\text\models\TextSettings $model
 * @var \paulzi\cmyii\admin\widgets\ActiveForm $form
 */
?>
<?= $form->field($model, 'flipOrder')->label(false)->triStateCheckbox(['Прямой порядок', 'Порядок по-умолчанию', 'Обратный порядок']); ?>

