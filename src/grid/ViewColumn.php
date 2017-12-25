<?php

namespace paulzi\cmyii\admin\grid;

use yii\grid\Column;

class ViewColumn extends Column
{
    /**
     * @var string
     */
    public $itemView = '_item';

    /**
     * @var array
     */
    public $viewParams = [];

    /**
     * @var object
     */
    public $context;

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content === null) {
            return \Yii::$app->view->render($this->itemView, array_merge([
                'model'  => $model,
                'key'    => $key,
                'index'  => $index,
                'column' => $this,
            ], $this->viewParams), $this->context);
        } else {
            return parent::renderDataCellContent($model, $key, $index);
        }
    }
}