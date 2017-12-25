<?php

namespace paulzi\cmyii\admin\controllers;

use paulzi\cmyii\Cms;
use paulzi\cmyii\admin\models\Page;
use paulzi\cmyii\Cmyii;
use Yii;
use yii\web\NotFoundHttpException;


/**
 * Page controller
 */
class PageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = array_merge($actions['create'], [
            'message'   => 'Страница создана',
            'operation' => function ($model, $action) {
                /**
                 * @var Page $model
                 * @var \paulzi\cmyii\admin\actions\CreateAction $action
                 */
                $related = $action->findModel(['id' => Yii::$app->request->get('parent')]);
                return $model->appendTo($related)->save();

            },
        ]);
        $actions['delete'] = array_merge($actions['delete'], [
            'message'   => 'Страница удалена',
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
        return Page::className();
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        $page = $this->findModel($id);
        return $this->render('view', ['page' => $page]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionLayout($id)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        $page = $this->findModel($id);
        return $this->render('layout', ['page' => $page]);
    }
}