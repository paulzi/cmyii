<?php

namespace paulzi\cmyii\admin\grid;

use Yii;
use yii\bootstrap\Html;
use yii\grid\Column;

class ActionsColumn extends Column
{
    /**
     * @var callable
     */
    public $actions;

    /**
     * @var string
     */
    public $massName = 'mass[]';

    /**
     * @var string
     */
    public $massFormId;

    /**
     * @var array
     */
    public $contentOptions = ['class' => 'lv-mass-check-cell'];


    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $result = null;

        if ($this->actions && ($actions = call_user_func($this->actions, $model, $key, $index))) {
            $result .= $actions->run();
        }

        $result .= Html::checkbox($this->massName, false, [
            'labelOptions' => ['class' => 'lv-mass-check lv-mass-visible'],
            'value'        => $model->primaryKey,
            'form'         => $this->massFormId,
        ]);

        return $result;
    }
} 