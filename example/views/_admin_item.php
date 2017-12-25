<?php
use paulzi\cmyii\admin\widgets\Card;

/**
 * @var yii\web\View $this
 * @var \common\cmyii\text\models\Text $model
 * @var paulzi\cmyii\admin\widgets\ListView $widget
 * @var paulzi\cmyii\admin\widgets\Actions $actions
 */
?>
<?php Card::begin([
    'listView' => $widget,
    'model'    => $model,
    'actions'  => $actions,
]); ?>
    <?= $model->content ?>
<?php Card::end(); ?>