<?php

namespace paulzi\cmyii\admin\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use paulzi\cmyii\Cms;
use paulzi\cmyii\admin\models\Layout;


/**
 * Page controller
 */
class LayoutController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = array_merge($actions['create'], [
            'message'   => 'Макет создан',
            'operation' => function ($model, $action) {
                /**
                 * @var Layout $model
                 * @var \paulzi\cmyii\admin\actions\CreateAction $action
                 */
                $related = $action->findModel(['id' => Yii::$app->request->get('parent')]);
                return $model->appendTo($related)->save();

            },
        ]);
        $actions['delete'] = array_merge($actions['delete'], [
            'message'   => 'Макет удален',
            'operation' => 'deleteWithChildren',
        ]);
        $actions['delete-some'] = array_merge($actions['delete-some'], [
            'operation' => 'deleteWithChildren',
        ]);
        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return Layout::className();
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        $layout = $this->findModel($id);
        return $this->render('view', ['layout' => $layout]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionLayout($id)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        $layout = $this->findModel($id);
        return $this->render('layout', ['layout' => $layout]);
    }
}