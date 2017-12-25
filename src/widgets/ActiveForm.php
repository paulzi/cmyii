<?php

namespace paulzi\cmyii\admin\widgets;

/**
 * @method ActiveField field($model, $attribute, $options = [])
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @inheritdoc
     */
    public $fieldClass = 'paulzi\cmyii\admin\widgets\ActiveField';
}