<?php
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $widget paulzi\cmyii\admin\widgets\Area
 * @var $blocks paulzi\cmyii\admin\models\Block[]
 * @var $title string
 */
?>
<?= \paulzi\cmyii\admin\widgets\ListView::widget([
    'dataProvider'  => new \yii\data\ArrayDataProvider(['allModels' => $blocks]),
    'template'      => 'list-view/panel',
    'viewParams'    => ['title' => $title],
    'grid' => [
        'tableOptions' => ['class' => 'table table-striped'],
        'showHeader'   => false,
        'columns' => [
            ['class' => '\paulzi\cmyii\admin\grid\StatusColumn'],
            [
                'class'      => 'paulzi\cmyii\admin\grid\ViewColumn',
                'context'    => $this,
                'viewParams' => ['areaWidget' => $widget],
            ],
            ['class' => '\paulzi\cmyii\admin\grid\ActionsColumn'],
        ],
    ],
    'controllerId' => 'block',
    'actions' => function ($model, $key, $index, $listView) use ($widget) {
        /**
         * @var \paulzi\cmyii\admin\models\Block $model
         * @var \paulzi\cmyii\admin\widgets\ListView $listView
         */
        $prefix = 'block/';
        $params = ['id' => $model->id];
        if ($widget->page) {
            $params['page'] = $widget->page->id;
        } elseif ($widget->layout) {
            $params['layout'] = $widget->layout->id;
        }

        $result = $listView->defaultActionsConfig($model, $key, $index);
        $result['buttons']['update']['url'] = [$prefix . 'update'] + $params;

        if ($model->getAdminWidget()->hasData($widget->page, $widget->layout)) {
            $result['buttons']['data'] = [
                'url'   => [$prefix . 'data'] + $params,
                'icon'  => '&#xE896;',
                'label' => 'Данные',
            ];
        }

        $result['template'] = ['!toggle', '...'];

        return $result;
    },
    'globalActions' => [
        'options' => ['class' => 'actions lv-global'],
        'buttons' => [
            'create' => [
                'url' => [
                    'page'   => $widget->page   ? $widget->page->id   : null,
                    'layout' => $widget->layout ? $widget->layout->id : null,
                    'area'   => $widget->id,
                ],
            ],
        ],
        'template' => ['!toggle-on', '!toggle-off', '...'],
    ],
]) ?>