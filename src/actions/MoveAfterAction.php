<?php

namespace paulzi\cmyii\admin\actions;

use Yii;

class MoveAfterAction extends MoveBaseAction
{
    /**
     */
    public function run()
    {
        $model = $this->findModel();
        $items = $this->getItems($model, $total);
        $items = array_reverse($items);

        foreach ($items as $item) {
            $item->moveAfter($model)->save(false);
        }

        return $this->redirectSuccess(Yii::t('app', $this->message, [count($items), $total]), [$model, $items, $total]);
    }
}