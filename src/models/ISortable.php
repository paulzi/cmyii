<?php

namespace paulzi\cmyii\admin\models;

interface ISortable
{
    /**
     * @return integer
     */
    public function getSortablePosition();

    /**
     * @return $this
     */
    public function moveFirst();

    /**
     * @return $this
     */
    public function moveLast();

    /**
     * @param mixed $element
     * @return $this
     */
    public function moveBefore($element);

    /**
     * @param mixed $element
     * @return $this
     */
    public function moveAfter($element);

    /**
     * @return array
     */
    public function sortableCopyCond();

    /**
     * @param self $item
     * @return bool
     */
    public function sortableAllow($item);
}