<?php
/**
 * @var \yii\base\View $this
 * @var \paulzi\cmyii\admin\widgets\ListView $widget
 */
?>
{panel}
{filter}
<div class="lv-items<?= $widget->grid ? ' lv-grid' : null ?>">{items}</div>
<div class="row">
    <div class="col-sm-6">{pager}</div>
    <div class="col-sm-6 hidden-xs text-right">{summary}</div>
</div>
{global}