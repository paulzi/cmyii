<?php

namespace paulzi\cmyii\admin\controllers;

use paulzi\cmyii\admin\models\LoginForm;
use paulzi\cmyii\admin\widgets\TreeMenuWidget;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;


/**
 * Page controller
 */
class DefaultController extends \yii\web\Controller
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
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->can('admin')) {
            return $this->redirect(['default/login']);
        }
        return $this->render('index');
    }

    public function actionTreeMenu($type, $id = null)
    {
        return TreeMenuWidget::widget([
            'type'  => $type,
            'id'    => $id,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::toRoute(['index']));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->response->redirect(Url::toRoute(['login']));
    }
}