<?php
use yii\data\ActiveDataProvider;
use paulzi\cmyii\admin\models\User;

/**
 * @var $this yii\web\View
 */
?>
<div class="tab-content">
    <?= \paulzi\cmyii\admin\widgets\ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => User::find(),
            'sort'  => [
                'attributes'   => ['username', 'email', 'created_at'],
                'defaultOrder' => ['email' => SORT_ASC],
            ],
        ]),
        'template' => 'list-view/panel',
        'viewParams' => [
            'title' => 'Пользователи',
        ],
        'grid' => [
            'tableOptions' => ['class' => 'table table-striped'],
            'columns' => [
                ['class' => '\paulzi\cmyii\admin\grid\StatusColumn'],
                'username',
                'email',
                'created_at:date',
                ['class' => '\paulzi\cmyii\admin\grid\ActionsColumn'],
            ],
        ],
    ]) ?>
</div>