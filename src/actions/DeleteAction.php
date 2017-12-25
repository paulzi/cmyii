<?php

namespace paulzi\cmyii\admin\actions;

use Yii;
use yii\db\Exception;

class DeleteAction extends ModelAction
{
    /**
     * @var string|callable
     */
    public $operation = 'delete';

    /**
     * @var string
     */
    public $message = 'Элемент удалён';


    /**
     */
    public function run()
    {
        $model = $this->findModel();
        if (is_string($this->operation)) {
            $result = $model->{$this->operation}();
        } else {
            $result = call_user_func($this->operation, $model, $this);
        }
        if (!$result) {
            throw new Exception('Delete error');
        }
        return $this->redirectSuccess(Yii::t('app', $this->message), [$model]);
    }
}