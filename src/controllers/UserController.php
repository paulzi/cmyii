<?php

namespace paulzi\cmyii\admin\controllers;

use paulzi\cmyii\admin\models\User;
use Yii;


/**
 * Page controller
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['toggle'] = array_merge($actions['toggle'], [
            'disabledAttribute' => 'status',
            'disableValue'      => User::STATUS_DELETED,
            'enableValue'       => User::STATUS_ACTIVE,
        ]);
        $actions['toggle-on'] = array_merge($actions['toggle-on'], [
            'targetValue' => User::STATUS_ACTIVE,
        ]);
        $actions['toggle-off'] = array_merge($actions['toggle-off'], [
            'targetValue' => User::STATUS_DELETED,
        ]);
        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return User::className();
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