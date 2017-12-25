<?php

namespace paulzi\cmyii\admin\models;

class Layout extends \paulzi\cmyii\models\Layout
{
    public static $list;

    /**
     * @return array
     */
    public static function getList()
    {
        if (static::$list !== null) {
            return static::$list;
        }
        $all = static::findOne(1);
        if (!$all) {
            return [];
        }
        $all->populateTree();

        $data = [];
        static::fillList($all, $data);
        return static::$list = $data;
    }

    /**
     * @param \paulzi\cmyii\models\Layout $layout
     * @param array $data
     */
    protected static function fillList($layout, &$data)
    {
        foreach ($layout->children as $child) {
            $style = 'padding-left: ' . (($child->depth - 1) * 30) . 'px';
            $data[] = [
                'id'        => $child->id,
                'value'     => $child->title,
                'options'   => [
                    'style'     => $style,
                    'data-data' => ['style' => $style],
                ],
            ];
            static::fillList($child, $data);
        }
    }
}