<?php

namespace paulzi\cmyii\admin\grid;

use paulzi\cmyii\admin\components\DisplayStatesTrait;
use paulzi\cmyii\admin\components\IDisplayStates;
use paulzi\cmyii\admin\widgets\DisplayStates;
use Yii;
use yii\grid\Column;

class StatusColumn extends Column implements IDisplayStates
{
    use DisplayStatesTrait;

    /**
     * @var array
     */
    public $contentOptions = ['class' => 'lv-status-cell'];


    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $this->states = [];
        $this->addStandardStates($model);
        return DisplayStates::widget(['container' => $this]);
    }
} 