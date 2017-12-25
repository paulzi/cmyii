<?php

namespace paulzi\cmyii\admin\actions;

use Yii;
use yii\db\BaseActiveRecord;

class DeleteSomeAction extends ModelAction
{
    /**
     * @var bool
     */
    public $queryMode = false;

    /**
     * @var string|callable
     */
    public $operation = 'delete';

    /**
     * @var string
     */
    public $message = 'Удалено {0} из {1} элементов';


    /**
     */
    public function run()
    {
        $ids = Yii::$app->request->post('mass', []);
        if (!$ids) {
            Yii::$app->session->setFlash('error', 'Не выбрано ни одного элемента');
            return $this->controller->goBack();
        }
        /** @var BaseActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        if ($this->queryMode) {
            $deleted = $modelClass::deleteAll([$modelClass::primaryKey()[0] => $ids]);
        } else {
            $deleted = 0;
            $models = $modelClass::findAll([$modelClass::primaryKey()[0] => $ids]);
            foreach ($models as $model) {
                if (is_string($this->operation)) {
                    $result = $model->{$this->operation}();
                } else {
                    $result = call_user_func($this->operation, $model, $this);
                }
                if ($result) {
                    $deleted++;
                }
            }
        }
        return $this->redirectSuccess(Yii::t('app', $this->message, [$deleted, count($ids)]), [$deleted, $ids]);
    }
}