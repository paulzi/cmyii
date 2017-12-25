<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\cmyii\admin\grid\ActionsColumn;
use paulzi\cmyii\admin\models\IMarkable;
use paulzi\cmyii\admin\models\ISortable;
use paulzi\cmyii\admin\models\IToggleable;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;

class ListView extends \yii\widgets\ListView
{
    /**
     * @var array
     */
    public $options = ['class' => 'lv lv-mass-off lv-reorder-off'];

    /**
     * @var array
     */
    public $itemOptions = ['tag' => false];

    /**
     * @var
     */
    public $controllerId;

    /**
     * array
     */
    public $grid;

    /**
     * @var callable|Actions|array
     */
    public $actions = [];

    /**
     * @var Actions|array|false
     */
    public $panelActions = [];

    /**
     * @var Actions|array|false
     */
    public $globalActions = [];

    /**
     * @var Model
     */
    public $filter;

    /**
     * @var string
     */
    public $filterView;

    /**
     * @var string
     */
    public $template = 'list-view/main';

    /**
     * @var bool
     */
    public $showOnEmpty = true;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = $this->render($this->template, array_merge(['widget' => $this], $this->viewParams));
        parent::init();
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param integer $index
     * @return Actions
     * @throws \yii\base\InvalidConfigException
     */
    public function getItemActions($model, $key, $index)
    {
        $actions = $this->actions;
        if (is_callable($actions)) {
            $actions = call_user_func($actions, $model, $key, $index, $this);
        } elseif (!is_object($actions)) {
            $actions = ArrayHelper::merge($this->defaultActionsConfig($model, $key, $index), $actions);
        }
        if (!is_object($actions)) {
            if (!isset($actions['class'])) {
                $actions['class'] = Actions::className();
            }
            $actions = \Yii::createObject($actions);
        }

        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{panel}':
                return $this->renderPanel();
            case '{filter}':
                return $this->renderFilter();
            case '{global}':
                return $this->renderGlobal();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * @return string
     */
    public function renderPanel()
    {
        if ($this->panelActions === false) {
            return null;
        }
        $result = null;
        $result .= Html::beginTag('div', ['class' => 'lv-panel']);
        $actions = $this->panelActions;
        if (!is_object($actions)) {
            $actions = ArrayHelper::merge($this->defaultPanelActionsConfig(), $actions);
            if (!isset($actions['class'])) {
                $actions['class'] = Actions::className();
            }
            $actions = \Yii::createObject($actions);
        }
        Html::addCssClass($actions->options, 'pull-right');
        $result .= $actions->run();
        $result .= Html::endTag('div');
        return $result;
    }

    /**
     * @return string
     */
    public function renderFilter()
    {
        if (!$this->filter || !$this->filterView) {
            return null;
        }
        return $this->getView()->render($this->filterView, [
            'model'  => $this->filter,
            'widget' => $this,
        ]);
    }

    /**
     * @return string
     */
    public function renderGlobal()
    {
        if ($this->globalActions === false) {
            return null;
        }
        $actions = $this->globalActions;
        if (!is_object($actions)) {
            $actions = ArrayHelper::merge($this->defaultGlobalActionsConfig(), $actions);
            if (!isset($actions['class'])) {
                $actions['class'] = Actions::className();
            }
            $actions = \Yii::createObject($actions);
        }
        return $actions->run();
    }

    /**
     * @inheritdoc
     */
    public function renderItems()
    {
        if ($this->grid) {
            $config = array_merge(
                [
                    'class' => GridView::className(),
                    'rowOptions' => ['class' => 'lv-item'],
                ],
                $this->grid,
                ['dataProvider' => $this->dataProvider]
            );
            /** @var GridView $gridView */
            $gridView = \Yii::createObject($config);
            foreach ($gridView->columns as $column) {
                if ($column instanceof ActionsColumn) {
                    if ($column->massFormId === null) {
                        $column->massFormId = $this->id . '-mass';
                    }
                    if ($column->actions === null) {
                        $column->actions = function ($model, $key, $index) {
                            return $this->getItemActions($model, $key, $index);
                        };
                    }
                }
            }
            return $gridView->renderItems();
        } else {
            return parent::renderItems();
        }
    }

    /**
     * @inheritdoc
     */
    public function renderItem($model, $key, $index)
    {
        $this->viewParams['actions'] = $this->getItemActions($model, $key, $index);
        return parent::renderItem($model, $key, $index);
    }

    /**
     * @param BaseActiveRecord $model
     * @param mixed $key
     * @param integer $index
     * @return array
     */
    public function defaultActionsConfig($model, $key, $index)
    {
        $prefix = $this->controllerId ? $this->controllerId . '/' : null;
        $params = $model->getPrimaryKey(true);

        $buttons = [];

        if ($model instanceof IMarkable) {
            $buttons['mark'] = [
                'url'     => '#',
                'icon'    => '&#xE86C;',
                'label'   => 'Выбрать для...',
                'options' => [
                    'class' => 'pz-copy',
                    'data'  => [
                        'pz-copy' => $model->markData(),
                    ],
                ],
            ];
        }

        if ($model instanceof ISortable) {
            $buttons['move-before'] = [
                'tag'         => 'button',
                'icon'        => '&#xE5DA;',
                'label'       => 'Переместить до',
                'iconOptions' => ['class' => 'icon-flip-v'],
                'options'     => [
                    'class'      => 'pz-copy-cond pz-copy-param',
                    'formaction' => Url::toRoute([$prefix . 'move-before'] + $params),
                    'data'       => [
                        'pz-copy-cond' => $model->sortableCopyCond(),
                    ],
                ],
            ];
            $buttons['move-after'] = [
                'tag'         => 'button',
                'url'         => [$prefix . 'move-after'] + $params,
                'icon'        => '&#xE5DA;',
                'label'       => 'Переместить после',
                'options'     => [
                    'class'      => 'pz-copy-cond pz-copy-param',
                    'formaction' => Url::toRoute([$prefix . 'move-after'] + $params),
                    'data'       => [
                        'pz-copy-cond' => $model->sortableCopyCond(),
                    ],
                ],
            ];
        }

        if ($model instanceof IToggleable) {
            $isDisabled = $model->getIsDisabled();
            $buttons['toggle'] = [
                'url'   => [$prefix . 'toggle'] + $params,
                'icon'  => $isDisabled ? '&#xE8F4;' : '&#xE8F5;',
                'label' => $isDisabled ? 'Включить' : 'Выключить',
            ];
        }
        $buttons['update'] = [
            'url'   => [$prefix . 'update'] + $params,
            'icon'  => '&#xE3C9;',
            'label' => 'Редактировать',
        ];
        $buttons['delete'] = [
            'url'     => [$prefix . 'delete'] + $params,
            'icon'    => '&#xE872;',
            'label'   => 'Удалить',
            'options' => [
                'data' => [
                    'method' => 'post',
                    'sure'   => [
                        'message' => 'Вы уверены, что хотите удалить этот элемент?',
                        'button'  => 'Удалить',
                        'class'   => 'bootbox-danger',
                    ],
                ],
            ],
        ];

        return [
            'useForm' => true,
            'options' => [
                'class' => 'actions lv-item-actions',
            ],
            'buttons' => $buttons,
        ];
    }

    /**
     * @return array
     */
    public function defaultPanelActionsConfig()
    {
        $models  = $this->dataProvider->getModels();
        $model   = isset($models[0]) ? $models[0] : null;
        $buttons = [];

        $buttons['select-mode'] = [
            'url'     => '#',
            'icon'    => '&#xE877;',
            'label'   => 'Режим выделения',
            'options' => ['class' => 'lv-mass-toggler']
        ];

        if ($model instanceof ISortable) {
            $buttons['reorder'] = [
                'url'     => '#',
                'icon'    => '&#xE8D5;',
                'label'   => 'Изменить порядок',
                'options' => ['class' => 'lv-reorder-toggler']
            ];
        }

        if ($this->filterView) {
            $buttons['filter'] = [
                'url'     => '#' . $this->id . '-filter',
                'icon'    => '&#xE8B6;',
                'label'   => 'Поиск и фильтр',
                'options' => ['data-toggle' => 'collapse']
            ];
        }

        // sort button
        $sort = $this->dataProvider->getSort();
        if ($sort && $sort->attributes) {
            $sortDropDown = [];
            foreach ($sort->attributes as $attribute => $params) {
                $turn = $sort->getAttributeOrder($attribute);
                $sortDropDown[$attribute] = [
                    'url'   => $sort->createUrl($attribute),
                    'icon'  => $turn === null ? '&nbsp;' : ($turn === SORT_DESC ? '&#xE5DB;' : '&#xE5D8;'),
                    'label' => !empty($params['label']) ? $params['label'] : Inflector::camel2words($attribute),
                ];
            }
            $buttons['sort'] = [
                'url'   => '#',
                'icon'  => '&#xE164;',
                'label' => 'Сортировка',
                'dropdown' => $sortDropDown,
            ];
        }

        return [
            'buttons' => $buttons,
            'fixed'   => ['select-mode', 'reorder', 'filter', 'sort'],
        ];
    }

    /**
     * @return array
     */
    public function defaultGlobalActionsConfig()
    {
        $models  = $this->dataProvider->getModels();
        $model   = isset($models[0]) ? $models[0] : null;
        $buttons = [];
        $prefix  = $this->controllerId ? $this->controllerId . '/' : null;

        $buttons['create'] = [
            'url'     => [$prefix . 'create'],
            'icon'    => '&#xE145;',
            'label'   => 'Создать',
            'options' => ['class' => 'btn btn-info btn-icon lv-mass-hidden lv-reorder-hidden'],
        ];
        if ($model instanceof ISortable) {
            $buttons['reorder'] = [
                'tag'     => 'button',
                'icon'    => '&#xE161;',
                'label'   => 'Сохранить',
                'options' => [
                    'class'      => 'btn btn-info btn-icon lv-reorder-visible',
                    'type'       => 'submit',
                    'formaction' => Url::toRoute([$prefix . 'reorder']),
                ],
            ];
        }
        $buttons['select-all'] = [
            'icon'    => '&#xE162;',
            'label'   => 'Выбрать всё',
            'options' => [
                'class' => 'btn btn-default btn-icon lv-mass-visible lv-mass-all',
            ],
        ];
        if ($model instanceof IMarkable) {
            $buttons['mark'] = [
                'url'     => '#',
                'icon'    => '&#xE86C;',
                'label'   => 'Выбрать для...',
                'options' => [
                    'class' => 'btn btn-default btn-icon lv-mass-visible lv-mass-copy',
                    'data'  => [
                        'message' => 'Элементы выбраны',
                    ],
                ],
            ];
        }
        if ($model instanceof IToggleable) {
            $buttons['toggle-on'] = [
                'tag'     => 'button',
                'icon'    => '&#xE8F4;',
                'label'   => 'Включить',
                'options' => [
                    'class'      => 'btn btn-default btn-icon lv-mass-visible',
                    'type'       => 'submit',
                    'formaction' => Url::toRoute([$prefix . 'toggle-on']),
                ],
            ];
            $buttons['toggle-off'] = [
                'tag'     => 'button',
                'icon'    => '&#xE8F5;',
                'label'   => 'Выключить',
                'options' => [
                    'class'      => 'btn btn-default btn-icon lv-mass-visible',
                    'type'       => 'submit',
                    'formaction' => Url::toRoute([$prefix . 'toggle-off']),
                ],
            ];
        }
        $buttons['delete'] = [
            'tag'     => 'button',
            'icon'    => '&#xE872;',
            'label'   => 'Удалить',
            'options' => [
                'class'      => 'btn btn-danger btn-icon lv-mass-visible',
                'type'       => 'submit',
                'formaction' => Url::toRoute([$prefix . 'delete-some']),
                'data-sure'   => [
                    'message' => 'Вы уверены, что хотите удалить этот элемент?',
                    'button'  => 'Удалить',
                    'class'   => 'bootbox-danger',
                ],
            ],
        ];

        return [
            'useForm' => true,
            'options' => [
                'id'    => $this->id . '-mass',
                'class' => 'actions lv-global global-actions'
            ],
            'buttons' => $buttons,
            'fixed' => ['create', 'reorder', 'select-all', 'mark', 'toggle-on', 'toggle-off', 'delete'],
        ];
    }
}