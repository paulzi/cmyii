<?php
use yii\helpers\Html;
use yii\helpers\Url;
use paulzi\cmyii\admin\assets\SummerNoteAsset;

/**
 * @var \yii\web\View $this
 * @var \paulzi\cmyii\admin\widgets\SummerNote $widget
 */
?>
<script type="text/template" class="pz-area-template">
    <div class="pz-area" contentEditable="false">
        <a href="<?= Url::toRoute(['block/index', 'area' => '%area']) ?>" class="btn btn-default modal-remote modal-remote-iframe">Редактировать область</a>
    </div>
</script>
<?= Html::activeTextarea($widget->model,  $widget->attribute, [
    'class' => 'summer-note summer-note-area',
]) ?>
