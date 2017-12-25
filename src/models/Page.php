<?php

namespace paulzi\cmyii\admin\models;

use paulzi\cmyii\admin\components\TreeSortableTrait;

class Page extends \paulzi\cmyii\models\Page implements IToggleable, ISortable, IMarkable
{
    use TreeSortableTrait;

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
            [
                'entity'    => $this->className(),
                'parent_id' => $this->parent_id,
            ],
            ['<>', 'id', $this->id],
        ];
    }

    /**
     * @param self $item
     * @return bool
     */
    public function sortableAllow($item)
    {
        return $item->parent_id === $this->parent_id && $item->id !== $this->id;
    }

    /**
     * @return array
     */
    public function markData()
    {
        return [
            'entity'    => $this->className(),
            'id'        => $this->id,
            'parent_id' => $this->parent_id,
        ];
    }
}