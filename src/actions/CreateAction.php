<?php

namespace paulzi\cmyii\admin\actions;

use Yii;

class CreateAction extends ModelAction
{
    /**
     * @var string|callable
     */
    public $operation = 'save';

    /**
     * @var string
     */
    public $message = 'Элемент создан';


    /**
     */
    public function run()
    {
        $modelClass = $this->modelClass;
        /** @var \yii\db\BaseActiveRecord $model */
        $model = new $modelClass;
        $model->setAttributes(Yii::$app->request->get());
        if ($model->load(Yii::$app->request->post())) {
            if (is_string($this->operation)) {
                $result = $model->{$this->operation}();
            } else {
                $result = call_user_func($this->operation, $model, $this);
            }
            if ($result) {
                return $this->redirectSuccess(Yii::t('app', $this->message), [$model]);
            }
        }
        return $this->controller->render('create', ['model' => $model]);
    }
}