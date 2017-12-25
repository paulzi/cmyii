<?php
use yii\helpers\Html;
/**
 * @var \yii\base\View $this
 * @var \paulzi\cmyii\admin\widgets\ListView $widget
 */
?>
{panel}
<div class="panel">
    <?php if (!empty($title)): ?>
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($title) ?></h3>
        </div>
    <?php endif; ?>
    <div class="panel-body">
        {filter}
        <div class="lv-items<?= $widget->grid ? ' lv-grid' : null ?>">{items}</div>
        <div class="row">
            <div class="col-sm-6">{pager}</div>
            <div class="col-sm-6 hidden-xs text-right">{summary}</div>
        </div>
        {global}
    </div>
</div>