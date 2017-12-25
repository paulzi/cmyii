<?php
/**
 * @var \yii\web\View $this
 * @var \common\cmyii\text\TextAdminWidget $widget
 * @var \common\cmyii\text\models\TextFilter $filter
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
?>
<?= \paulzi\cmyii\admin\widgets\ListView::widget([
    'dataProvider'  => $dataProvider,
    'filter'        => $filter,
    'itemView'      => '_admin_item',
    'filterView'    => '_admin_filter',
    'controllerId'  => 'text',
    'globalActions' => [
        'buttons' => [
            'create' => [
                'url' => [
                    'page_id'  => $widget->page ? $widget->page->id : null,
                    'block_id' => $widget->block->id,
                ],
            ],
        ],
    ],
]) ?>