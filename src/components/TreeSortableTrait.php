<?php

namespace paulzi\cmyii\admin\components;

trait TreeSortableTrait
{
    /**
     * @inheritdoc
     */
    public function moveFirst()
    {
        /** @var \paulzi\autotree\AutoTreeTrait $this */
        return $this->prependTo($this->parent);
    }

    /**
     * @inheritdoc
     */
    public function moveLast()
    {
        /** @var \paulzi\autotree\AutoTreeTrait $this */
        return $this->appendTo($this->parent);
    }

    /**
     * @inheritdoc
     */
    public function moveBefore($element)
    {
        /** @var \paulzi\autotree\AutoTreeTrait $this */
        return $this->insertBefore($element);
    }

    /**
     * @inheritdoc
     */
    public function moveAfter($element)
    {
        /** @var \paulzi\autotree\AutoTreeTrait $this */
        return $this->insertAfter($element);
    }
}