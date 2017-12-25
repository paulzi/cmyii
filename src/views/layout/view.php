<?php
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var paulzi\cmyii\models\Layout $layout
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'layout' => $layout,
    'active' => 'view',
]) ?>

<div class="tab-content">
    <?= \paulzi\cmyii\admin\widgets\ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $layout->getChildren(),
            'sort'  => false,
        ]),
        'template' => 'list-view/panel',
        'grid' => [
            'tableOptions' => ['class' => 'table table-striped'],
            'columns' => [
                ['class' => '\paulzi\cmyii\admin\grid\StatusColumn'],
                'title',
                'template',
                ['class' => '\paulzi\cmyii\admin\grid\ActionsColumn'],
            ],
        ],
        'globalActions' => [
            'buttons' => [
                'create' => [
                    'url' => ['parent' => $layout->id],
                ],
            ],
        ],
    ]) ?>
</div>