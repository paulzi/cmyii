<?php

namespace paulzi\cmyii\admin\actions;

use Yii;

class ToggleAction extends ModelAction
{
    /**
     * @var string
     */
    public $disabledAttribute = 'is_disabled';

    /**
     * @var mixed
     */
    public $disableValue = 1;

    /**
     * @var mixed
     */
    public $enableValue = 0;


    /**
     */
    public function run()
    {
        $model = $this->findModel();
        $value = $model->getAttribute($this->disabledAttribute);
        if ($value === $this->enableValue) {
            $value   = $this->disableValue;
            $message = 'Элемент отключён';
        } else {
            $value   = $this->enableValue;
            $message = 'Элемент включён';
        }
        $model->setAttribute($this->disabledAttribute, $value);
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', Yii::t('app', $message));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения'));
        }
        return $this->redirectSuccess(null, [$model]);
    }
}