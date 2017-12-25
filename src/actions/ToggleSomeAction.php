<?php

namespace paulzi\cmyii\admin\actions;

use Yii;
use yii\db\BaseActiveRecord;

class ToggleSomeAction extends ModelAction
{
    /**
     * @var string
     */
    public $disabledAttribute = 'is_disabled';

    /**
     * @var mixed
     */
    public $targetValue = 1;

    /**
     * @var string
     */
    public $message = 'Изменено {0} из {1} элементов';


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
        $updated = $modelClass::updateAll([$this->disabledAttribute => $this->targetValue], [$modelClass::primaryKey()[0] => $ids]);

        return $this->redirectSuccess(Yii::t('app', $this->message, [$updated, count($ids)]), [$updated, $ids]);
    }
}