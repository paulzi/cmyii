<?php
/**
 * @var \yii\web\View $this
 * @var \common\cmyii\text\TextWidget $widget
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
$iterator = $dataProvider->query->each();
?>
<div class="container">
    <?php foreach ($iterator as $model): ?>
        <?php /** @var \common\cmyii\text\models\Text $model */ ?>
        <div class="text">
            <div class="text__inner">
                <?= $model->content ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
