<?php
use yii\data\ActiveDataProvider;

/**
 * @var $this yii\web\View
 * @var $page paulzi\cmyii\models\Page
 */
?>
<?= \paulzi\cmyii\admin\widgets\DataTabs::widget([
    'page'   => $page,
    'active' => 'view',
]) ?>

<div class="tab-content">
    <?= \paulzi\cmyii\admin\widgets\ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $page->getChildren(),
            'sort'  => false,
        ]),
        'template' => 'list-view/panel',
        'grid' => [
            'tableOptions' => ['class' => 'table table-striped'],
            'columns' => [
                ['class' => '\paulzi\cmyii\admin\grid\StatusColumn'],
                'title',
                'slug',
                ['class' => '\paulzi\cmyii\admin\grid\ActionsColumn'],
            ],
        ],
        'globalActions' => [
            'buttons' => [
                'create' => [
                    'url' => ['parent' => $page->id],
                ],
            ],
        ],
    ]) ?>
</div>