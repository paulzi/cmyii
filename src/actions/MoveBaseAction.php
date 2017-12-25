<?php

namespace paulzi\cmyii\admin\actions;

use Yii;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;
use paulzi\cmyii\admin\models\ISortable;

class MoveBaseAction extends ModelAction
{
    /**
     * @var string
     */
    public $message = 'Перемещено {0} из {1} элементов';


    /**
     * @param BaseActiveRecord|ISortable $model
     * @param null $total
     * @return ISortable[]|BaseActiveRecord[]
     */
    protected function getItems($model, &$total = null)
    {
        $items = Json::decode(Yii::$app->request->post('items', '[]'));
        $items = array_filter($items, function ($item) use ($model) {
            return $item['entity'] === $model->className();
        });
        $total = count($items);
        $items = array_map(function ($item) { return $item['id']; }, $items);

        /** @var BaseActiveRecord[]|ISortable[] $items */
        $items = $model->find()
            ->andWhere([$model->primaryKey()[0] => $items])
            ->all();
        $items = array_filter($items, function ($item) use ($model) {
            return $model->sortableAllow($item);
        });

        return $items;
    }
}