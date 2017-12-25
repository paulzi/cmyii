<?php
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $areaWidget paulzi\cmyii\admin\widgets\Area
 * @var $model paulzi\cmyii\admin\models\Block
 */
$isInheritPage   = $model->page_id   && (!$areaWidget->page   || $areaWidget->page->id   !== $model->page_id);
$isInheritLayout = $model->layout_id && (!$areaWidget->layout || $areaWidget->layout->id !== $model->layout_id);
$templates = $model->adminWidget->getAdminTemplates();
?>
<h5>
    <?= Html::encode($model->title) ?><br>
    <small>
        <?= Html::encode($model->adminWidget ? $model->adminWidget->getAdminTitle() : $model->widget_class) ?>
        <?php if ($model->template): ?>
            (шаблон «<?= Html::encode(isset($templates[$model->template]) ? $templates[$model->template] : $model->template) ?>»)
        <?php endif; ?>
    </small>
</h5>
<?php if ($isInheritPage): ?>
    <span class="label label-default">Наследовано</span>
    <small>Страница «<?= Html::encode($model->page->title) ?>»</small>
<?php endif; ?>
<?php if ($isInheritLayout): ?>
    <span class="label label-default">Наследовано</span>
    <small>Макет «<?= Html::encode($model->layout->title) ?>»</small>
<?php endif; ?>