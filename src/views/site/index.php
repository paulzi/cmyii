<?php
use yii\data\ActiveDataProvider;
use paulzi\cmyii\admin\models\Site;

/**
 * @var $this yii\web\View
 */
?>
<div class="tab-content">
    <?= \paulzi\cmyii\admin\widgets\ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => Site::find()->orderBy(['sort' => SORT_ASC]),
            'sort'  => false,
        ]),
        'template' => 'list-view/panel',
        'viewParams' => [
            'title' => 'Сайты',
        ],
        'grid' => [
            'tableOptions' => ['class' => 'table table-striped'],
            'columns' => [
                ['class' => '\paulzi\cmyii\admin\grid\StatusColumn'],
                'title',
                ['class' => '\paulzi\cmyii\admin\grid\ActionsColumn'],
            ],
        ],
    ]) ?>
</div>