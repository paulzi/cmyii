<?php

namespace paulzi\cmyii\admin\actions;

use Yii;

class UpdateAction extends ModelAction
{
    /**
     * @var string|callable
     */
    public $operation = 'save';

    /**
     * @var string
     */
    public $message = 'Изменения сохранены';


    /**
     */
    public function run()
    {
        $model = $this->findModel();
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
        return $this->controller->render('update', ['model' => $model]);
    }
}