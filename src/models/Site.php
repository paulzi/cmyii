<?php

namespace paulzi\cmyii\admin\models;

use paulzi\sortable\SortableBehavior;
use paulzi\sortable\SortableTrait;

class Site extends \paulzi\cmyii\models\Site implements IToggleable, ISortable
{
    use SortableTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => SortableBehavior::className(),
                'query' => [],
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getIsDisabled()
    {
        return $this->is_disabled;
    }

    /**
     * @inheritdoc
     */
    public function getSortablePosition()
    {
        return $this->sort;
    }

    /**
     * @return array
     */
    public function sortableCopyCond()
    {
        return [
            'and',
            ['entity' => $this->className()],
            ['<>', 'id', $this->id],
        ];
    }

    /**
     * @param self $item
     * @return bool
     */
    public function sortableAllow($item)
    {
        return $item->id !== $this->id;
    }
}