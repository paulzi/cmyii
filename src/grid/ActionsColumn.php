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
     * @var callable|null
     */
    public $massValue;

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

        if ($this->massName) {
            $value = $this->massValue ? call_user_func($this->massValue, $model) : $model->primaryKey;
            $value = is_array($value) ? implode('_', $value) : $value;
            $result .= Html::checkbox($this->massName, false, [
                'labelOptions' => ['class' => 'lv-mass-check lv-mass-visible'],
                'value'        => $value,
                'form'         => $this->massFormId,
            ]);
        }

        return $result;
    }
} 