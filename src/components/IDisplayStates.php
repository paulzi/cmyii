<?php

namespace paulzi\cmyii\admin\components;

use yii\base\Model;

interface IDisplayStates
{
    const STATE_SUCCESS  = 'lv-success';
    const STATE_INFO     = 'lv-info';
    const STATE_WARNING  = 'lv-warning';
    const STATE_DANGER   = 'lv-danger';


    /**
     * @param string $type
     * @param string $message
     * @param string $icon
     */
    public function addState($type, $message = null, $icon = null);

    /**
     * @return string|null
     */
    public function getMaxState();

    /**
     * @param Model $model
     */
    public function addStandardStates($model);
}