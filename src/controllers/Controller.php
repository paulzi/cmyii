<?php

namespace paulzi\cmyii\admin\controllers;

use paulzi\cmyii\admin\actions\MoveAfterAction;
use paulzi\cmyii\admin\actions\MoveBeforeAction;
use Yii;
use paulzi\cmyii\admin\actions\ReorderAction;
use paulzi\cmyii\admin\actions\ToggleSomeAction;
use paulzi\cmyii\admin\CmyiiAdmin;
use paulzi\cmyii\admin\actions\CreateAction;
use paulzi\cmyii\admin\actions\ToggleAction;
use paulzi\cmyii\admin\actions\DeleteAction;
use paulzi\cmyii\admin\actions\UpdateAction;
use paulzi\cmyii\admin\actions\DeleteSomeAction;
use yii\db\BaseActiveRecord;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $modelClass = $this->getModelClass();
        $interfaces = class_implements($modelClass);

        $actions = [];

        $actions['create'] = [
            'class'      => CreateAction::className(),
            'modelClass' => $modelClass,
        ];

        $actions['update'] = [
            'class'      => UpdateAction::className(),
            'modelClass' => $modelClass,
        ];

        $actions['delete'] = [
            'class'      => DeleteAction::className(),
            'modelClass' => $modelClass,
        ];

        $actions['delete-some'] = [
            'class'      => DeleteSomeAction::className(),
            'modelClass' => $modelClass,
        ];

        if (in_array('paulzi\cmyii\admin\models\IToggleable', $interfaces)) {
            $actions['toggle'] = [
                'class'      => ToggleAction::className(),
                'modelClass' => $modelClass,
            ];
            $actions['toggle-on'] = [
                'class'       => ToggleSomeAction::className(),
                'modelClass'  => $modelClass,
                'targetValue' => 0,
            ];
            $actions['toggle-off'] = [
                'class'       => ToggleSomeAction::className(),
                'modelClass'  => $modelClass,
                'targetValue' => 1,
            ];
        }

        if (in_array('paulzi\cmyii\admin\models\ISortable', $interfaces)) {
            $actions['reorder'] = [
                'class'      => ReorderAction::className(),
                'modelClass' => $modelClass,
            ];
            $actions['move-before'] = [
                'class'      => MoveBeforeAction::className(),
                'modelClass' => $modelClass,
            ];
            $actions['move-after'] = [
                'class'      => MoveAfterAction::className(),
                'modelClass' => $modelClass,
            ];
        }

        return parent::actions() + $actions;
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        $adminWidgetClass = CmyiiAdmin::getInstance()->getAdminWidgetClassByControllerId($this->id);
        if ($adminWidgetClass) {
            /** @var \paulzi\cmyii\widgets\BlockWidget|\paulzi\cmyii\admin\widgets\BlockWidgetAdminTrait $adminWidget */
            $adminWidget = Yii::createObject($adminWidgetClass);
            return $adminWidget->getViewPath();
        }
        return parent::getViewPath();
    }

    /**
     * @param array $condition
     * @return BaseActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($condition = null)
    {
        /** @var \yii\db\BaseActiveRecord $modelClass */
        $modelClass = $this->getModelClass();
        if ($condition === null) {
            $condition = array_intersect_key(Yii::$app->request->get(), array_flip($modelClass::primaryKey()));
        }
        $model = $modelClass::findOne($condition);
        if ($model === null) {
            throw new NotFoundHttpException;
        } else {
            return $model;
        }
    }
}