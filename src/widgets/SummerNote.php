<?php

namespace paulzi\cmyii\admin\widgets;

use yii\base\Widget;

class SummerNote extends Widget
{
    public $model;
    public $attribute;


    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('summer-note/main', ['widget' => $this]);
    }
}