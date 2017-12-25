<?php

namespace paulzi\cmyii\admin\actions;

use Yii;

class MoveBeforeAction extends MoveBaseAction
{
    /**
     */
    public function run()
    {
        $model = $this->findModel();
        $items = $this->getItems($model, $total);

        foreach ($items as $item) {
            $item->moveBefore($model)->save(false);
        }

        return $this->redirectSuccess(Yii::t('app', $this->message, [count($items), $total]), [$model, $items, $total]);
    }
}