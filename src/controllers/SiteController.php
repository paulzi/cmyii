<?php

namespace paulzi\cmyii\admin\controllers;

use paulzi\cmyii\admin\models\Site;
use Yii;


/**
 * Page controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = array_merge($actions['create'], [
            'message'    => 'Сайт создан',
            'successUrl' => ['site/index'],
        ]);
        $actions['update'] = array_merge($actions['update'], [
            'successUrl' => ['site/index'],
        ]);
        $actions['delete'] = array_merge($actions['delete'], [
            'message'    => 'Сайт удалён',
            'successUrl' => ['site/index'],
        ]);
        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return Site::className();
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        return $this->render('index');
    }
}