<?php

namespace paulzi\cmyii\admin\actions;

use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class ModelAction extends Action
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string|array
     */
    public $successUrl;


    /**
     * @param array $condition
     * @return \yii\db\BaseActiveRecord
     * @throws NotFoundHttpException
     */
    public function findModel($condition = null)
    {
        /** @var \yii\db\BaseActiveRecord $modelClass */
        $modelClass = $this->modelClass;
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

    /**
     * @param string $flash
     * @param array $arguments
     * @return \yii\web\Response
     */
    protected function redirectSuccess($flash = null, $arguments = [])
    {
        if ($flash) {
            Yii::$app->session->setFlash('success', $flash);
        }
        if ($this->successUrl) {
            if ($this->successUrl instanceof \Closure) {
                $url = call_user_func_array($this->successUrl, $arguments);
            } else {
                $url = $this->successUrl;
            }
            return $this->controller->redirect($url);
        } else {
            return $this->controller->goBack();
        }
    }
}