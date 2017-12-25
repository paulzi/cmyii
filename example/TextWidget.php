<?php

namespace common\cmyii\text;

use yii\data\ActiveDataProvider;
use paulzi\cmyii\widgets\BlockWidget;
use common\cmyii\text\models\Text;

class TextWidget extends BlockWidget
{
    public $flipOrder;

    /**
     * @return \paulzi\cmyii\models\ActiveQuery
     */
    protected function getBaseQuery()
    {
        return Text::find()
            ->andWhere([
                'and',
                ['block_id' => $this->block->id],
                [
                    'or',
                    ['page_id' => $this->page ? $this->page->id : null],
                    ['page_id' => null],
                ]
            ])
            ->orderBy(['sort' => $this->flipOrder ? SORT_DESC : SORT_ASC]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $query = $this->getBaseQuery()->active();
        return $this->renderBlock([
            'widget'        => $this,
            'dataProvider'  => new ActiveDataProvider(['query' => $query]),
        ]);
    }
}