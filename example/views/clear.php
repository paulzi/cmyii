<?php
/**
 * @var \yii\web\View $this
 * @var \common\cmyii\text\TextWidget $widget
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
$iterator = $dataProvider->query->each();
?>
<?php foreach ($iterator as $model): ?>
    <?php /** @var \common\cmyii\text\models\Text $model */ ?>
    <?= $model->content ?>
<?php endforeach; ?>